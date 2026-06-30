@extends('layouts/layoutMaster')

@section('title', 'Products Management - Procurement')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
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
                            <i class="bx bx-box fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Total Products</p>
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
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
                        <p class="mb-0">Active Products</p>
                        <h4 class="mb-0">{{ $stats['active'] ?? 0 }}</h4>
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
                            <i class="bx bx-error fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Low Stock</p>
                        <h4 class="mb-0">{{ $stats['low_stock'] ?? 0 }}</h4>
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
                            <i class="bx bx-category fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Categories</p>
                        <h4 class="mb-0">{{ $stats['categories'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div>
            <h5 class="card-title mb-0">Product Catalog</h5>
            <p class="text-muted mt-1 mb-0">Manage your product inventory and specifications</p>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mt-3 mt-md-0 gap-3">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Category:</label>
                <select class="form-select form-select-sm" id="categoryFilter" style="min-width: 140px;">
                    <option value="">All Categories</option>
                    <!-- Categories will be loaded dynamically -->
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Status:</label>
                <select class="form-select form-select-sm" id="statusFilter" style="min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Stock:</label>
                <select class="form-select form-select-sm" id="stockFilter" style="min-width: 120px;">
                    <option value="">All Stock</option>
                    <option value="in_stock">In Stock</option>
                    <option value="low_stock">Low Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bx bx-import me-1"></i>Import
                </button>
                <a href="{{ route('procurement.products.export') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-export me-1"></i>Export
                </a>
            </div>
            <a href="{{ route('procurement.products.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Add Product
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="productsTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Stock Level</th>
                    <th>Unit Price</th>
                    <th>Suppliers</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('procurement.products.bulk_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">CSV File</label>
                        <input type="file" class="form-control" name="import_file" accept=".csv,.xlsx" required>
                        <div class="form-text">
                            Upload CSV or Excel file. 
                            <a href="{{ asset('templates/products-template.csv') }}" class="text-primary">Download template</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="skip_duplicates" id="skipDuplicates" checked>
                            <label class="form-check-label" for="skipDuplicates">
                                Skip duplicate entries
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="update_existing" id="updateExisting">
                            <label class="form-check-label" for="updateExisting">
                                Update existing products
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productDetailsContent">
                    <!-- Dynamic content loaded via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Duplicate Product Modal -->
<div class="modal fade" id="duplicateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Duplicate Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="duplicateForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="duplicate_product_name">New Product Name *</label>
                        <input type="text" class="form-control" id="duplicate_product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duplicate_product_code">New Product Code</label>
                        <input type="text" class="form-control" id="duplicate_product_code" name="product_code">
                        <div class="form-text">Leave empty to auto-generate</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="copy_specifications" name="copy_specifications" checked>
                            <label class="form-check-label" for="copy_specifications">
                                Copy specifications and details
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Duplicate Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Load categories for filter
fetch('{{ route("procurement.products.categories") }}')
    .then(response => response.json())
    .then(categories => {
        const categoryFilter = document.getElementById('categoryFilter');
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            categoryFilter.appendChild(option);
        });
    });

// DataTable configuration
window.productsTableConfig = {
    ajax: {
        url: '{{ route("procurement.products.data") }}',
        data: function(d) {
            d.category = $('#categoryFilter').val();
            d.status = $('#statusFilter').val();
            d.stock_level = $('#stockFilter').val();
        }
    },
    columns: [
        {
            data: 'product_name',
            render: function(data, type, row) {
                return `
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                ${data.substring(0, 2).toUpperCase()}
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0">
                                <a href="${'{{ route("procurement.products.show", ":id") }}'.replace(':id', row.id_product)}" class="text-body">
                                    ${data}
                                </a>
                            </h6>
                            <small class="text-muted">${row.product_code || 'No code'}</small>
                        </div>
                    </div>
                `;
            }
        },
        {
            data: 'category',
            render: function(data, type, row) {
                if (!data) return '<span class="text-muted">Uncategorized</span>';
                const colors = {
                    'Electronics': 'primary',
                    'Materials': 'info', 
                    'Tools': 'warning',
                    'Equipment': 'success',
                    'Consumables': 'secondary'
                };
                return `<span class="badge bg-label-${colors[data] || 'secondary'}">${data}</span>`;
            }
        },
        {
            data: 'unit_of_measure',
            render: function(data, type, row) {
                return `<span class="text-muted">${data || 'PCS'}</span>`;
            }
        },
        {
            data: 'current_stock',
            render: function(data, type, row) {
                const current = data || 0;
                const min = row.min_stock_level || 0;
                let stockStatus = 'success';
                let stockText = 'In Stock';
                
                if (current === 0) {
                    stockStatus = 'danger';
                    stockText = 'Out of Stock';
                } else if (current <= min) {
                    stockStatus = 'warning';
                    stockText = 'Low Stock';
                }
                
                return `
                    <div class="text-center">
                        <h6 class="mb-0">${current}</h6>
                        <small class="badge bg-${stockStatus} badge-sm">${stockText}</small>
                        ${min > 0 ? `<div class="text-muted small">Min: ${min}</div>` : ''}
                    </div>
                `;
            }
        },
        {
            data: 'unit_price',
            render: function(data, type, row) {
                const price = data || 0;
                return `
                    <div class="text-end">
                        <span class="fw-medium">Rp ${new Intl.NumberFormat('id-ID').format(price)}</span>
                        <small class="text-muted d-block">per ${row.unit_of_measure || 'PCS'}</small>
                    </div>
                `;
            }
        },
        {
            data: 'suppliers_count',
            render: function(data, type, row) {
                const count = data || 0;
                return `
                    <div class="text-center">
                        <span class="badge bg-label-info">${count}</span>
                        ${count > 0 ? `<div class="text-muted small">suppliers</div>` : '<div class="text-muted small">No suppliers</div>'}
                    </div>
                `;
            }
        },
        {
            data: 'status',
            render: function(data, type, row) {
                const isActive = data === 'active';
                return `<span class="badge bg-${isActive ? 'success' : 'secondary'}">${isActive ? 'Active' : 'Inactive'}</span>`;
            }
        },
        {
            data: null,
            orderable: false,
            render: function(data, type, row) {
                return `
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="${'{{ route("procurement.products.show", ":id") }}'.replace(':id', row.id_product)}">
                                <i class="bx bx-show me-1"></i> View Details
                            </a>
                            <a class="dropdown-item" href="${'{{ route("procurement.products.edit", ":id") }}'.replace(':id', row.id_product)}">
                                <i class="bx bx-edit me-1"></i> Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="duplicateProduct('${row.id_product}', '${row.product_name}')">
                                <i class="bx bx-copy me-1"></i> Duplicate
                            </a>
                            <a class="dropdown-item" href="#" onclick="checkCodeAvailability('${row.product_code}')">
                                <i class="bx bx-search me-1"></i> Check Code
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="toggleStatus('${row.id_product}', '${row.status}')">
                                <i class="bx bx-${row.status === 'active' ? 'x' : 'check'}-circle me-1"></i> 
                                ${row.status === 'active' ? 'Deactivate' : 'Activate'}
                            </a>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteProduct('${row.id_product}')">
                                <i class="bx bx-trash me-1"></i> Delete
                            </a>
                        </div>
                    </div>
                `;
            }
        }
    ]
};

// Functions
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
                $('#productsTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        fetch(`{{ route('procurement.products.destroy', ':id') }}`.replace(':id', productId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#productsTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function duplicateProduct(productId, productName) {
    document.getElementById('duplicate_product_name').value = productName + ' (Copy)';
    document.getElementById('duplicate_product_code').value = '';
    document.getElementById('duplicateForm').action = `{{ route('procurement.products.duplicate', ':id') }}`.replace(':id', productId);
    new bootstrap.Modal(document.getElementById('duplicateModal')).show();
}

function checkCodeAvailability(productCode) {
    if (!productCode) {
        alert('No product code to check');
        return;
    }
    
    fetch(`{{ route('procurement.products.check_code') }}?code=${productCode}`)
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                alert(`Product code "${productCode}" is available`);
            } else {
                alert(`Product code "${productCode}" is already in use`);
            }
        });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Filter changes
    ['categoryFilter', 'statusFilter', 'stockFilter'].forEach(filterId => {
        document.getElementById(filterId).addEventListener('change', function() {
            $('#productsTable').DataTable().ajax.reload();
        });
    });
});
</script>

@endsection