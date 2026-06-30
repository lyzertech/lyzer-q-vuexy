@extends('layouts/layoutMaster')

@section('title', 'Manager Dashboard - Procurement')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/moment/moment.js'])
@endsection


@section('content')

<!-- Key Metrics Overview -->
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-primary">
                                    <i class="bx bx-file fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="mb-0 small">Total Requests</p>
                                <h4 class="mb-0">{{ $stats['total_requests'] }}</h4>
                                <small class="text-muted">+{{ number_format($stats['monthly_growth'], 1) }}% vs last month</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-warning">
                                    <i class="bx bx-time-five fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="mb-0 small">Pending Approval</p>
                                <h4 class="mb-0">{{ $stats['pending_approval'] }}</h4>
                                <small class="text-warning">{{ $stats['urgent_pending'] }} urgent</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-info">
                                    <i class="bx bx-receipt fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="mb-0 small">Active POs</p>
                                <h4 class="mb-0">{{ $stats['active_pos'] }}</h4>
                                <small class="text-info">Rp {{ number_format($stats['total_po_value'] / 1000000, 1) }}M value</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-4">
                                <span class="avatar-initial rounded bg-success">
                                    <i class="bx bx-trending-up fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="mb-0 small">Completion Rate</p>
                                <h4 class="mb-0">{{ number_format($stats['completion_rate'], 1) }}%</h4>
                                <small class="text-success">{{ $stats['avg_completion_days'] }} avg days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-6">
    <!-- Requests Needing Attention -->
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Requests Requiring Attention</h5>
                    <small class="text-muted">Items that need management intervention</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                        Filter: All
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-filter="all">All Items</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="urgent">Urgent Only</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="delayed">Delayed Items</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="stuck">Stuck Process</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Request</th>
                            <th>Requester</th>
                            <th>Customer</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Issue</th>
                            <th>Days</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attentionItems as $item)
                        <tr class="{{ $item['priority'] === 'urgent' ? 'table-warning' : '' }}">
                            <td>
                                <a href="{{ route('procurement.requests.show', $item['id']) }}" 
                                   class="fw-medium">{{ $item['request_number'] }}</a>
                                <br><small class="text-muted">{{ Str::limit($item['title'], 25) }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            {{ strtoupper(substr($item['requester_name'], 0, 2)) }}
                                        </span>
                                    </div>
                                    <span class="small">{{ $item['requester_name'] }}</span>
                                </div>
                            </td>
                            <td>{{ $item['customer_name'] ?? 'Internal' }}</td>
                            <td>
                                <span class="badge badge-sm bg-{{ $item['priority'] === 'urgent' ? 'danger' : ($item['priority'] === 'high' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($item['priority']) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $item['status_color'] }}">{{ $item['status_label'] }}</span>
                            </td>
                            <td>
                                <span class="text-{{ $item['issue_severity'] === 'high' ? 'danger' : 'warning' }}">
                                    {{ $item['issue_description'] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $item['days_stuck'] > 7 ? 'danger' : ($item['days_stuck'] > 3 ? 'warning' : 'secondary') }}">
                                    {{ $item['days_stuck'] }}d
                                </span>
                            </td>
                            <td>
                                @if($item['suggested_action'] === 'approve')
                                <button class="btn btn-sm btn-success" onclick="approveRequest('{{ $item['id'] }}')">
                                    <i class="bx bx-check"></i>
                                </button>
                                @elseif($item['suggested_action'] === 'follow_up')
                                <button class="btn btn-sm btn-warning" onclick="followUp('{{ $item['id'] }}')">
                                    <i class="bx bx-message-dots"></i>
                                </button>
                                @else
                                <a href="{{ route('procurement.requests.show', $item['id']) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bx bx-check-circle fs-1 text-success"></i>
                                    <p class="text-muted mt-2">All requests are running smoothly!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Team Performance -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Team Performance</h5>
            </div>
            <div class="card-body">
                @foreach($teamPerformance as $team)
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-0">{{ $team['name'] }}</h6>
                        <small class="text-muted">{{ $team['active_requests'] }} active requests</small>
                    </div>
                    <div class="text-end">
                        <span class="fw-medium text-{{ $team['efficiency'] >= 90 ? 'success' : ($team['efficiency'] >= 70 ? 'warning' : 'danger') }}">
                            {{ $team['efficiency'] }}%
                        </span>
                        <div class="progress mt-1" style="height: 4px; width: 80px;">
                            <div class="progress-bar bg-{{ $team['efficiency'] >= 90 ? 'success' : ($team['efficiency'] >= 70 ? 'warning' : 'danger') }}" 
                                 style="width: {{ $team['efficiency'] }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <hr class="my-4">
                
                <div class="text-center">
                    <h6 class="text-muted">Overall System Health</h6>
                    <div class="mt-3">
                        <span class="badge bg-{{ $stats['system_health'] >= 90 ? 'success' : ($stats['system_health'] >= 70 ? 'warning' : 'danger') }} fs-6 px-3 py-2">
                            {{ $stats['system_health'] }}% Healthy
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts -->
<div class="row g-6 mt-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Procurement Trends</h5>
                <div class="btn-group btn-group-sm" role="group">
                    <input type="radio" class="btn-check" name="chartPeriod" id="period7d" value="7d" checked>
                    <label class="btn btn-outline-primary" for="period7d">7D</label>
                    
                    <input type="radio" class="btn-check" name="chartPeriod" id="period30d" value="30d">
                    <label class="btn btn-outline-primary" for="period30d">30D</label>
                    
                    <input type="radio" class="btn-check" name="chartPeriod" id="period90d" value="90d">
                    <label class="btn btn-outline-primary" for="period90d">90D</label>
                </div>
            </div>
            <div class="card-body">
                <div id="procurementTrendsChart"></div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Distribution</h5>
            </div>
            <div class="card-body">
                <div id="statusDistributionChart"></div>
                
                <div class="mt-4">
                    @foreach($statusDistribution as $status)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="badge bg-{{ $status['color'] }} me-2" style="width: 8px; height: 8px;"></div>
                            <span class="small">{{ $status['label'] }}</span>
                        </div>
                        <span class="fw-medium">{{ $status['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Management Actions -->
<div class="row g-6 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Management Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.index') }}?status=waiting_manager_approval" class="btn btn-warning">
                                <i class="bx bx-user-check me-2"></i>Review Approvals
                                @if($stats['pending_approval'] > 0)
                                <span class="badge bg-white text-warning ms-1">{{ $stats['pending_approval'] }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.reports.dashboard_stats') }}?export=excel" class="btn btn-outline-success">
                                <i class="bx bx-download me-2"></i>Export Report
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.suppliers.performance') }}" class="btn btn-outline-info">
                                <i class="bx bx-store me-2"></i>Supplier KPIs
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.index') }}?delayed=1" class="btn btn-outline-danger">
                                <i class="bx bx-time me-2"></i>Delayed Items
                                @if($stats['delayed_items'] > 0)
                                <span class="badge bg-danger ms-1">{{ $stats['delayed_items'] }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bulkActionsModal">
                                <i class="bx bx-layer me-2"></i>Bulk Actions
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshDashboard()">
                                <i class="bx bx-refresh me-2"></i>Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions Modal -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Action Type</label>
                    <select class="form-select" id="bulkActionType">
                        <option value="">Select Action</option>
                        <option value="approve_pending">Approve All Pending (Manager)</option>
                        <option value="send_reminders">Send Delay Reminders</option>
                        <option value="update_priorities">Update Priorities</option>
                        <option value="export_delayed">Export Delayed Items</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Filter Criteria</label>
                    <select class="form-select" id="bulkFilterCriteria">
                        <option value="all">All Requests</option>
                        <option value="urgent_only">Urgent Only</option>
                        <option value="delayed_only">Delayed Only</option>
                        <option value="specific_customer">Specific Customer</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="executeBulkAction()">Execute</button>
            </div>
        </div>
    </div>
</div>

<script>
// Chart data
window.procurementTrendsData = @json($trendsData);
window.statusDistributionData = @json($statusDistribution);

// Dashboard configuration
window.dashboardConfig = {
    stats: @json($stats),
    routes: {
        statsApi: '{{ route("procurement.reports.dashboard_stats") }}',
        requestsIndex: '{{ route("procurement.requests.index") }}',
        approveRequest: '{{ route("procurement.requests.ack_manager", ":id") }}',
        refreshData: '{{ route("procurement.reports.dashboard_stats") }}'
    }
};

function approveRequest(requestId) {
    // Implementation for quick approval
    if (confirm('Approve this request?')) {
        window.location.href = window.dashboardConfig.routes.approveRequest.replace(':id', requestId);
    }
}

function followUp(requestId) {
    // Implementation for follow-up action
    window.location.href = '{{ route("procurement.requests.show", ":id") }}'.replace(':id', requestId) + '#comments';
}

function refreshDashboard() {
    location.reload();
}

function executeBulkAction() {
    const actionType = document.getElementById('bulkActionType').value;
    const filterCriteria = document.getElementById('bulkFilterCriteria').value;
    
    if (!actionType) {
        alert('Please select an action type');
        return;
    }
    
    // Implementation for bulk actions
    console.log('Executing bulk action:', actionType, 'with filter:', filterCriteria);
    // Add actual implementation here
}
</script>

@endsection