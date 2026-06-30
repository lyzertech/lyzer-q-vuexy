@extends('layouts/layoutMaster')

@section('title', 'Sales Dashboard - Procurement')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/moment/moment.js'])
@endsection


@section('content')

<div class="row g-6 mb-6">
    <!-- Statistics Cards -->
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-file fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">My Requests</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['total_requests'] }}</h4>
                            @if($stats['requests_this_month'] > 0)
                            <p class="text-success mb-0">(+{{ $stats['requests_this_month'] }} this month)</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-time fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Pending</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['pending_requests'] }}</h4>
                            <p class="text-warning mb-0">Need attention</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-package fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Arrived</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['arrived_requests'] }}</h4>
                            <p class="text-info mb-0">Ready for delivery</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-circle fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Completed</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['completed_requests'] }}</h4>
                            <p class="text-success mb-0">{{ number_format($stats['completion_rate'], 1) }}% rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-6">
    <!-- Recent Requests Table -->
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">My Recent Requests</h5>
                <a href="{{ route('procurement.requests.index') }}" class="btn btn-sm btn-primary">
                    View All Requests
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Request #</th>
                            <th>Title</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRequests as $request)
                        <tr>
                            <td>
                                <a href="{{ route('procurement.requests.show', $request->id_procurement_request) }}" 
                                   class="fw-medium">{{ $request->request_number }}</a>
                            </td>
                            <td>
                                <span class="fw-medium">{{ Str::limit($request->title, 30) }}</span>
                                @if($request->priority === 'urgent')
                                <span class="badge badge-sm bg-danger ms-1">!</span>
                                @elseif($request->priority === 'high')
                                <span class="badge badge-sm bg-warning ms-1">!</span>
                                @endif
                            </td>
                            <td>{{ $request->customer->customer_name ?? 'Internal' }}</td>
                            <td>
                                <span class="badge bg-label-secondary">{{ $request->items->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ \App\Enums\procurement\ProcurementRequestStatus::from($request->status)->color() }}">
                                    {{ \App\Enums\procurement\ProcurementRequestStatus::from($request->status)->label() }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress me-3" style="height: 6px; width: 80px;">
                                        <div class="progress-bar" style="width: {{ $request->getProgressPercentage() }}%"></div>
                                    </div>
                                    <span class="text-muted small">{{ $request->getProgressPercentage() }}%</span>
                                </div>
                            </td>
                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bx bx-file fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No requests yet</p>
                                    <a href="{{ route('procurement.requests.create') }}" class="btn btn-primary">
                                        Create First Request
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Monthly Trend Chart -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly Trend</h5>
            </div>
            <div class="card-body">
                <div id="monthlyTrendChart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-6 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus-circle me-2"></i>New Request
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.index') }}?status=waiting_approval" class="btn btn-outline-warning">
                                <i class="bx bx-clock me-2"></i>Pending Approval
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.index') }}?status=arrival" class="btn btn-outline-info">
                                <i class="bx bx-package me-2"></i>Ready for Delivery
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.index') }}?status=completed" class="btn btn-outline-success">
                                <i class="bx bx-check-circle me-2"></i>Completed
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chart data
window.monthlyTrendData = @json($monthlyData);

// Dashboard configuration
window.dashboardConfig = {
    stats: @json($stats),
    routes: {
        statsApi: '{{ route("procurement.reports.dashboard_stats") }}',
        requestsIndex: '{{ route("procurement.requests.index") }}'
    }
};
</script>

@endsection