@extends('layouts/layoutMaster')

@section('title', 'Customers Management - Procurement')

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
                            <i class="bx bx-user fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Total Customers</p>
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
                        <p class="mb-0">Active Customers</p>
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
                            <i class="bx bx-file fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">This Month Requests</p>
                        <h4 class="mb-0">{{ $stats['monthly_requests'] ?? 0 }}</h4>
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
                        <p class="mb-0">Avg Request Value</p>
                        <h4 class="mb-0">{{ number_format($stats['avg_request_value'] ?? 0, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div>
            <h5 class="card-title mb-0">Customer Directory</h5>
            <p class="text-muted mt-1 mb-0">Manage your customer relationships and request history</p>
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
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Type:</label>
                <select class="form-select form-select-sm" id="typeFilter" style="min-width: 120px;">
                    <option value="">All Types</option>
                    <option value="corporate">Corporate</option>
                    <option value="individual">Individual</option>
                    <option value="government">Government</option>
                </select>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bx bx-import me-1"></i>Import
                </button>
                <a href="{{ route('procurement.customers.export') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-export me-1"></i>Export
                </a>
            </div>
            <a href="{{ route('procurement.customers.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Add Customer
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="customersTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact Info</th>
                    <th>Type</th>
                    <th>Total Requests</th>
                    <th>Total Value</th>
                    <th>Last Request</th>
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
                <h5 class="modal-title">Import Customers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('procurement.customers.bulk_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">CSV File</label>
                        <input type="file" class="form-control" name="import_file" accept=".csv,.xlsx" required>
                        <div class="form-text">
                            Upload CSV or Excel file. 
                            <a href="{{ asset('templates/customers-template.csv') }}" class="text-primary">Download template</a>
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

<!-- Customer Analytics Modal -->
<div class="modal fade" id="analyticsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer Analytics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="analyticsContent">
                    <!-- Dynamic content loaded via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// DataTable configuration
window.customersTableConfig = {
    ajax: {
        url: '{{ route("procurement.customers.data") }}',
        data: function(d) {
            d.status = $('#statusFilter').val();
            d.customer_type = $('#typeFilter').val();
        }
    },
    columns: [
        {
            data: 'customer_name',
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
                                <a href="${'{{ route("procurement.customers.show", ":id") }}'.replace(':id', row.id_customer)}" class="text-body">
                                    ${data}
                                </a>
                            </h6>
                            <small class="text-muted">${row.customer_code || 'N/A'}</small>
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
            data: 'customer_type',
            render: function(data, type, row) {
                const colors = {
                    'corporate': 'primary',
                    'individual': 'info', 
                    'government': 'warning',
                    'other': 'secondary'
                };
                const label = data ? data.charAt(0).toUpperCase() + data.slice(1) : 'Other';
                return `<span class="badge bg-label-${colors[data] || 'secondary'}">${label}</span>`;
            }
        },
        {
            data: 'total_requests',
            render: function(data, type, row) {
                return `
                    <div class="text-center">
                        <h6 class="mb-0">${data || 0}</h6>
                        <small class="text-muted">${row.completed_requests || 0} completed</small>
                    </div>
                `;
            }
        },
        {
            data: 'total_value',
            render: function(data, type, row) {
                const value = data || 0;
                return `
                    <div class="text-end">
                        <span class="fw-medium">Rp ${new Intl.NumberFormat('id-ID').format(value)}</span>
                        <small class="text-muted d-block">Total value</small>
                    </div>
                `;
            }
        },
        {
            data: 'last_request_date',
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
                            <a class="dropdown-item" href="${'{{ route("procurement.customers.show", ":id") }}'.replace(':id', row.id_customer)}">
                                <i class="bx bx-show me-1"></i> View Details
                            </a>
                            <a class="dropdown-item" href="${'{{ route("procurement.customers.edit", ":id") }}'.replace(':id', row.id_customer)}">
                                <i class="bx bx-edit me-1"></i> Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="viewAnalytics('${row.id_customer}')">
                                <i class="bx bx-line-chart me-1"></i> Analytics
                            </a>
                            <a class="dropdown-item" href="${'{{ route("procurement.customers.request_history", ":id") }}'.replace(':id', row.id_customer)}">
                                <i class="bx bx-history me-1"></i> Request History
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="toggleStatus('${row.id_customer}', '${row.status}')">
                                <i class="bx bx-${row.status === 'active' ? 'x' : 'check'}-circle me-1"></i> 
                                ${row.status === 'active' ? 'Deactivate' : 'Activate'}
                            </a>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteCustomer('${row.id_customer}')">
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
function toggleStatus(customerId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this customer?`)) {
        fetch(`{{ route('procurement.customers.toggle_status', ':id') }}`.replace(':id', customerId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#customersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function deleteCustomer(customerId) {
    if (confirm('Are you sure you want to delete this customer? This action cannot be undone.')) {
        fetch(`{{ route('procurement.customers.destroy', ':id') }}`.replace(':id', customerId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#customersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function viewAnalytics(customerId) {
    // Load analytics details via AJAX
    fetch(`{{ route('procurement.customers.analytics', ':id') }}`.replace(':id', customerId))
        .then(response => response.text())
        .then(html => {
            document.getElementById('analyticsContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('analyticsModal')).show();
        });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Status filter change
    document.getElementById('statusFilter').addEventListener('change', function() {
        $('#customersTable').DataTable().ajax.reload();
    });
    
    // Type filter change
    document.getElementById('typeFilter').addEventListener('change', function() {
        $('#customersTable').DataTable().ajax.reload();
    });
});
</script>

@endsection