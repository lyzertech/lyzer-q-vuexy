<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementCustomer;
use App\Models\procurement\ProcurementRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProcurementCustomerController extends Controller
{
    public function index()
    {
        // Statistics for Customers Index
        $stats = [
            'total' => ProcurementCustomer::count(),
            'active' => ProcurementCustomer::where('status', 'active')->count(),
            'monthly_requests' => ProcurementRequest::whereMonth('created_at', now()->month)->count(),
            'avg_request_value' => 0, // Placeholder since budget tracking is at PO level
        ];

        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-customers-page'
        ];

        return view('content.digitize.procurement.customers.index', [
            'pageConfigs' => $pageConfigs,
            'stats' => $stats
        ]);
    }

    public function data(Request $request)
    {
        $query = ProcurementCustomer::select('procurement_customers.*');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addColumn('contact_info', function ($customer) {
                $info = [];
                if ($customer->email) $info[] = $customer->email;
                if ($customer->phone) $info[] = $customer->phone;
                return implode(' | ', $info);
            })
            ->addColumn('status_badge', function ($customer) {
                $color = $customer->status === 'active' ? 'success' : 'secondary';
                $label = ucfirst($customer->status);
                return '<span class="badge bg-' . $color . '">' . $label . '</span>';
            })
            ->addColumn('requests_count', function ($customer) {
                return $customer->procurementRequests()->count();
            })
            ->addColumn('actions', function ($customer) {
                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>';
                $actions .= '<ul class="dropdown-menu">';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.customers.show', $customer->id_customer) . '">View</a></li>';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.customers.edit', $customer->id_customer) . '">Edit</a></li>';
                
                if ($customer->status === 'active') {
                    $actions .= '<li><a class="dropdown-item" onclick="toggleStatus(' . $customer->id_customer . ', \'inactive\')">Deactivate</a></li>';
                } else {
                    $actions .= '<li><a class="dropdown-item" onclick="toggleStatus(' . $customer->id_customer . ', \'active\')">Activate</a></li>';
                }
                
                $actions .= '<li><hr class="dropdown-divider"></li>';
                $actions .= '<li><a class="dropdown-item text-danger" onclick="deleteCustomer(' . $customer->id_customer . ')">Delete</a></li>';
                $actions .= '</ul></div>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('content.digitize.procurement.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255|unique:procurement_customers,customer_name',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000'
        ]);

        ProcurementCustomer::create([
            'customer_name' => $request->customer_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active'
        ]);

        return redirect()->route('procurement.customers.index')
                        ->with('success', 'Customer created successfully.');
    }

    public function show(ProcurementCustomer $customer)
    {
        $customer->load(['procurementRequests.salesUser']);

        // Get recent requests
        $recentRequests = $customer->procurementRequests()
                                  ->with(['salesUser', 'items'])
                                  ->orderBy('created_at', 'desc')
                                  ->take(10)
                                  ->get();

        // Calculate statistics
        $stats = [
            'total_requests' => $customer->procurementRequests()->count(),
            'completed_requests' => $customer->procurementRequests()->where('status', 'completed')->count(),
            'active_requests' => $customer->procurementRequests()->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'total_items' => $customer->procurementRequests()->withCount('items')->get()->sum('items_count'),
            'total_value' => $customer->procurementRequests()
                             ->whereHas('purchaseOrders')
                             ->with('purchaseOrders')
                             ->get()
                             ->sum(function($request) {
                                 return $request->purchaseOrders->sum('total_amount');
                             }),
            'avg_completion_days' => $customer->procurementRequests()
                                             ->where('status', 'completed')
                                             ->whereNotNull('completed_at')
                                             ->get()
                                             ->avg(function ($request) {
                                                 return $request->completed_at->diffInDays($request->created_at);
                                             }),
            'avg_request_days' => $customer->procurementRequests()
                                          ->where('status', 'completed')
                                          ->whereNotNull('completed_at')
                                          ->get()
                                          ->avg(function ($request) {
                                              return $request->completed_at->diffInDays($request->created_at);
                                          }) ?? 0,
            'last_request_days' => $customer->procurementRequests()->max('created_at') ? 
                                 now()->diffInDays($customer->procurementRequests()->max('created_at')) : 0,
        ];

        // Analytics for customer performance
        $completionRate = $stats['total_requests'] > 0 ? ($stats['completed_requests'] / $stats['total_requests']) * 100 : 0;
        $onTimeRequests = $customer->procurementRequests()
                                  ->where('status', 'completed')
                                  ->whereColumn('completed_at', '<=', 'expected_date')
                                  ->count();
        $onTimeRate = $stats['completed_requests'] > 0 ? ($onTimeRequests / $stats['completed_requests']) * 100 : 0;
        
        $analytics = [
            'completion_rate' => $completionRate,
            'ontime_rate' => $onTimeRate,
            'satisfaction_score' => min(100, max(0, ($completionRate + $onTimeRate) / 2)), // Combined score
        ];

        // Monthly request trend (last 12 months)
        $monthlyTrend = $customer->procurementRequests()
                                 ->where('created_at', '>=', now()->subYear())
                                 ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                                 ->groupBy('year', 'month')
                                 ->orderBy('year')
                                 ->orderBy('month')
                                 ->get();

        return view('content.digitize.procurement.customers.show', compact('customer', 'recentRequests', 'stats', 'monthlyTrend', 'analytics'));
    }

    public function edit(ProcurementCustomer $customer)
    {
        return view('content.digitize.procurement.customers.edit', compact('customer'));
    }

    public function update(Request $request, ProcurementCustomer $customer)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255|unique:procurement_customers,customer_name,' . $customer->id_customer . ',id_customer',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000'
        ]);

        $customer->update($request->only([
            'customer_name', 
            'contact_person', 
            'email', 
            'phone', 
            'address'
        ]));

        return redirect()->route('procurement.customers.show', $customer)
                        ->with('success', 'Customer updated successfully.');
    }

    public function destroy(ProcurementCustomer $customer)
    {
        // Check if customer has any procurement requests
        if ($customer->procurementRequests()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete customer with existing procurement requests'
            ]);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully'
        ]);
    }

    public function toggleStatus(Request $request, ProcurementCustomer $customer)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $customer->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Customer status updated successfully'
        ]);
    }

    public function search(Request $request)
    {
        $query = ProcurementCustomer::active();
        
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->take(20)->get(['id_customer', 'customer_name', 'contact_person', 'email', 'phone']);
        
        return response()->json($customers);
    }

    public function requestHistory(ProcurementCustomer $customer, Request $request)
    {
        $query = $customer->procurementRequests()->with(['salesUser', 'items']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('sales_name', function ($request) {
                return $request->salesUser->name ?? '';
            })
            ->addColumn('items_count', function ($request) {
                return $request->items->count();
            })
            ->addColumn('progress', function ($request) {
                return $request->getProgressPercentage() . '%';
            })
            ->addColumn('status_badge', function ($request) {
                $statusColors = [
                    'draft' => 'secondary',
                    'waiting_approval' => 'warning',
                    'approved' => 'info',
                    'purchasing' => 'primary',
                    'shipping' => 'primary',
                    'partial_arrival' => 'warning',
                    'arrival' => 'info',
                    'delivered' => 'success',
                    'completed' => 'success',
                    'cancelled' => 'danger'
                ];
                
                $color = $statusColors[$request->status] ?? 'secondary';
                $label = ucwords(str_replace('_', ' ', $request->status));
                return '<span class="badge bg-' . $color . '">' . $label . '</span>';
            })
            ->addColumn('actions', function ($request) {
                return '<a href="' . route('procurement.requests.show', $request->id_procurement_request) . '" class="btn btn-sm btn-outline-primary">View</a>';
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('M d, Y');
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function analytics(ProcurementCustomer $customer, Request $request)
    {
        $period = $request->get('period', '6months');
        
        $dateFrom = match($period) {
            '1month' => now()->subMonth(),
            '3months' => now()->subMonths(3),
            '1year' => now()->subYear(),
            default => now()->subMonths(6)
        };

        $requests = $customer->procurementRequests()
                            ->where('created_at', '>=', $dateFrom)
                            ->with('items')
                            ->get();

        $analytics = [
            'total_requests' => $requests->count(),
            'completed_requests' => $requests->where('status', 'completed')->count(),
            'avg_completion_days' => $requests->where('status', 'completed')
                                            ->where('completed_at', '!=', null)
                                            ->avg(function ($req) {
                                                return $req->completed_at->diffInDays($req->created_at);
                                            }),
            'total_items' => $requests->sum(function ($req) { return $req->items->count(); }),
            'completion_rate' => $requests->count() > 0 ? 
                ($requests->where('status', 'completed')->count() / $requests->count()) * 100 : 0,
            'status_distribution' => $requests->groupBy('status')->map->count(),
            'priority_distribution' => $requests->groupBy('priority')->map->count(),
            'monthly_trend' => $requests->groupBy(function ($req) {
                return $req->created_at->format('Y-m');
            })->map->count()->sortKeys()
        ];

        return response()->json($analytics);
    }

    public function export(Request $request)
    {
        $customers = ProcurementCustomer::with(['procurementRequests'])
                                       ->when($request->filled('status'), function ($query) use ($request) {
                                           $query->where('status', $request->status);
                                       })
                                       ->get();

        $csvData = [];
        $csvData[] = [
            'Customer Name', 
            'Contact Person', 
            'Email', 
            'Phone', 
            'Address', 
            'Status', 
            'Total Requests', 
            'Completed Requests',
            'Created Date'
        ];

        foreach ($customers as $customer) {
            $csvData[] = [
                $customer->customer_name,
                $customer->contact_person,
                $customer->email,
                $customer->phone,
                $customer->address,
                $customer->status,
                $customer->procurementRequests->count(),
                $customer->procurementRequests->where('status', 'completed')->count(),
                $customer->created_at->format('Y-m-d')
            ];
        }

        $filename = 'customers_' . date('Y-m-d') . '.csv';
        
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
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->path()));
        $header = array_shift($csvData);

        $imported = 0;
        $errors = [];

        foreach ($csvData as $row) {
            if (count($row) < 2) continue; // Skip invalid rows

            $data = array_combine($header, $row);

            try {
                ProcurementCustomer::create([
                    'customer_name' => $data['customer_name'] ?? $data['Customer Name'] ?? 'Unknown',
                    'contact_person' => $data['contact_person'] ?? $data['Contact Person'] ?? null,
                    'email' => $data['email'] ?? $data['Email'] ?? null,
                    'phone' => $data['phone'] ?? $data['Phone'] ?? null,
                    'address' => $data['address'] ?? $data['Address'] ?? null,
                    'status' => 'active'
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($imported + count($errors) + 2) . ": " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => $imported > 0,
            'message' => "{$imported} customers imported successfully",
            'imported_count' => $imported,
            'errors' => $errors
        ]);
    }
}