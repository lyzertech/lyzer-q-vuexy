@extends('layouts/layoutMaster')

@section('title', 'Procurement Requests')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection


@section('content')

<div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">Total Requests</span>
                        <div class="d-flex align-items-center my-1">
                            <h4 class="mb-0 me-2" id="total-requests">0</h4>
                        </div>
                        <small class="mb-0">All procurement requests</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-file fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">Pending Approval</span>
                        <div class="d-flex align-items-center my-1">
                            <h4 class="mb-0 me-2" id="pending-requests">0</h4>
                        </div>
                        <small class="mb-0">Need manager approval</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-time fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">In Progress</span>
                        <div class="d-flex align-items-center my-1">
                            <h4 class="mb-0 me-2" id="active-requests">0</h4>
                        </div>
                        <small class="mb-0">Active procurement</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-package fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">Completed</span>
                        <div class="d-flex align-items-center my-1">
                            <h4 class="mb-0 me-2" id="completed-requests">0</h4>
                        </div>
                        <small class="mb-0">Successfully delivered</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-circle fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Procurement Requests List -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Procurement Requests</h5>
        <div class="d-flex justify-content-between align-items-center row pt-4 gap-4 gap-md-0">
            <div class="col-md-4 col-12">
                <div class="form-floating form-floating-outline">
                    <select id="status-filter" class="select2 form-select">
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="waiting_approval">Waiting Approval</option>
                        <option value="approved">Approved</option>
                        <option value="purchasing">Purchasing</option>
                        <option value="shipping">Shipping</option>
                        <option value="partial_arrival">Partial Arrival</option>
                        <option value="arrival">Arrival</option>
                        <option value="delivered">Delivered</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <label for="status-filter">Status</label>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-floating form-floating-outline">
                    <select id="priority-filter" class="select2 form-select">
                        <option value="">All Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                    <label for="priority-filter">Priority</label>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <button class="btn btn-primary" onclick="window.location.href='{{ route('procurement.requests.create') }}'">
                    <i class="bx bx-plus me-0 me-sm-1"></i>Add Request
                </button>
            </div>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table id="requests-table" class="datatables-procurement table">
            <thead>
                <tr>
                    <th>Request #</th>
                    <th>Title</th>
                    <th>Sales Person</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Request Details Modal -->
<div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Request Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="requestDetailsContent">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusUpdateForm">
                <div class="modal-body">
                    <input type="hidden" id="updateRequestId" name="request_id">
                    <div class="mb-4">
                        <label for="newStatus" class="form-label">New Status</label>
                        <select id="newStatus" name="status" class="form-select" required>
                            <!-- Options populated dynamically -->
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="statusNote" class="form-label">Note</label>
                        <textarea id="statusNote" name="note" class="form-control" rows="3" placeholder="Add a note for this status change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Global variables for DataTables
window.routeConfig = {
    dataUrl: '{{ route("procurement.requests.data") }}',
    showUrl: '{{ route("procurement.requests.show", ":id") }}',
    editUrl: '{{ route("procurement.requests.edit", ":id") }}'
};
</script>

@endsection