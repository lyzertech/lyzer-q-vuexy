@extends('layouts/layoutMaster')

@section('title', $supplier->supplier_name . ' - Supplier Details')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection


@section('content')

<!-- Supplier Header -->
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg me-4">
                                <span class="avatar-initial rounded bg-label-primary fs-2 fw-bold">
                                    {{ strtoupper(substr($supplier->supplier_name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $supplier->supplier_name }}</h4>
                                <p class="text-muted mb-0">{{ $supplier->supplier_code }}</p>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-{{ $supplier->status === 'active' ? 'success' : 'secondary' }} me-2">
                                        {{ ucfirst($supplier->status) }}
                                    </span>
                                    @if($supplier->category)
                                    <span class="badge bg-label-info me-2">{{ $supplier->category }}</span>
                                    @endif
                                    @if($supplier->is_preferred)
                                    <span class="badge bg-label-warning">Preferred</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="btn-group" role="group">
                            <a href="{{ route('procurement.suppliers.edit', $supplier->id_supplier) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="toggleStatus('{{ $supplier->id_supplier }}', '{{ $supplier->status }}')">
                                    <i class="bx bx-{{ $supplier->status === 'active' ? 'x' : 'check' }}-circle me-1"></i>
                                    {{ $supplier->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('procurement.suppliers.performance') }}?supplier_id={{ $supplier->id_supplier }}">
                                    <i class="bx bx-line-chart me-1"></i>Performance Report
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="exportSupplierData('{{ $supplier->id_supplier }}')">
                                    <i class="bx bx-export me-1"></i>Export Data
                                </a></li>
                            </ul>
                        </div>
                        <a href="{{ route('procurement.suppliers.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bx bx-arrow-back me-1"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Row -->
<div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="bx bx-receipt fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['total_pos'] ?? 0 }}</h4>
                <p class="mb-0">Total POs</p>
                <small class="text-muted">Rp {{ number_format($stats['total_value'] ?? 0, 0, ',', '.') }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="bx bx-trending-up fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ number_format($supplier->performance_score ?? 0, 1) }}%</h4>
                <p class="mb-0">Performance</p>
                <small class="text-muted">Last 6 months</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="bx bx-time fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['avg_delivery_days'] ?? 0 }}</h4>
                <p class="mb-0">Avg Delivery</p>
                <small class="text-muted">Days</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-primary">
                        <i class="bx bx-calendar fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['last_order_days'] ?? 'N/A' }}</h4>
                <p class="mb-0">Last Order</p>
                <small class="text-muted">Days ago</small>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-6">
    <!-- Left Column - Supplier Information -->
    <div class="col-12 col-lg-8">
        <!-- Contact Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Contact Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Contact Person</h6>
                        <p class="mb-0">{{ $supplier->contact_person ?: 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Email</h6>
                        <p class="mb-0">
                            @if($supplier->contact_email)
                                <a href="mailto:{{ $supplier->contact_email }}">{{ $supplier->contact_email }}</a>
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Phone</h6>
                        <p class="mb-0">
                            @if($supplier->contact_phone)
                                <a href="tel:{{ $supplier->contact_phone }}">{{ $supplier->contact_phone }}</a>
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Website</h6>
                        <p class="mb-0">
                            @if($supplier->website)
                                <a href="{{ $supplier->website }}" target="_blank">{{ $supplier->website }}</a>
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    @if($supplier->address)
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Address</h6>
                        <p class="mb-0">{{ $supplier->address }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Business Terms -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Business Terms & Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Payment Terms</h6>
                        <p class="mb-0">{{ $supplier->payment_terms ? $supplier->payment_terms . ' days' : 'Not specified' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Delivery Terms</h6>
                        <p class="mb-0">{{ $supplier->delivery_terms ?: 'Not specified' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Currency</h6>
                        <p class="mb-0">{{ $supplier->currency ?: 'IDR' }}</p>
                    </div>
                    @if($supplier->tax_id)
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tax ID / NPWP</h6>
                        <p class="mb-0">{{ $supplier->tax_id }}</p>
                    </div>
                    @endif
                    @if($supplier->bank_account)
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Bank Account</h6>
                        <p class="mb-0">{{ $supplier->bank_account }}</p>
                    </div>
                    @endif
                    @if($supplier->products_services)
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Products & Services</h6>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(explode(',', $supplier->products_services) as $item)
                                <span class="badge bg-label-secondary">{{ trim($item) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($supplier->notes)
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Notes</h6>
                        <p class="mb-0">{{ $supplier->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Purchase Orders -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Purchase Orders</h5>
                <a href="{{ route('procurement.po.index') }}?supplier_id={{ $supplier->id_supplier }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Request</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPOs as $po)
                        <tr>
                            <td>
                                <a href="{{ route('procurement.po.show', $po->id_purchase_order) }}" class="fw-medium">
                                    {{ $po->po_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('procurement.requests.show', $po->procurementRequest->id_procurement_request) }}" class="text-primary">
                                    {{ $po->procurementRequest->request_number }}
                                </a>
                            </td>
                            <td>Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ \App\Enums\procurement\PurchaseOrderStatus::from($po->status)->color() }}">
                                    {{ \App\Enums\procurement\PurchaseOrderStatus::from($po->status)->label() }}
                                </span>
                            </td>
                            <td>{{ $po->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('procurement.po.show', $po->id_purchase_order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bx bx-receipt fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No purchase orders yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column - Performance & Actions -->
    <div class="col-12 col-lg-4">
        <!-- Performance Chart -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Performance Trend</h5>
            </div>
            <div class="card-body">
                <div id="performanceChart"></div>
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Quality Score</span>
                        <span class="fw-medium">{{ number_format($performanceMetrics['quality_score'] ?? 85, 1) }}%</span>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: {{ $performanceMetrics['quality_score'] ?? 85 }}%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Delivery Score</span>
                        <span class="fw-medium">{{ number_format($performanceMetrics['delivery_score'] ?? 78, 1) }}%</span>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-info" style="width: {{ $performanceMetrics['delivery_score'] ?? 78 }}%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Communication</span>
                        <span class="fw-medium">{{ number_format($performanceMetrics['communication_score'] ?? 92, 1) }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: {{ $performanceMetrics['communication_score'] ?? 92 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('procurement.po.create') }}?supplier_id={{ $supplier->id_supplier }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>Create PO
                    </a>
                    <button type="button" class="btn btn-outline-info" onclick="requestQuote('{{ $supplier->id_supplier }}')">
                        <i class="bx bx-message-dots me-2"></i>Request Quote
                    </button>
                    <a href="#" class="btn btn-outline-secondary" onclick="viewPerformanceReport('{{ $supplier->id_supplier }}')">
                        <i class="bx bx-line-chart me-2"></i>Performance Report
                    </a>
                    @if($supplier->contact_email)
                    <a href="mailto:{{ $supplier->contact_email }}" class="btn btn-outline-secondary">
                        <i class="bx bx-envelope me-2"></i>Send Email
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Supplier Details -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Supplier Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Member Since</small>
                    <p class="mb-0 fw-medium">{{ $supplier->created_at->format('M d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0 fw-medium">{{ $supplier->updated_at->format('M d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Capabilities</small>
                    <div class="mt-1">
                        @if($supplier->can_dropship)
                        <span class="badge bg-label-success me-1">Dropship</span>
                        @endif
                        @if($supplier->is_preferred)
                        <span class="badge bg-label-warning me-1">Preferred</span>
                        @endif
                        @if($supplier->status === 'active')
                        <span class="badge bg-label-success">Active</span>
                        @else
                        <span class="badge bg-label-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Performance chart data
window.performanceData = @json($performanceChart ?? []);

function toggleStatus(supplierId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this supplier?`)) {
        fetch(`{{ route('procurement.suppliers.toggle_status', ':id') }}`.replace(':id', supplierId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function requestQuote(supplierId) {
    // Implementation for requesting quote
    alert('Quote request functionality to be implemented');
}

function viewPerformanceReport(supplierId) {
    window.open(`{{ route('procurement.suppliers.performance') }}?supplier_id=${supplierId}`, '_blank');
}

function exportSupplierData(supplierId) {
    window.location.href = `{{ route('procurement.suppliers.export') }}?supplier_id=${supplierId}`;
}
</script>

@endsection