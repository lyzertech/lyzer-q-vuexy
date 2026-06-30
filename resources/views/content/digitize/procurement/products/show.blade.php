@extends('layouts/layoutMaster')

@section('title', $product->product_name . ' - Product Details')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection


@section('content')

<!-- Product Header -->
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg me-4">
                                <span class="avatar-initial rounded bg-label-primary fs-2 fw-bold">
                                    {{ strtoupper(substr($product->product_name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $product->product_name }}</h4>
                                <p class="text-muted mb-0">{{ $product->product_code ?: 'No code assigned' }}</p>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }} me-2">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                    @if($product->category)
                                    <span class="badge bg-label-info me-2">{{ $product->category }}</span>
                                    @endif
                                    @if($product->is_serialized)
                                    <span class="badge bg-label-warning me-1">Serialized</span>
                                    @endif
                                    @if($product->requires_approval)
                                    <span class="badge bg-label-danger me-1">Approval Required</span>
                                    @endif
                                    @if($product->is_hazardous)
                                    <span class="badge bg-label-warning">Hazardous</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="btn-group" role="group">
                            <a href="{{ route('procurement.products.edit', $product->id_product) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="duplicateProduct('{{ $product->id_product }}', '{{ $product->product_name }}')">
                                    <i class="bx bx-copy me-1"></i>Duplicate Product
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="toggleStatus('{{ $product->id_product }}', '{{ $product->status }}')">
                                    <i class="bx bx-{{ $product->status === 'active' ? 'x' : 'check' }}-circle me-1"></i>
                                    {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="exportProductData('{{ $product->id_product }}')">
                                    <i class="bx bx-export me-1"></i>Export Data
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="printProductLabel('{{ $product->id_product }}')">
                                    <i class="bx bx-printer me-1"></i>Print Label
                                </a></li>
                            </ul>
                        </div>
                        <a href="{{ route('procurement.products.index') }}" class="btn btn-outline-secondary ms-2">
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
                    <span class="avatar-initial rounded bg-label-{{ $stockStatus['color'] ?? 'success' }}">
                        <i class="bx bx-package fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $product->current_stock ?? 0 }}</h4>
                <p class="mb-0">Current Stock</p>
                <small class="text-{{ $stockStatus['color'] ?? 'muted' }}">{{ $stockStatus['text'] ?? 'In Stock' }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="bx bx-money fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">Rp {{ number_format($product->unit_price ?? 0, 0, ',', '.') }}</h4>
                <p class="mb-0">Unit Price</p>
                <small class="text-muted">per {{ $product->unit_of_measure ?? 'PCS' }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="bx bx-shopping-bag fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['total_procured'] ?? 0 }}</h4>
                <p class="mb-0">Total Procured</p>
                <small class="text-muted">All time</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-primary">
                        <i class="bx bx-time fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $product->lead_time_days ?? 0 }}</h4>
                <p class="mb-0">Lead Time</p>
                <small class="text-muted">Days</small>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-6">
    <!-- Left Column - Product Information -->
    <div class="col-12 col-lg-8">
        <!-- Product Specifications -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Specifications</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Brand</h6>
                        <p class="mb-0">{{ $product->brand ?: 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Model Number</h6>
                        <p class="mb-0">{{ $product->model_number ?: 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Unit of Measure</h6>
                        <p class="mb-0">{{ $product->unit_of_measure ?? 'PCS' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Warranty Period</h6>
                        <p class="mb-0">{{ $product->warranty_period ?: 'Not specified' }}</p>
                    </div>
                    @if($product->specifications)
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Technical Specifications</h6>
                        <p class="mb-0">{{ $product->specifications }}</p>
                    </div>
                    @endif
                    @if($product->notes)
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Notes</h6>
                        <p class="mb-0">{{ $product->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stock Management -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Stock Management</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Current Stock</h6>
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 me-2">{{ $product->current_stock ?? 0 }}</h5>
                            <span class="badge bg-{{ $stockStatus['color'] ?? 'success' }}">{{ $stockStatus['text'] ?? 'In Stock' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Minimum Level</h6>
                        <p class="mb-0 fw-medium">{{ $product->min_stock_level ?? 0 }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Reorder Point</h6>
                        <p class="mb-0 fw-medium">{{ $product->reorder_point ?? 0 }}</p>
                    </div>
                    
                    <div class="col-12">
                        <div class="progress-stacked">
                            <div class="progress" style="width: {{ min(($product->current_stock / max($product->reorder_point, 1)) * 100, 100) }}%">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">Min: {{ $product->min_stock_level ?? 0 }}</small>
                            <small class="text-muted">Reorder: {{ $product->reorder_point ?? 0 }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supplier Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Supplier Information</h5>
            </div>
            <div class="card-body">
                @if($product->primarySupplier)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Primary Supplier</h6>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                {{ strtoupper(substr($product->primarySupplier->supplier_name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0">
                                <a href="{{ route('procurement.suppliers.show', $product->primarySupplier->id_supplier) }}">
                                    {{ $product->primarySupplier->supplier_name }}
                                </a>
                            </h6>
                            <small class="text-muted">{{ $product->primarySupplier->contact_email }}</small>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($product->alternativeSuppliers && $product->alternativeSuppliers->count() > 0)
                <div>
                    <h6 class="text-muted mb-2">Alternative Suppliers</h6>
                    <div class="row g-3">
                        @foreach($product->alternativeSuppliers as $supplier)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        {{ strtoupper(substr($supplier->supplier_name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0 small">
                                        <a href="{{ route('procurement.suppliers.show', $supplier->id_supplier) }}">
                                            {{ $supplier->supplier_name }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(!$product->primarySupplier && (!$product->alternativeSuppliers || $product->alternativeSuppliers->count() === 0))
                <div class="text-center py-4">
                    <i class="bx bx-store fs-1 text-muted"></i>
                    <p class="text-muted mt-2">No suppliers assigned</p>
                    <a href="{{ route('procurement.products.edit', $product->id_product) }}" class="btn btn-sm btn-outline-primary">
                        Add Suppliers
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Usage History -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Usage History</h5>
                <a href="#" onclick="viewFullHistory('{{ $product->id_product }}')" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Request #</th>
                            <th>Quantity</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsage as $item)
                        <tr>
                            <td>
                                <a href="{{ route('procurement.requests.show', $item->procurementRequest->id_procurement_request) }}" class="fw-medium">
                                    {{ $item->procurementRequest->request_number }}
                                </a>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $item->quantity }}</span>
                                <small class="text-muted d-block">{{ $item->unit_of_measure ?? $product->unit_of_measure }}</small>
                            </td>
                            <td>
                                <span>{{ Str::limit($item->purpose ?? $item->procurementRequest->title, 30) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ \App\Enums\procurement\ProcurementItemStatus::from($item->status)->color() }}">
                                    {{ \App\Enums\procurement\ProcurementItemStatus::from($item->status)->label() }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('procurement.requests.show', $item->procurementRequest->id_procurement_request) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bx bx-history fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No usage history yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column - Analytics & Actions -->
    <div class="col-12 col-lg-4">
        <!-- Stock Trend Chart -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Stock Trend</h5>
            </div>
            <div class="card-body">
                <div id="stockTrendChart"></div>
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Stock Turnover</span>
                        <span class="fw-medium">{{ number_format($analytics['turnover_rate'] ?? 0, 1) }}x</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Days Supply</span>
                        <span class="fw-medium">{{ $analytics['days_supply'] ?? 0 }} days</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Avg Monthly Usage</span>
                        <span class="fw-medium">{{ $analytics['avg_monthly_usage'] ?? 0 }}</span>
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
                    <a href="{{ route('procurement.requests.create') }}?product_id={{ $product->id_product }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>Create Request
                    </a>
                    <button type="button" class="btn btn-outline-info" onclick="adjustStock('{{ $product->id_product }}')">
                        <i class="bx bx-edit me-2"></i>Adjust Stock
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="createReorder('{{ $product->id_product }}')">
                        <i class="bx bx-refresh me-2"></i>Create Reorder
                    </button>
                    <a href="#" onclick="viewStockHistory('{{ $product->id_product }}')" class="btn btn-outline-secondary">
                        <i class="bx bx-history me-2"></i>Stock History
                    </a>
                    <button type="button" class="btn btn-outline-secondary" onclick="printProductLabel('{{ $product->id_product }}')">
                        <i class="bx bx-printer me-2"></i>Print Label
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Summary -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Created</small>
                    <p class="mb-0 fw-medium">{{ $product->created_at->format('M d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0 fw-medium">{{ $product->updated_at->format('M d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Times Used</small>
                    <p class="mb-0 fw-medium">{{ $product->procurementItems->count() ?? 0 }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Product Features</small>
                    <div class="mt-1">
                        @if($product->is_serialized)
                        <span class="badge bg-label-info me-1">Serialized</span>
                        @endif
                        @if($product->requires_approval)
                        <span class="badge bg-label-warning me-1">Approval Required</span>
                        @endif
                        @if($product->is_hazardous)
                        <span class="badge bg-label-danger me-1">Hazardous</span>
                        @endif
                        <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Adjustment Modal -->
<div class="modal fade" id="stockAdjustmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjust Stock Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="stockAdjustmentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Stock</label>
                        <input type="text" class="form-control" value="{{ $product->current_stock ?? 0 }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="adjustment_type">Adjustment Type</label>
                        <select class="form-select" id="adjustment_type" name="adjustment_type" required>
                            <option value="">Select Type</option>
                            <option value="increase">Increase Stock</option>
                            <option value="decrease">Decrease Stock</option>
                            <option value="set">Set Exact Amount</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="adjustment_quantity">Quantity</label>
                        <input type="number" class="form-control" id="adjustment_quantity" name="quantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="adjustment_reason">Reason</label>
                        <textarea class="form-control" id="adjustment_reason" name="reason" rows="3" placeholder="Reason for stock adjustment" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Adjust Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Chart data
window.stockTrendData = @json($stockTrendChart ?? []);

function toggleStatus(productId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this product?`)) {
        fetch(`{{ route('procurement.products.toggle_status', ':id') }}`.replace(':id', productId), {
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

function duplicateProduct(productId, productName) {
    if (confirm(`Create a duplicate of "${productName}"?`)) {
        fetch(`{{ route('procurement.products.duplicate', ':id') }}`.replace(':id', productId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `{{ route('procurement.products.edit', ':id') }}`.replace(':id', data.product_id);
            }
        });
    }
}

function adjustStock(productId) {
    document.getElementById('stockAdjustmentForm').action = `/procurement/products/${productId}/adjust-stock`;
    new bootstrap.Modal(document.getElementById('stockAdjustmentModal')).show();
}

function createReorder(productId) {
    if (confirm('Create an automatic reorder for this product?')) {
        window.location.href = `{{ route('procurement.requests.create') }}?product_id=${productId}&auto_reorder=1`;
    }
}

function viewStockHistory(productId) {
    window.open(`/procurement/products/${productId}/stock-history`, '_blank');
}

function viewFullHistory(productId) {
    window.open(`/procurement/products/${productId}/usage-history`, '_blank');
}

function exportProductData(productId) {
    window.location.href = `{{ route('procurement.products.export') }}?product_id=${productId}`;
}

function printProductLabel(productId) {
    window.open(`/procurement/products/${productId}/print-label`, '_blank');
}
</script>

@endsection