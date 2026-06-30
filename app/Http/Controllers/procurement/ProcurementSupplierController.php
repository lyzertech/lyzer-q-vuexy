<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementSupplier;
use App\Models\procurement\ProcurementPurchaseOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProcurementSupplierController extends Controller
{
    public function index()
    {
        // Statistics for Suppliers Index
        $stats = [
            'total' => ProcurementSupplier::count(),
            'active' => ProcurementSupplier::where('status', 'active')->count(),
            'monthly_pos' => ProcurementPurchaseOrder::whereMonth('created_at', now()->month)->count(),
            'avg_performance' => 85, // Default performance score since column doesn't exist yet
        ];

        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-suppliers-page'
        ];

        return view('content.digitize.procurement.suppliers.index', [
            'pageConfigs' => $pageConfigs,
            'stats' => $stats
        ]);
    }

    public function data(Request $request)
    {
        $query = ProcurementSupplier::select('procurement_suppliers.*');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addColumn('contact_info', function ($supplier) {
                $info = [];
                if ($supplier->email) $info[] = $supplier->email;
                if ($supplier->phone) $info[] = $supplier->phone;
                return implode(' | ', $info);
            })
            ->addColumn('status_badge', function ($supplier) {
                $color = $supplier->status === 'active' ? 'success' : 'secondary';
                $label = ucfirst($supplier->status);
                return '<span class="badge bg-' . $color . '">' . $label . '</span>';
            })
            ->addColumn('purchase_orders_count', function ($supplier) {
                return $supplier->purchaseOrders()->count();
            })
            ->addColumn('actions', function ($supplier) {
                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>';
                $actions .= '<ul class="dropdown-menu">';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.suppliers.show', $supplier->id_supplier) . '">View</a></li>';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.suppliers.edit', $supplier->id_supplier) . '">Edit</a></li>';
                
                if ($supplier->status === 'active') {
                    $actions .= '<li><a class="dropdown-item" onclick="toggleStatus(' . $supplier->id_supplier . ', \'inactive\')">Deactivate</a></li>';
                } else {
                    $actions .= '<li><a class="dropdown-item" onclick="toggleStatus(' . $supplier->id_supplier . ', \'active\')">Activate</a></li>';
                }
                
                $actions .= '<li><hr class="dropdown-divider"></li>';
                $actions .= '<li><a class="dropdown-item text-danger" onclick="deleteSupplier(' . $supplier->id_supplier . ')">Delete</a></li>';
                $actions .= '</ul></div>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('content.digitize.procurement.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255|unique:procurement_suppliers,supplier_name',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000'
        ]);

        ProcurementSupplier::create([
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active'
        ]);

        return redirect()->route('procurement.suppliers.index')
                        ->with('success', 'Supplier created successfully.');
    }

    public function show(ProcurementSupplier $supplier)
    {
        $supplier->load(['purchaseOrders.request']);

        // Get recent purchase orders
        $recentPOs = $supplier->purchaseOrders()
                            ->with(['request.salesUser'])
                            ->orderBy('created_at', 'desc')
                            ->take(10)
                            ->get();

        // Calculate statistics
        $stats = [
            'total_pos' => $supplier->purchaseOrders()->count(),
            'completed_pos' => $supplier->purchaseOrders()->where('status', 'completed')->count(),
            'total_amount' => $supplier->purchaseOrders()->sum('total_amount'),
            'total_value' => $supplier->purchaseOrders()->sum('total_amount'), // Alias for view compatibility
            'avg_completion_days' => $supplier->purchaseOrders()
                                           ->where('status', 'completed')
                                           ->get()
                                           ->avg(function ($po) {
                                               return $po->updated_at->diffInDays($po->created_at);
                                           }),
            'avg_delivery_days' => $supplier->purchaseOrders()
                                           ->where('status', 'completed')
                                           ->get()
                                           ->avg(function ($po) {
                                               return $po->updated_at->diffInDays($po->created_at);
                                           }) ?? 0,
            'last_order_days' => $supplier->purchaseOrders()->max('created_at') ? 
                               now()->diffInDays($supplier->purchaseOrders()->max('created_at')) : 0,
        ];

        // Performance metrics for the supplier
        $completionRate = $stats['total_pos'] > 0 ? ($stats['completed_pos'] / $stats['total_pos']) * 100 : 0;
        
        $performanceMetrics = [
            'quality_score' => min(100, max(0, $completionRate + rand(-15, 15))), // Simulated with some variance
            'delivery_score' => min(100, max(0, 100 - ($stats['avg_delivery_days'] * 2))), // Better score for faster delivery
            'communication_score' => min(100, max(0, 85 + rand(-15, 15))), // Simulated base score with variance
        ];

        return view('content.digitize.procurement.suppliers.show', compact('supplier', 'recentPOs', 'stats', 'performanceMetrics'));
    }

    public function edit(ProcurementSupplier $supplier)
    {
        return view('content.digitize.procurement.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, ProcurementSupplier $supplier)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255|unique:procurement_suppliers,supplier_name,' . $supplier->id_supplier . ',id_supplier',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000'
        ]);

        $supplier->update($request->only([
            'supplier_name', 
            'contact_person', 
            'email', 
            'phone', 
            'address'
        ]));

        return redirect()->route('procurement.suppliers.show', $supplier)
                        ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(ProcurementSupplier $supplier)
    {
        // Check if supplier has any purchase orders
        if ($supplier->purchaseOrders()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete supplier with existing purchase orders'
            ]);
        }

        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }

    public function toggleStatus(Request $request, ProcurementSupplier $supplier)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $supplier->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier status updated successfully'
        ]);
    }

    public function search(Request $request)
    {
        $query = ProcurementSupplier::active();
        
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->take(20)->get(['id_supplier', 'supplier_name', 'contact_person', 'email', 'phone']);
        
        return response()->json($suppliers);
    }

    public function performance(Request $request)
    {
        $period = $request->get('period', '3months');
        
        $dateFrom = match($period) {
            '1month' => now()->subMonth(),
            '6months' => now()->subMonths(6),
            '1year' => now()->subYear(),
            default => now()->subMonths(3)
        };

        $suppliers = ProcurementSupplier::withCount([
                'purchaseOrders as total_pos' => function ($query) use ($dateFrom) {
                    $query->where('created_at', '>=', $dateFrom);
                },
                'purchaseOrders as completed_pos' => function ($query) use ($dateFrom) {
                    $query->where('created_at', '>=', $dateFrom)
                          ->where('status', 'completed');
                }
            ])
            ->with(['purchaseOrders' => function ($query) use ($dateFrom) {
                $query->where('created_at', '>=', $dateFrom)
                      ->where('status', 'completed');
            }])
            ->having('total_pos', '>', 0)
            ->get()
            ->map(function ($supplier) {
                $completionRate = $supplier->total_pos > 0 ? 
                    ($supplier->completed_pos / $supplier->total_pos) * 100 : 0;

                $avgDays = $supplier->purchaseOrders->avg(function ($po) {
                    return $po->updated_at->diffInDays($po->created_at);
                });

                return [
                    'id' => $supplier->id_supplier,
                    'supplier_name' => $supplier->supplier_name,
                    'total_pos' => $supplier->total_pos,
                    'completed_pos' => $supplier->completed_pos,
                    'completion_rate' => round($completionRate, 1),
                    'avg_completion_days' => round($avgDays ?? 0, 1),
                    'total_amount' => $supplier->purchaseOrders->sum('total_amount'),
                    'rating' => $this->calculateSupplierRating($completionRate, $avgDays)
                ];
            })
            ->sortByDesc('rating');

        return response()->json($suppliers->values());
    }

    public function export(Request $request)
    {
        $suppliers = ProcurementSupplier::with(['purchaseOrders'])
                                      ->when($request->filled('status'), function ($query) use ($request) {
                                          $query->where('status', $request->status);
                                      })
                                      ->get();

        $csvData = [];
        $csvData[] = [
            'Supplier Name', 
            'Contact Person', 
            'Email', 
            'Phone', 
            'Address', 
            'Status', 
            'Total POs', 
            'Created Date'
        ];

        foreach ($suppliers as $supplier) {
            $csvData[] = [
                $supplier->supplier_name,
                $supplier->contact_person,
                $supplier->email,
                $supplier->phone,
                $supplier->address,
                $supplier->status,
                $supplier->purchaseOrders->count(),
                $supplier->created_at->format('Y-m-d')
            ];
        }

        $filename = 'suppliers_' . date('Y-m-d') . '.csv';
        
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

    private function calculateSupplierRating(float $completionRate, ?float $avgDays): float
    {
        // Rating algorithm: 
        // - Completion rate (0-100) weighted 60%
        // - Speed bonus: faster delivery gets higher score, weighted 40%
        
        $completionScore = $completionRate * 0.6;
        
        // Speed score: 30+ days = 0, 0 days = 40, linear interpolation
        $speedScore = $avgDays ? max(0, 40 - ($avgDays / 30 * 40)) : 20;
        
        return round($completionScore + $speedScore, 1);
    }
}