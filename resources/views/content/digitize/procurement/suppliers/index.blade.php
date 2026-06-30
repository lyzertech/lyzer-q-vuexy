@extends('layouts/layoutMaster')

@section('title', 'Suppliers Management - Procurement')

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
                            <i class="bx bx-store fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Total Suppliers</p>
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
                        <p class="mb-0">Active Suppliers</p>
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
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-receipt fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">This Month POs</p>
                        <h4 class="mb-0">{{ $stats['monthly_pos'] ?? 0 }}</h4>
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
                            <i class="bx bx-trending-up fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Avg Performance</p>
                        <h4 class="mb-0">{{ number_format($stats['avg_performance'] ?? 0, 1) }}%</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Suppliers Table -->
<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div>
            <h5 class="card-title mb-0">Suppliers Directory</h5>
            <p class="text-muted mt-1 mb-0">Manage your supplier relationships and performance</p>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mt-3 mt-md-0 gap-3">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Status:</label>
                <select class="form-select form-select-sm" id="statusFilter" style="min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bx bx-import me-1"></i>Import
                </button>
                <a href="{{ route('procurement.suppliers.export') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-export me-1"></i>Export
                </a>
            </div>
            <a href="{{ route('procurement.suppliers.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Add Supplier
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="suppliersTable">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Contact Info</th>
                    <th>Category</th>
                    <th>Performance</th>
                    <th>Total POs</th>
                    <th>Last Order</th>
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
                <h5 class="modal-title">Import Suppliers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('procurement.suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">CSV File</label>
                        <input type="file" class="form-control" name="import_file" accept=".csv,.xlsx" required>
                        <div class="form-text">
                            Upload CSV or Excel file. 
                            <a href="{{ asset('templates/suppliers-template.csv') }}" class="text-primary">Download template</a>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Performance Details Modal -->
<div class="modal fade" id="performanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supplier Performance Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="performanceContent">
                    <!-- Dynamic content loaded via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// DataTable configuration
window.suppliersTableConfig = {
    ajax: {
        url: '{{ route("procurement.suppliers.data") }}',
        data: function(d) {
            d.status = $('#statusFilter').val();
        }
    },
    columns: [
        {
            data: 'supplier_name',
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
                                <a href="${'{{ route("procurement.suppliers.show", ":id") }}'.replace(':id', row.id_supplier)}" class="text-body">
                                    ${data}
                                </a>
                            </h6>
                            <small class="text-muted">${row.supplier_code}</small>
                        </div>
                    </div>
                `;
            }
        },
        {
            data: 'contact_email',
            render: function(data, type, row) {
                return `
                    <div class="small">
                        <div><i class="bx bx-envelope me-1 text-muted"></i>${data || '-'}</div>
                        <div><i class="bx bx-phone me-1 text-muted"></i>${row.contact_phone || '-'}</div>
                    </div>
                `;
            }
        },
        {
            data: 'category',
            render: function(data, type, row) {
                const colors = {
                    'Materials': 'primary',
                    'Services': 'info', 
                    'Equipment': 'warning',
                    'Others': 'secondary'
                };
                return `<span class="badge bg-label-${colors[data] || 'secondary'}">${data || 'Others'}</span>`;
            }
        },
        {
            data: 'performance_score',
            render: function(data, type, row) {
                const score = data || 0;
                const color = score >= 90 ? 'success' : score >= 70 ? 'warning' : 'danger';
                return `
                    <div class="d-flex align-items-center">
                        <div class="progress me-2" style="width: 60px; height: 6px;">
                            <div class="progress-bar bg-${color}" style="width: ${score}%"></div>
                        </div>
                        <small class="text-${color} fw-medium">${score}%</small>
                    </div>
                    <small class="text-muted d-block">
                        <a href="#" onclick="viewPerformance('${row.id_supplier}')" class="text-decoration-underline">
                            View Details
                        </a>
                    </small>
                `;
            }
        },
        {
            data: 'total_pos',
            render: function(data, type, row) {
                return `
                    <div class="text-center">
                        <h6 class="mb-0">${data || 0}</h6>
                        <small class="text-muted">Rp ${new Intl.NumberFormat('id-ID').format(row.total_value || 0)}</small>
                    </div>
                `;
            }
        },
        {
            data: 'last_order_date',
            render: function(data, type, row) {
                if (!data) return '<span class="text-muted">Never</span>';
                const date = new Date(data);
                const daysDiff = Math.floor((new Date() - date) / (1000 * 60 * 60 * 24));
                let timeAgo = '';
                if (daysDiff === 0) timeAgo = 'Today';
                else if (daysDiff === 1) timeAgo = 'Yesterday';
                else if (daysDiff < 30) timeAgo = `${daysDiff} days ago`;
                else if (daysDiff < 365) timeAgo = `${Math.floor(daysDiff/30)} months ago`;
                else timeAgo = `${Math.floor(daysDiff/365)} years ago`;
                
                return `
                    <div class="small">
                        <div>${date.toLocaleDateString('id-ID')}</div>
                        <div class="text-muted">${timeAgo}</div>
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
                            <a class="dropdown-item" href="${'{{ route("procurement.suppliers.show", ":id") }}'.replace(':id', row.id_supplier)}">
                                <i class="bx bx-show me-1"></i> View Details
                            </a>
                            <a class="dropdown-item" href="${'{{ route("procurement.suppliers.edit", ":id") }}'.replace(':id', row.id_supplier)}">
                                <i class="bx bx-edit me-1"></i> Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="toggleStatus('${row.id_supplier}', '${row.status}')">
                                <i class="bx bx-${row.status === 'active' ? 'x' : 'check'}-circle me-1"></i> 
                                ${row.status === 'active' ? 'Deactivate' : 'Activate'}
                            </a>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteSupplier('${row.id_supplier}')">
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
                $('#suppliersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function deleteSupplier(supplierId) {
    if (confirm('Are you sure you want to delete this supplier? This action cannot be undone.')) {
        fetch(`{{ route('procurement.suppliers.destroy', ':id') }}`.replace(':id', supplierId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#suppliersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function viewPerformance(supplierId) {
    // Load performance details via AJAX
    fetch(`{{ route('procurement.suppliers.performance') }}?supplier_id=${supplierId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('performanceContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('performanceModal')).show();
        });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Status filter change
    document.getElementById('statusFilter').addEventListener('change', function() {
        $('#suppliersTable').DataTable().ajax.reload();
    });
});
</script>

@endsection