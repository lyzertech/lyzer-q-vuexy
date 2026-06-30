@extends('layouts/layoutMaster')

@section('title', 'Purchasing Dashboard - Procurement')

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
                            <i class="bx bx-receipt fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Total POs</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['total_pos'] }}</h4>
                            @if($stats['pos_this_month'] > 0)
                            <p class="text-success mb-0">(+{{ $stats['pos_this_month'] }} this month)</p>
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
                            <i class="bx bx-time-five fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Pending POs</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['pending_pos'] }}</h4>
                            <p class="text-warning mb-0">Need action</p>
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
                            <i class="bx bx-cog fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">In Production</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['items_in_production'] }}</h4>
                            <p class="text-info mb-0">Items</p>
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
                            <i class="bx bx-truck fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Shipped</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-1">{{ $stats['items_shipped'] }}</h4>
                            <p class="text-success mb-0">This month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-6">
    <!-- Recent Purchase Orders -->
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Purchase Orders</h5>
                <a href="{{ route('procurement.po.index') }}" class="btn btn-sm btn-primary">
                    View All POs
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Request</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPOs as $po)
                        <tr>
                            <td>
                                <a href="{{ route('procurement.po.show', $po->id_purchase_order) }}" 
                                   class="fw-medium">{{ $po->po_number }}</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            {{ strtoupper(substr($po->supplier->supplier_name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <span>{{ Str::limit($po->supplier->supplier_name, 20) }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('procurement.requests.show', $po->procurementRequest->id_procurement_request) }}" 
                                   class="text-primary">{{ $po->procurementRequest->request_number }}</a>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary">{{ $po->items->count() }}</span>
                            </td>
                            <td>
                                <span class="fw-medium">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ \App\Enums\procurement\PurchaseOrderStatus::from($po->status)->color() }}">
                                    {{ \App\Enums\procurement\PurchaseOrderStatus::from($po->status)->label() }}
                                </span>
                            </td>
                            <td>{{ $po->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('procurement.po.show', $po->id_purchase_order) }}">
                                            <i class="bx bx-show me-1"></i> View
                                        </a>
                                        @if($po->status === 'draft')
                                        <a class="dropdown-item" href="{{ route('procurement.po.edit', $po->id_purchase_order) }}">
                                            <i class="bx bx-edit me-1"></i> Edit
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('procurement.po.pdf', $po->id_purchase_order) }}" target="_blank">
                                            <i class="bx bx-file-blank me-1"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bx bx-receipt fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No purchase orders yet</p>
                                    <a href="{{ route('procurement.po.create') }}" class="btn btn-primary">
                                        Create First PO
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

    <!-- Supplier Performance -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Suppliers</h5>
            </div>
            <div class="card-body">
                @forelse($supplierPerformance as $supplier)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                {{ strtoupper(substr($supplier['name'], 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ Str::limit($supplier['name'], 15) }}</h6>
                            <small class="text-muted">{{ $supplier['pos_count'] }} POs</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="fw-medium">{{ $supplier['performance_score'] }}%</span>
                        <div class="progress mt-1" style="height: 4px; width: 60px;">
                            <div class="progress-bar bg-{{ $supplier['performance_score'] >= 80 ? 'success' : ($supplier['performance_score'] >= 60 ? 'warning' : 'danger') }}" 
                                 style="width: {{ $supplier['performance_score'] }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <i class="bx bx-store fs-1 text-muted"></i>
                    <p class="text-muted mt-2">No supplier data</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-6 mt-4">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly PO Trend</h5>
            </div>
            <div class="card-body">
                <div id="monthlyPOChart"></div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Items by Status</h5>
            </div>
            <div class="card-body">
                <div id="itemsStatusChart"></div>
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
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.po.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus-circle me-2"></i>New PO
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.requests.index') }}?status=approved" class="btn btn-outline-success">
                                <i class="bx bx-check me-2"></i>Ready for PO
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.po.index') }}?status=sent" class="btn btn-outline-info">
                                <i class="bx bx-send me-2"></i>Sent POs
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.arrivals.index') }}" class="btn btn-outline-warning">
                                <i class="bx bx-package me-2"></i>Arrivals
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.suppliers.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-store me-2"></i>Suppliers
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('procurement.products.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-box me-2"></i>Products
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
window.monthlyPOData = @json($monthlyData);
window.itemsStatusData = @json($itemsStatusData);

// Dashboard configuration
window.dashboardConfig = {
    stats: @json($stats),
    routes: {
        statsApi: '{{ route("procurement.reports.dashboard_stats") }}',
        poIndex: '{{ route("procurement.po.index") }}'
    }
};
</script>

@endsection