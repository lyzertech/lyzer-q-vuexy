@extends('layouts/layoutMaster')

@section('title', 'Purchase Orders - Procurement')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js'])
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
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-time-five fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Pending</p>
                        <h4 class="mb-0">{{ $stats['pending'] ?? 0 }}</h4>
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
                            <i class="bx bx-send fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Sent</p>
                        <h4 class="mb-0">{{ $stats['sent'] ?? 0 }}</h4>
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
                        <p class="mb-0">This Month Value</p>
                        <h4 class="mb-0">{{ number_format($stats['monthly_value'] ?? 0, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Orders Table -->
<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div>
            <h5 class="card-title mb-0">Purchase Orders Management</h5>
            <p class="text-muted mt-1 mb-0">Manage purchase orders and supplier transactions</p>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mt-3 mt-md-0 gap-3">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Status:</label>
                <select class="form-select form-select-sm" id="statusFilter" style="min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="sent">Sent</option>
                    <option value="acknowledged">Acknowledged</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Supplier:</label>
                <select class="form-select form-select-sm" id="supplierFilter" style="min-width: 150px;">
                    <option value="">All Suppliers</option>
                    <!-- Suppliers will be loaded dynamically -->
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">Date Range:</label>
                <input type="text" class="form-control form-control-sm" id="dateRangeFilter" placeholder="Select date range" style="min-width: 180px;">
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="bulkActions()">
                    <i class="bx bx-layer me-1"></i>Bulk Actions
                </button>
                <a href="{{ route('procurement.po.export') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-export me-1"></i>Export
                </a>
            </div>
            <a href="{{ route('procurement.po.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Create PO
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="purchaseOrdersTable">
            <thead>
                <tr>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                    </th>
                    <th>PO Details</th>
                    <th>Supplier</th>
                    <th>Request</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Dates</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
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
                    <label class="form-label">Action</label>
                    <select class="form-select" id="bulkAction" required>
                        <option value="">Select Action</option>
                        <option value="send">Send POs to Suppliers</option>
                        <option value="acknowledge">Mark as Acknowledged</option>
                        <option value="cancel">Cancel POs</option>
                        <option value="export">Export Selected</option>
                        <option value="update_status">Update Status</option>
                    </select>
                </div>
                <div class="mb-3" id="statusUpdateSection" style="display: none;">
                    <label class="form-label">New Status</label>
                    <select class="form-select" id="newStatus">
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="acknowledged">Acknowledged</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes (Optional)</label>
                    <textarea class="form-control" id="bulkNotes" rows="3" placeholder="Add notes for this action"></textarea>
                </div>
                <div class="alert alert-warning">
                    <i class="bx bx-info-circle me-2"></i>
                    <span id="selectedCount">0</span> purchase orders selected for this action.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="executeBulkAction()">Execute Action</button>
            </div>
        </div>
    </div>
</div>

<!-- PO Preview Modal -->
<div class="modal fade" id="poPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Purchase Order Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="poPreviewContent">
                    <!-- Dynamic content loaded via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printPOBtn">
                    <i class="bx bx-printer me-1"></i>Print PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Load suppliers for filter
fetch('{{ route("procurement.suppliers.search") }}')
    .then(response => response.json())
    .then(suppliers => {
        const supplierFilter = document.getElementById('supplierFilter');
        suppliers.forEach(supplier => {
            const option = document.createElement('option');
            option.value = supplier.id_supplier;
            option.textContent = supplier.supplier_name;
            supplierFilter.appendChild(option);
        });
    });

// Initialize date range picker
if (typeof flatpickr !== 'undefined') {
    flatpickr("#dateRangeFilter", {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function() {
            $('#purchaseOrdersTable').DataTable().ajax.reload();
        }
    });
}

// DataTable configuration
window.purchaseOrdersTableConfig = {
    ajax: {
        url: '{{ route("procurement.po.data") }}',
        data: function(d) {
            d.status = $('#statusFilter').val();
            d.supplier_id = $('#supplierFilter').val();
            d.date_range = $('#dateRangeFilter').val();
        }
    },
    columns: [
        {
            data: null,
            orderable: false,
            render: function(data, type, row) {
                return `<div class="form-check">
                    <input class="form-check-input row-checkbox" type="checkbox" value="${row.id_purchase_order}">
                </div>`;
            }
        },
        {
            data: 'po_number',
            render: function(data, type, row) {
                return `
                    <div>
                        <h6 class="mb-0">
                            <a href="${'{{ route("procurement.po.show", ":id") }}'.replace(':id', row.id_purchase_order)}" class="text-body">
                                ${data}
                            </a>
                        </h6>
                        <small class="text-muted">PO Date: ${new Date(row.po_date).toLocaleDateString('id-ID')}</small>
                    </div>
                `;
            }
        },
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
                                <a href="${'{{ route("procurement.suppliers.show", ":id") }}'.replace(':id', row.supplier_id)}" class="text-body">
                                    ${data}
                                </a>
                            </h6>
                            <small class="text-muted">${row.supplier_code || ''}</small>
                        </div>
                    </div>
                `;
            }
        },
        {
            data: 'request_number',
            render: function(data, type, row) {
                return `
                    <div>
                        <a href="${'{{ route("procurement.requests.show", ":id") }}'.replace(':id', row.procurement_request_id)}" class="fw-medium text-primary">
                            ${data}
                        </a>
                        <br><small class="text-muted">${row.request_title || ''}</small>
                    </div>
                `;
            }
        },
        {
            data: 'items_count',
            render: function(data, type, row) {
                return `
                    <div class="text-center">
                        <span class="badge bg-label-secondary">${data || 0}</span>
                        <small class="text-muted d-block">items</small>
                    </div>
                `;
            }
        },
        {
            data: 'total_amount',
            render: function(data, type, row) {
                const amount = data || 0;
                return `
                    <div class="text-end">
                        <span class="fw-medium">Rp ${new Intl.NumberFormat('id-ID').format(amount)}</span>
                        <small class="text-muted d-block">${row.currency || 'IDR'}</small>
                    </div>
                `;
            }
        },
        {
            data: 'status',
            render: function(data, type, row) {
                const colors = {
                    'draft': 'secondary',
                    'sent': 'info',
                    'acknowledged': 'warning',
                    'completed': 'success',
                    'cancelled': 'danger'
                };
                const labels = {
                    'draft': 'Draft',
                    'sent': 'Sent',
                    'acknowledged': 'Acknowledged', 
                    'completed': 'Completed',
                    'cancelled': 'Cancelled'
                };
                return `<span class="badge bg-${colors[data] || 'secondary'}">${labels[data] || data}</span>`;
            }
        },
        {
            data: 'expected_delivery_date',
            render: function(data, type, row) {
                const deliveryDate = data ? new Date(data) : null;
                const today = new Date();
                
                return `
                    <div class="small">
                        ${deliveryDate ? 
                            `<div class="${deliveryDate < today ? 'text-danger' : 'text-muted'}">
                                Expected: ${deliveryDate.toLocaleDateString('id-ID')}
                            </div>` : 
                            '<div class="text-muted">No date set</div>'
                        }
                        <div class="text-muted">Created: ${new Date(row.created_at).toLocaleDateString('id-ID')}</div>
                    </div>
                `;
            }
        },
        {
            data: null,
            orderable: false,
            render: function(data, type, row) {
                const canEdit = row.status === 'draft';
                const canSend = row.status === 'draft';
                const canAcknowledge = row.status === 'sent';
                
                return `
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="${'{{ route("procurement.po.show", ":id") }}'.replace(':id', row.id_purchase_order)}">
                                <i class="bx bx-show me-1"></i> View Details
                            </a>
                            <a class="dropdown-item" href="#" onclick="previewPO('${row.id_purchase_order}')">
                                <i class="bx bx-search-alt me-1"></i> Quick Preview
                            </a>
                            ${canEdit ? 
                                `<a class="dropdown-item" href="${'{{ route("procurement.po.edit", ":id") }}'.replace(':id', row.id_purchase_order)}">
                                    <i class="bx bx-edit me-1"></i> Edit
                                </a>` : ''
                            }
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="${'{{ route("procurement.po.pdf", ":id") }}'.replace(':id', row.id_purchase_order)}" target="_blank">
                                <i class="bx bx-file-blank me-1"></i> Download PDF
                            </a>
                            ${canSend ? 
                                `<a class="dropdown-item text-info" href="#" onclick="sendPO('${row.id_purchase_order}')">
                                    <i class="bx bx-send me-1"></i> Send to Supplier
                                </a>` : ''
                            }
                            ${canAcknowledge ? 
                                `<a class="dropdown-item text-warning" href="#" onclick="acknowledgePO('${row.id_purchase_order}')">
                                    <i class="bx bx-check me-1"></i> Mark Acknowledged
                                </a>` : ''
                            }
                            <div class="dropdown-divider"></div>
                            ${row.status !== 'cancelled' ? 
                                `<a class="dropdown-item text-danger" href="#" onclick="cancelPO('${row.id_purchase_order}')">
                                    <i class="bx bx-x me-1"></i> Cancel PO
                                </a>` : ''
                            }
                        </div>
                    </div>
                `;
            }
        }
    ]
};

// Functions
function previewPO(poId) {
    // Load PO preview via AJAX
    fetch(`{{ route('procurement.po.show', ':id') }}`.replace(':id', poId))
        .then(response => response.text())
        .then(html => {
            document.getElementById('poPreviewContent').innerHTML = html;
            document.getElementById('printPOBtn').onclick = () => printPO(poId);
            new bootstrap.Modal(document.getElementById('poPreviewModal')).show();
        });
}

function sendPO(poId) {
    if (confirm('Send this purchase order to the supplier?')) {
        fetch(`{{ route('procurement.po.send', ':id') }}`.replace(':id', poId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#purchaseOrdersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function acknowledgePO(poId) {
    if (confirm('Mark this purchase order as acknowledged by supplier?')) {
        fetch(`{{ route('procurement.po.acknowledge', ':id') }}`.replace(':id', poId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#purchaseOrdersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function cancelPO(poId) {
    if (confirm('Are you sure you want to cancel this purchase order? This action cannot be undone.')) {
        fetch(`{{ route('procurement.po.destroy', ':id') }}`.replace(':id', poId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#purchaseOrdersTable').DataTable().ajax.reload();
                // Show success message
            }
        });
    }
}

function printPO(poId) {
    window.open(`{{ route('procurement.po.pdf', ':id') }}`.replace(':id', poId), '_blank');
}

function bulkActions() {
    const selectedRows = document.querySelectorAll('.row-checkbox:checked');
    if (selectedRows.length === 0) {
        alert('Please select at least one purchase order');
        return;
    }
    
    document.getElementById('selectedCount').textContent = selectedRows.length;
    new bootstrap.Modal(document.getElementById('bulkActionsModal')).show();
}

function executeBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const notes = document.getElementById('bulkNotes').value;
    const newStatus = document.getElementById('newStatus').value;
    
    if (!action) {
        alert('Please select an action');
        return;
    }
    
    const selectedRows = document.querySelectorAll('.row-checkbox:checked');
    const poIds = Array.from(selectedRows).map(cb => cb.value);
    
    if (confirm(`Execute ${action} for ${poIds.length} purchase orders?`)) {
        fetch('{{ route("procurement.po.bulk_update_status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                action: action,
                po_ids: poIds,
                new_status: newStatus,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#purchaseOrdersTable').DataTable().ajax.reload();
                bootstrap.Modal.getInstance(document.getElementById('bulkActionsModal')).hide();
                // Show success message
            }
        });
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Filter changes
    ['statusFilter', 'supplierFilter'].forEach(filterId => {
        document.getElementById(filterId).addEventListener('change', function() {
            $('#purchaseOrdersTable').DataTable().ajax.reload();
        });
    });
    
    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
    
    // Bulk action type change
    document.getElementById('bulkAction').addEventListener('change', function() {
        const statusSection = document.getElementById('statusUpdateSection');
        if (this.value === 'update_status') {
            statusSection.style.display = 'block';
        } else {
            statusSection.style.display = 'none';
        }
    });
});
</script>

@endsection