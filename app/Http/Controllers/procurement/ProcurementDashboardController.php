<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementItem;
use App\Models\procurement\ProcurementPurchaseOrder;
use App\Enums\procurement\ProcurementRequestStatus;
use App\Enums\procurement\ProcurementItemStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcurementDashboardController extends Controller
{
    /**
     * Main procurement page - redirects to appropriate dashboard based on user role
     */
    public function index()
    {
        $user = auth()->user();
        
        // Check user roles and redirect to appropriate dashboard
        // Following existing role pattern (1=Sales, 2=Purchasing, 4=Manager, 5=Director, 6=Admin)
        if (in_array($user->id_role, [4, 5, 6])) {
            // Manager, Director, Admin -> Manager Dashboard
            return redirect()->route('procurement.dashboard.manager');
        } elseif ($user->id_role == 2) {
            // Purchasing role -> Purchasing Dashboard
            return redirect()->route('procurement.dashboard.purchasing');
        } elseif ($user->id_role == 1) {
            // Sales role -> Sales Dashboard
            return redirect()->route('procurement.dashboard.sales');
        } else {
            // Default to sales dashboard for other roles
            return redirect()->route('procurement.dashboard.sales');
        }
    }

    public function sales()
    {
        $userId = auth()->id();
        
        // Statistics for Sales Dashboard
        $stats = [
            'total_requests' => ProcurementRequest::where('id_user_sales', $userId)->count(),
            'pending_requests' => ProcurementRequest::where('id_user_sales', $userId)
                                    ->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'arrived_requests' => ProcurementRequest::where('id_user_sales', $userId)
                                    ->where('status', 'arrival')->count(),
            'completed_requests' => ProcurementRequest::where('id_user_sales', $userId)
                                     ->where('status', 'completed')->count(),
            'requests_this_month' => ProcurementRequest::where('id_user_sales', $userId)
                                       ->whereMonth('created_at', now()->month)->count(),
        ];

        // Calculate completion rate
        $stats['completion_rate'] = $stats['total_requests'] > 0 ? 
            ($stats['completed_requests'] / $stats['total_requests']) * 100 : 0;

        // Recent requests for the table
        $recentRequests = ProcurementRequest::with(['customer', 'items'])
                           ->where('id_user_sales', $userId)
                           ->orderBy('created_at', 'desc')
                           ->take(10)
                           ->get();

        // Monthly trend data for chart
        $monthlyData = ProcurementRequest::where('id_user_sales', $userId)
                        ->where('created_at', '>=', now()->subMonths(6))
                        ->select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('YEAR(created_at) as year'),
                            DB::raw('COUNT(*) as total'),
                            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
                        )
                        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();

        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-sales-dashboard'
        ];

        return view('content.digitize.procurement.dashboard.sales', compact('stats', 'recentRequests', 'monthlyData', 'pageConfigs'));
    }

    public function purchasing()
    {
        // Statistics for Purchasing Dashboard
        $stats = [
            'active_requests' => ProcurementRequest::whereIn('status', [
                'approved', 'purchasing', 'shipping', 'partial_arrival'
            ])->count(),
            'need_action' => ProcurementRequest::where('status', 'approved')->count(),
            'shipping_requests' => ProcurementRequest::where('status', 'shipping')->count(),
            'arrival_requests' => ProcurementRequest::whereIn('status', [
                'partial_arrival', 'arrival'
            ])->count(),
            'total_pos' => ProcurementPurchaseOrder::count(),
            'pos_this_month' => ProcurementPurchaseOrder::whereMonth('created_at', now()->month)->count(),
            'pending_pos' => ProcurementPurchaseOrder::whereIn('status', [
                'draft', 'sent', 'acknowledged'
            ])->count(),
            'items_in_production' => ProcurementItem::where('status', 'production')->count(),
            'items_shipped' => ProcurementItem::where('status', 'shipped')->count(),
        ];

        // Items needing attention
        $pendingItems = ProcurementItem::with(['request.salesUser', 'product'])
                         ->whereIn('status', ['requested', 'ordered', 'production'])
                         ->orderBy('created_at', 'asc')
                         ->take(20)
                         ->get();

        // Supplier performance data
        $supplierPerformance = DB::table('procurement_purchase_orders as po')
                                ->join('procurement_suppliers as s', 'po.id_supplier', '=', 's.id_supplier')
                                ->select(
                                    's.supplier_name',
                                    DB::raw('COUNT(*) as total_pos'),
                                    DB::raw('SUM(CASE WHEN po.status = "completed" THEN 1 ELSE 0 END) as completed_pos'),
                                    DB::raw('AVG(DATEDIFF(po.updated_at, po.created_at)) as avg_completion_days')
                                )
                                ->where('po.created_at', '>=', now()->subMonths(3))
                                ->groupBy('s.id_supplier', 's.supplier_name')
                                ->orderBy('total_pos', 'desc')
                                ->take(10)
                                ->get();

        // Transform supplier data for the view
        $suppliers = $supplierPerformance->map(function($supplier) {
            $performanceScore = $supplier->total_pos > 0 ? 
                              ($supplier->completed_pos / $supplier->total_pos) * 100 : 0;
            
            return [
                'name' => $supplier->supplier_name,
                'pos_count' => $supplier->total_pos,
                'performance_score' => round($performanceScore, 1)
            ];
        });

        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-purchasing-dashboard'
        ];

        return view('content.digitize.procurement.dashboard.purchasing', compact('stats', 'pendingItems', 'supplierPerformance', 'suppliers', 'pageConfigs'));
    }

    public function manager()
    {
        // Statistics for Manager Dashboard
        $stats = [
            'total_requests' => ProcurementRequest::count(),
            'pending_approval' => ProcurementRequest::where('status', 'waiting_approval')->count(),
            'urgent_pending' => ProcurementRequest::where('status', 'waiting_approval')
                                  ->where('created_at', '<=', now()->subDays(3))->count(),
            'active_requests' => ProcurementRequest::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'active_pos' => ProcurementPurchaseOrder::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'total_po_value' => ProcurementPurchaseOrder::whereNotIn('status', ['cancelled'])->sum('total_amount') ?? 0,
            'overdue_requests' => ProcurementRequest::whereNotNull('expected_date')
                                   ->where('expected_date', '<', now())
                                   ->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'delayed_items' => ProcurementItem::whereHas('request', function($query) {
                                    $query->whereNotNull('expected_date')
                                          ->where('expected_date', '<', now())
                                          ->whereNotIn('status', ['completed', 'cancelled']);
                                })->whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'this_month_requests' => ProcurementRequest::whereMonth('created_at', now()->month)->count(),
            'last_month_requests' => ProcurementRequest::whereMonth('created_at', now()->subMonth()->month)->count(),
        ];

        // Calculate trends
        $stats['monthly_growth'] = $stats['last_month_requests'] > 0 ? 
            (($stats['this_month_requests'] - $stats['last_month_requests']) / $stats['last_month_requests']) * 100 : 0;

        // Calculate completion rate
        $completedRequests = ProcurementRequest::where('status', 'completed')->count();
        $stats['completion_rate'] = $stats['total_requests'] > 0 ? 
            ($completedRequests / $stats['total_requests']) * 100 : 0;

        // Calculate system health based on various factors
        $onTimeRequests = ProcurementRequest::where('expected_date', '>=', now())
                           ->orWhere('status', 'completed')->count();
        $healthScore = $stats['total_requests'] > 0 ? ($onTimeRequests / $stats['total_requests']) * 100 : 100;
        $stats['system_health'] = min(100, max(0, $healthScore));

        // Average completion time
        $completedRequests = ProcurementRequest::where('status', 'completed')
                              ->where('completed_at', '>=', now()->subMonths(3))
                              ->get();

        $stats['avg_completion_days'] = $completedRequests->count() > 0 ? 
            $completedRequests->avg(function ($request) {
                return $request->completed_at->diffInDays($request->created_at);
            }) : 0;

        // Status distribution
        $statusDistribution = ProcurementRequest::select('status', DB::raw('COUNT(*) as count'))
                               ->groupBy('status')
                               ->get()
                               ->map(function ($item) {
                                   $status = ProcurementRequestStatus::from($item->status);
                                   return [
                                       'status' => $status->label(),
                                       'count' => $item->count,
                                       'color' => $status->color()
                                   ];
                               });

        // Recent requests needing approval
        $pendingApprovals = ProcurementRequest::with(['salesUser', 'customer'])
                             ->where('status', 'waiting_approval')
                             ->orderBy('created_at', 'asc')
                             ->take(10)
                             ->get();

        // Items needing manager attention (overdue, high priority, issues)
        $attentionItems = ProcurementRequest::with(['salesUser', 'customer'])
                           ->where(function($query) {
                               $query->where('priority', 'urgent')
                                     ->orWhere(function($subQuery) {
                                         $subQuery->whereNotNull('expected_date')
                                                  ->where('expected_date', '<', now())
                                                  ->whereNotIn('status', ['completed', 'cancelled']);
                                     })
                                     ->orWhere('status', 'waiting_approval');
                           })
                           ->orderBy('priority', 'desc')
                           ->orderBy('created_at', 'asc')
                           ->take(15)
                           ->get()
                           ->map(function($request) {
                               return [
                                   'id' => $request->id_procurement_request,
                                   'request_number' => $request->request_number,
                                   'title' => $request->title,
                                   'requester_name' => $request->salesUser->name ?? 'Unknown',
                                   'customer_name' => $request->customer->customer_name ?? null,
                                   'priority' => $request->priority,
                                   'status_label' => ucfirst(str_replace('_', ' ', $request->status)),
                                   'status_color' => match($request->status) {
                                       'waiting_approval' => 'warning',
                                       'approved' => 'info',
                                       'purchasing' => 'primary',
                                       'shipping' => 'secondary', 
                                       'completed' => 'success',
                                       'cancelled' => 'danger',
                                       default => 'secondary'
                                   },
                                   'issue_description' => match(true) {
                                       $request->priority === 'urgent' => 'Urgent Priority',
                                       $request->expected_date && $request->expected_date < now() => 'Overdue',
                                       $request->status === 'waiting_approval' => 'Waiting Approval',
                                       default => 'Requires Attention'
                                   },
                                   'issue_severity' => $request->priority === 'urgent' ? 'high' : 'medium',
                                   'days_stuck' => $request->created_at->diffInDays(now()),
                                   'suggested_action' => $request->status === 'waiting_approval' ? 'approve' : 'follow_up'
                               ];
                           });

        // Performance by sales person
        $salesPerformance = DB::table('procurement_requests as pr')
                             ->join('users as u', 'pr.id_user_sales', '=', 'u.id')
                             ->select(
                                 'u.name',
                                 DB::raw('COUNT(*) as total_requests'),
                                 DB::raw('SUM(CASE WHEN pr.status = "completed" THEN 1 ELSE 0 END) as completed'),
                                 DB::raw('AVG(CASE WHEN pr.status = "completed" THEN DATEDIFF(pr.completed_at, pr.created_at) END) as avg_days')
                             )
                             ->where('pr.created_at', '>=', now()->subMonths(3))
                             ->groupBy('u.id', 'u.name')
                             ->orderBy('total_requests', 'desc')
                             ->take(10)
                             ->get();

        // Team performance data for the dashboard
        $teams = $salesPerformance->map(function($performance) {
            $efficiency = $performance->total_requests > 0 ? 
                         ($performance->completed / $performance->total_requests) * 100 : 0;
            
            return [
                'name' => $performance->name,
                'active_requests' => $performance->total_requests - $performance->completed,
                'efficiency' => round($efficiency, 1)
            ];
        });

        // Team performance data (alternative format for different view sections)
        $teamPerformance = $salesPerformance->map(function($performance) {
            $completionRate = $performance->total_requests > 0 ? 
                            ($performance->completed / $performance->total_requests) * 100 : 0;
            
            return [
                'name' => $performance->name,
                'total_requests' => $performance->total_requests,
                'completed_requests' => $performance->completed,
                'completion_rate' => round($completionRate, 1),
                'avg_completion_days' => round($performance->avg_days ?? 0, 1),
                'performance_score' => round($completionRate, 1)
            ];
        });

        // Trends data for charts (last 12 months)
        $trendsData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthRequests = ProcurementRequest::whereYear('created_at', $date->year)
                                             ->whereMonth('created_at', $date->month)
                                             ->count();
            $monthCompleted = ProcurementRequest::whereYear('created_at', $date->year)
                                               ->whereMonth('created_at', $date->month)
                                               ->where('status', 'completed')
                                               ->count();
            
            $trendsData[] = [
                'month' => $date->format('M Y'),
                'month_short' => $date->format('M'),
                'total_requests' => $monthRequests,
                'completed_requests' => $monthCompleted,
                'completion_rate' => $monthRequests > 0 ? round(($monthCompleted / $monthRequests) * 100, 1) : 0,
                'active_requests' => $monthRequests - $monthCompleted
            ];
        }

        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-manager-dashboard'
        ];

        return view('content.digitize.procurement.dashboard.manager', compact(
            'stats', 
            'statusDistribution', 
            'pendingApprovals',
            'attentionItems',
            'teams',
            'teamPerformance',
            'trendsData', 
            'salesPerformance', 
            'pageConfigs'
        ));
    }

    public function dashboardStats(Request $request)
    {
        // API endpoint for dashboard statistics (for AJAX refresh)
        $userId = auth()->id();
        $userRole = auth()->user()->role;

        $stats = [];

        if (in_array($userRole, [4, 5])) { // Sales roles
            $stats = [
                'my_requests' => ProcurementRequest::where('id_user_sales', $userId)->count(),
                'pending' => ProcurementRequest::where('id_user_sales', $userId)
                            ->whereNotIn('status', ['completed', 'cancelled'])->count(),
                'arrived' => ProcurementRequest::where('id_user_sales', $userId)
                            ->where('status', 'arrival')->count(),
                'completed' => ProcurementRequest::where('id_user_sales', $userId)
                              ->where('status', 'completed')->count(),
            ];
        } else { // Manager/Admin roles
            $stats = [
                'total_requests' => ProcurementRequest::count(),
                'pending_approval' => ProcurementRequest::where('status', 'waiting_approval')->count(),
                'active_requests' => ProcurementRequest::whereNotIn('status', ['completed', 'cancelled'])->count(),
                'overdue' => ProcurementRequest::where('expected_date', '<', now())
                            ->whereNotIn('status', ['completed', 'cancelled'])->count(),
            ];
        }

        return response()->json($stats);
    }
}