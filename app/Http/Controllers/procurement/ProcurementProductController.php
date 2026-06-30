<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementProduct;
use App\Models\procurement\ProcurementItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProcurementProductController extends Controller
{
    public function index()
    {
        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-products-page'
        ];

        // Get categories for filter
        $categories = ProcurementProduct::whereNotNull('category')
                                      ->distinct()
                                      ->pluck('category')
                                      ->sort();

        return view('content.digitize.procurement.products.index', [
            'pageConfigs' => $pageConfigs,
            'categories' => $categories
        ]);
    }

    public function data(Request $request)
    {
        $query = ProcurementProduct::select('procurement_products.*');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        return DataTables::of($query)
            ->addColumn('product_info', function ($product) {
                $info = $product->product_name;
                if ($product->product_code) {
                    $info = $product->product_code . ' - ' . $info;
                }
                return $info;
            })
            ->addColumn('category_badge', function ($product) {
                if (!$product->category) return '-';
                $colors = ['primary', 'info', 'success', 'warning', 'secondary'];
                $color = $colors[crc32($product->category) % count($colors)];
                return '<span class="badge bg-' . $color . '">' . $product->category . '</span>';
            })
            ->addColumn('status_badge', function ($product) {
                $color = $product->status === 'active' ? 'success' : 'secondary';
                $label = ucfirst($product->status);
                return '<span class="badge bg-' . $color . '">' . $label . '</span>';
            })
            ->addColumn('usage_count', function ($product) {
                return $product->procurementItems()->count();
            })
            ->addColumn('actions', function ($product) {
                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>';
                $actions .= '<ul class="dropdown-menu">';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.products.show', $product->id_product) . '">View</a></li>';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.products.edit', $product->id_product) . '">Edit</a></li>';
                
                if ($product->status === 'active') {
                    $actions .= '<li><a class="dropdown-item" onclick="toggleStatus(' . $product->id_product . ', \'inactive\')">Deactivate</a></li>';
                } else {
                    $actions .= '<li><a class="dropdown-item" onclick="toggleStatus(' . $product->id_product . ', \'active\')">Activate</a></li>';
                }
                
                $actions .= '<li><hr class="dropdown-divider"></li>';
                $actions .= '<li><a class="dropdown-item text-danger" onclick="deleteProduct(' . $product->id_product . ')">Delete</a></li>';
                $actions .= '</ul></div>';
                return $actions;
            })
            ->rawColumns(['category_badge', 'status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        // Get existing categories for dropdown
        $categories = ProcurementProduct::whereNotNull('category')
                                      ->distinct()
                                      ->pluck('category')
                                      ->sort();

        // Get existing units for dropdown
        $units = ProcurementProduct::whereNotNull('unit')
                                  ->distinct()
                                  ->pluck('unit')
                                  ->sort();

        return view('content.digitize.procurement.products.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:100|unique:procurement_products,product_code',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'unit' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100'
        ]);

        // Auto-generate product code if not provided
        $productCode = $request->product_code;
        if (!$productCode) {
            $productCode = $this->generateProductCode($request->category, $request->product_name);
        }

        ProcurementProduct::create([
            'product_code' => $productCode,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'unit' => $request->unit,
            'category' => $request->category,
            'status' => 'active'
        ]);

        return redirect()->route('procurement.products.index')
                        ->with('success', 'Product created successfully.');
    }

    public function show(ProcurementProduct $product)
    {
        $product->load(['procurementItems.request.salesUser']);

        // Get recent usage in procurement items
        $recentUsage = $product->procurementItems()
                             ->with(['request.salesUser', 'request.customer'])
                             ->orderBy('created_at', 'desc')
                             ->take(15)
                             ->get();

        // Calculate statistics
        $stats = [
            'total_requests' => $product->procurementItems()->distinct('id_procurement_request')->count(),
            'total_quantity_requested' => $product->procurementItems()->sum('requested_qty'),
            'total_quantity_delivered' => $product->procurementItems()->sum('delivered_qty'),
            'total_procured' => $product->procurementItems()->sum('delivered_qty'),
            'avg_request_quantity' => $product->procurementItems()->avg('requested_qty'),
            'last_requested' => $product->procurementItems()->max('created_at')
        ];

        // Stock status calculation (using default values since stock columns don't exist yet)
        $currentStock = 100; // Default stock value
        $minStock = 10; // Default minimum stock
        
        if ($currentStock <= $minStock * 0.5) {
            $stockStatus = ['color' => 'danger', 'text' => 'Low Stock'];
        } elseif ($currentStock <= $minStock) {
            $stockStatus = ['color' => 'warning', 'text' => 'Medium Stock'];
        } else {
            $stockStatus = ['color' => 'success', 'text' => 'In Stock'];
        }

        // Analytics calculations
        $avgMonthlyUsage = $product->procurementItems()
                                  ->where('created_at', '>=', now()->subYear())
                                  ->selectRaw('AVG(requested_qty) as avg_qty')
                                  ->value('avg_qty') ?? 0;
        
        $analytics = [
            'turnover_rate' => $avgMonthlyUsage > 0 ? ($currentStock / $avgMonthlyUsage) : 0,
            'days_supply' => $avgMonthlyUsage > 0 ? ($currentStock / ($avgMonthlyUsage / 30)) : 0,
            'avg_monthly_usage' => $avgMonthlyUsage
        ];

        // Monthly usage trend (last 12 months)
        $monthlyUsage = $product->procurementItems()
                              ->where('created_at', '>=', now()->subYear())
                              ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count, SUM(requested_qty) as total_qty')
                              ->groupBy('year', 'month')
                              ->orderBy('year')
                              ->orderBy('month')
                              ->get();

        return view('content.digitize.procurement.products.show', compact('product', 'recentUsage', 'stats', 'monthlyUsage', 'stockStatus', 'analytics'));
    }

    public function edit(ProcurementProduct $product)
    {
        // Get existing categories for dropdown
        $categories = ProcurementProduct::whereNotNull('category')
                                      ->distinct()
                                      ->pluck('category')
                                      ->sort();

        // Get existing units for dropdown
        $units = ProcurementProduct::whereNotNull('unit')
                                  ->distinct()
                                  ->pluck('unit')
                                  ->sort();

        return view('content.digitize.procurement.products.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, ProcurementProduct $product)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:100|unique:procurement_products,product_code,' . $product->id_product . ',id_product',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'unit' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100'
        ]);

        $product->update($request->only([
            'product_code', 
            'product_name', 
            'description', 
            'unit', 
            'category'
        ]));

        return redirect()->route('procurement.products.show', $product)
                        ->with('success', 'Product updated successfully.');
    }

    public function destroy(ProcurementProduct $product)
    {
        // Check if product has any procurement items
        if ($product->procurementItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product with existing procurement items'
            ]);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function toggleStatus(Request $request, ProcurementProduct $product)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $product->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully'
        ]);
    }

    public function search(Request $request)
    {
        $query = ProcurementProduct::active();
        
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->take(20)->get(['id_product', 'product_code', 'product_name', 'unit', 'category']);
        
        return response()->json($products);
    }

    public function categories()
    {
        $categories = ProcurementProduct::whereNotNull('category')
                                      ->where('category', '!=', '')
                                      ->distinct()
                                      ->pluck('category')
                                      ->sort()
                                      ->values();

        return response()->json($categories);
    }

    public function units()
    {
        $units = ProcurementProduct::whereNotNull('unit')
                                  ->where('unit', '!=', '')
                                  ->distinct()
                                  ->pluck('unit')
                                  ->sort()
                                  ->values();

        return response()->json($units);
    }

    public function categoryAnalytics(Request $request)
    {
        $period = $request->get('period', '6months');
        
        $dateFrom = match($period) {
            '1month' => now()->subMonth(),
            '3months' => now()->subMonths(3),
            '1year' => now()->subYear(),
            default => now()->subMonths(6)
        };

        $categoryStats = ProcurementProduct::selectRaw('
                category,
                COUNT(*) as product_count,
                COUNT(procurement_items.id_procurement_item) as usage_count,
                SUM(procurement_items.requested_qty) as total_qty_requested
            ')
            ->leftJoin('procurement_items', 'procurement_products.id_product', '=', 'procurement_items.id_product')
            ->where('procurement_items.created_at', '>=', $dateFrom)
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('usage_count', 'desc')
            ->get();

        return response()->json($categoryStats);
    }

    public function export(Request $request)
    {
        $products = ProcurementProduct::with(['procurementItems'])
                                    ->when($request->filled('status'), function ($query) use ($request) {
                                        $query->where('status', $request->status);
                                    })
                                    ->when($request->filled('category'), function ($query) use ($request) {
                                        $query->where('category', $request->category);
                                    })
                                    ->orderBy('product_name')
                                    ->get();

        $csvData = [];
        $csvData[] = [
            'Product Code', 
            'Product Name', 
            'Description',
            'Unit',
            'Category', 
            'Status', 
            'Usage Count',
            'Total Qty Requested',
            'Created Date'
        ];

        foreach ($products as $product) {
            $csvData[] = [
                $product->product_code,
                $product->product_name,
                $product->description,
                $product->unit,
                $product->category,
                $product->status,
                $product->procurementItems->count(),
                $product->procurementItems->sum('requested_qty'),
                $product->created_at->format('Y-m-d')
            ];
        }

        $filename = 'products_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->path()));
        $header = array_shift($csvData);

        $imported = 0;
        $errors = [];

        foreach ($csvData as $index => $row) {
            if (count($row) < 2) continue; // Skip invalid rows

            $data = array_combine($header, $row);
            $rowNum = $index + 2;

            try {
                $productCode = $data['product_code'] ?? $data['Product Code'] ?? null;
                $productName = $data['product_name'] ?? $data['Product Name'] ?? null;
                
                if (!$productName) {
                    $errors[] = "Row {$rowNum}: Product name is required";
                    continue;
                }

                // Auto-generate code if not provided
                if (!$productCode) {
                    $category = $data['category'] ?? $data['Category'] ?? null;
                    $productCode = $this->generateProductCode($category, $productName);
                }

                ProcurementProduct::create([
                    'product_code' => $productCode,
                    'product_name' => $productName,
                    'description' => $data['description'] ?? $data['Description'] ?? null,
                    'unit' => $data['unit'] ?? $data['Unit'] ?? null,
                    'category' => $data['category'] ?? $data['Category'] ?? null,
                    'status' => 'active'
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row {$rowNum}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => $imported > 0,
            'message' => "{$imported} products imported successfully",
            'imported_count' => $imported,
            'errors' => $errors
        ]);
    }

    public function duplicate(ProcurementProduct $product)
    {
        $newProduct = $product->replicate();
        $newProduct->product_code = $this->generateProductCode($product->category, $product->product_name . ' (Copy)');
        $newProduct->product_name = $product->product_name . ' (Copy)';
        $newProduct->save();

        return response()->json([
            'success' => true,
            'message' => 'Product duplicated successfully',
            'new_product_id' => $newProduct->id_product
        ]);
    }

    private function generateProductCode(?string $category, string $productName): string
    {
        $prefix = $category ? strtoupper(substr($category, 0, 3)) : 'PRD';
        $namePrefix = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', strtoupper($productName)), 0, 3));
        
        $baseCode = $prefix . $namePrefix;
        $counter = 1;
        $code = $baseCode . str_pad($counter, 3, '0', STR_PAD_LEFT);

        // Ensure uniqueness
        while (ProcurementProduct::where('product_code', $code)->exists()) {
            $counter++;
            $code = $baseCode . str_pad($counter, 3, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    public function checkCodeAvailability(Request $request)
    {
        $code = $request->get('code');
        $productId = $request->get('product_id');

        $query = ProcurementProduct::where('product_code', $code);
        
        if ($productId) {
            $query->where('id_product', '!=', $productId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Product code already exists' : 'Product code is available'
        ]);
    }
}