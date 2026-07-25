@extends('layouts/layoutMaster')

@section('title', 'CRM Purchase Request')

{{-- Vendor Styles --}}
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

{{-- Vendor Scripts --}}
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('content')

    {{-- CDN Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-6">

        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{-- Total PR --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-dark p-2 mb-2">
                        <i class="ti ti-file-invoice ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_pr }}</h5>
                    <small class="text-muted">Total PR</small>
                </div>
            </div>
        </div>

        {{-- Purchasing --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-info p-2 mb-2">
                        <i class="ti ti-file-check ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_purchasing }}</h5>
                    <small class="text-muted">Purchasing</small>
                </div>
            </div>
        </div>

        {{-- Production --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-primary p-2 mb-2">
                        <i class="ti ti-building-factory ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_production }}</h5>
                    <small class="text-muted">Production</small>
                </div>
            </div>
        </div>

        {{-- Delays --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-danger p-2 mb-2">
                        <i class="ti ti-alert-triangle ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_delays }}</h5>
                    <small class="text-muted">Delays</small>
                </div>
            </div>
        </div>

        {{-- Shipment --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-primary p-2 mb-2">
                        <i class="ti ti-truck-delivery ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_shipment }}</h5>
                    <small class="text-muted">Shipment</small>
                </div>
            </div>
        </div>

        {{-- Customs --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-warning p-2 mb-2">
                        <i class="ti ti-shield-check ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_customs }}</h5>
                    <small class="text-muted">Customs</small>
                </div>
            </div>
        </div>

        {{-- Internal --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-info p-2 mb-2">
                        <i class="ti ti-building-warehouse ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_internal }}</h5>
                    <small class="text-muted">Internal</small>
                </div>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-danger p-2 mb-2">
                        <i class="ti ti-circle-x ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_rejected }}</h5>
                    <small class="text-muted">Rejected</small>
                </div>
            </div>
        </div>

        {{-- Delivered --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-success p-2 mb-2">
                        <i class="ti ti-check ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_delivered }}</h5>
                    <small class="text-muted">Delivered</small>
                </div>
            </div>
        </div>

        {{-- Complete --}}
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center py-3">
                    <div class="badge rounded bg-label-success p-2 mb-2">
                        <i class="ti ti-circle-check-filled ti-sm"></i>
                    </div>
                    <h5 class="mb-0">{{ $total_complete }}</h5>
                    <small class="text-muted">Complete</small>
                </div>
            </div>
        </div>

    </div>
    {{-- / Summary Cards --}}

    {{-- DataTable --}}
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Purchase Request</h5>
                    </div>

                    <div class="dt-action-buttons text-end pt-6 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-label-primary dropdown-toggle me-4 waves-effect waves-light border-none"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="ti ti-file-export ti-xs me-sm-1"></i>
                                        <span class="d-none d-sm-inline-block">Export</span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportPrint">
                                            <i class="ti ti-printer me-1"></i>Print
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportCsv">
                                            <i class="ti ti-file-text me-1"></i>CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportExcel">
                                            <i class="ti ti-file-spreadsheet me-1"></i>Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportPdf">
                                            <i class="ti ti-file-description me-1"></i>PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportCopy">
                                            <i class="ti ti-copy me-1"></i>Copy
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <button class="btn btn-secondary create-new btn-primary waves-effect waves-light" type="button"
                                data-bs-toggle="modal" data-bs-target="#AddNewPR" aria-controls="AddNewPR"
                                @if(!(auth()->user()->name === 'Julia' && auth()->user()->role_id == 4)) disabled @endif>
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New PR</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="pr-table">
                            <thead class="table-light">
                                <tr>
                                    <th>PR Number</th>
                                    <th>Customer Name / PO Number</th>
                                    <th>Project Name</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Principal PO Number</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- / DataTable --}}

    {{-- Recent Comments Section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Comments</h5>
                </div>
                <div class="card-body">
                    @php
                        function getAllReplies($comment) {
                            $replies = \App\Models\Comment::where('parent_id', $comment->id)
                                ->with('user')
                                ->orderBy('created_at', 'asc')
                                ->get();

                            $allReplies = [];
                            foreach ($replies as $reply) {
                                $allReplies[] = $reply;
                                $childReplies = getAllReplies($reply);
                                $allReplies = array_merge($allReplies, $childReplies);
                            }
                            return $allReplies;
                        }

                        function getLatestReplyDate($comment) {
                            $allReplies = getAllReplies($comment);
                            if (empty($allReplies)) {
                                return $comment->created_at;
                            }
                            $latestDate = $comment->created_at;
                            foreach ($allReplies as $reply) {
                                if ($reply->created_at > $latestDate) {
                                    $latestDate = $reply->created_at;
                                }
                            }
                            return $latestDate;
                        }

                        $recentComments = \App\Models\Comment::where('commentable_type', 'App\Models\crm\crm_purchase_request')
                            ->with(['user', 'commentable'])
                            ->whereNull('parent_id')
                            ->orderBy('created_at', 'desc')
                            ->get();

                        // Sort by latest reply date (including nested replies)
                        $recentComments = $recentComments->sortByDesc(function($comment) {
                            return getLatestReplyDate($comment);
                        })->take(10);
                    @endphp

                    @if($recentComments->isEmpty())
                        <p class="text-muted">No comments yet.</p>
                    @else
                        <div class="row">
                            @foreach($recentComments as $comment)
                                @php
                                    $pr = $comment->commentable;
                                    // Fallback: if commentable is null, try to fetch directly
                                    if (!$pr && $comment->commentable_id) {
                                        $pr = \App\Models\crm\crm_purchase_request::find($comment->commentable_id);
                                    }
                                    $allReplies = getAllReplies($comment);
                                    $latestReplyDate = getLatestReplyDate($comment);
                                @endphp
                                <div class="col-md-2 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar avatar-xs me-2">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        <i class="ti ti-user" style="font-size: 0.75rem;"></i>
                                                    </span>
                                                </div>
                                                <small class="fw-semibold">{{ $comment->user->name ?? 'Unknown' }}</small>
                                            </div>
                                            <p class="text-muted small mb-2" style="font-size: 0.75rem;">{{ \Illuminate\Support\Str::limit($comment->content, 50) }}</p>
                                            <small class="text-muted d-block mb-2" style="font-size: 0.7rem;">{{ $comment->created_at->diffForHumans() }}</small>

                                            @if(count($allReplies) > 0)
                                                <div class="border-top pt-2 mt-2">
                                                    <small class="text-primary d-block mb-1" style="font-size: 0.7rem;">
                                                        <i class="ti ti-corner-down-right"></i> {{ count($allReplies) }} {{ count($allReplies) > 1 ? 'Replies' : 'Reply' }}
                                                    </small>
                                                    <small class="text-success d-block mb-2" style="font-size: 0.65rem;">
                                                        <i class="ti ti-clock"></i> Latest: {{ $latestReplyDate->diffForHumans() }}
                                                    </small>
                                                    @php
                                                        // Show only the 2 most recent replies
                                                        $recentReplies = collect($allReplies)->sortByDesc('created_at')->take(2);
                                                    @endphp
                                                    @foreach($recentReplies as $reply)
                                                        <div class="mb-1 ps-2">
                                                            <small class="fw-semibold d-block" style="font-size: 0.7rem;">{{ $reply->user->name ?? 'Unknown' }}</small>
                                                            <small class="text-muted" style="font-size: 0.65rem;">{{ \Illuminate\Support\Str::limit($reply->content, 40) }}</small>
                                                            <small class="text-muted d-block" style="font-size: 0.6rem;">{{ $reply->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if($pr)
                                                <a href="{{ route('crm-purchase-request-view', $pr->id_purchase_request) }}" class="btn btn-xs btn-label-primary w-100 mt-2">
                                                    <i class="ti ti-arrow-right me-1"></i>View PR
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- / Recent Comments --}}

    {{-- Modal: Add New PR --}}
    <div class="modal fade" tabindex="-1" id="AddNewPR" aria-labelledby="AddNewPRLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="AddNewPRLabel" class="modal-title">Add New Purchase Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('crm-purchase-request-create') }}"
                        enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                        id="addNewPRForm">
                        @csrf
                        @method('POST')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- <div class="mb-3 fv-plugins-icon-container">
                                                        <label class="form-label" for="inquiry-project-select">Select from Inquiry (Optional)</label>
                                                        <select class="form-control" id="inquiry-project-select">
                                                            <option value="">-- Select Inquiry Project --</option>
                                                        </select>
                                                        <small class="text-muted">Auto-fill form from existing inquiry</small>
                                                    </div> -->

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="customer-name">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input required type="text" class="form-control" id="customer-name"
                                placeholder="Enter customer name" name="customer_name"
                                value="{{ old('customer_name') }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="customer-po-number">Customer PO Number <span
                                    class="text-danger">*</span></label>
                            <input required type="text" class="form-control" id="customer-po-number"
                                placeholder="Enter PO number" name="customer_po_number"
                                value="{{ old('customer_po_number') }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="project-name">Project Name <span
                                    class="text-danger">*</span></label>
                            <input required type="text" class="form-control" id="project-name"
                                placeholder="Enter project name" name="project_name" value="{{ old('project_name') }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="term-of-payment">Term of Payment (TOP) <span
                                    class="text-danger">*</span></label>
                            <input required type="text" class="form-control" id="term-of-payment"
                                placeholder="e.g., 30 days, Net 60, etc." name="term_of_payment"
                                value="{{ old('term_of_payment') }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="down-payment">Down Payment (DP) <span
                                    class="text-danger">*</span></label>
                            <select required class="form-control" id="down-payment" name="down_payment">
                                <option value="OFF" selected>OFF</option>
                                <option value="ON">ON</option>
                            </select>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="pr-number">PR Number <span
                                    class="text-danger">*</span></label>
                            <input required type="text" class="form-control" id="pr-number"
                                placeholder="Enter PR number (e.g., PR-XX-XX-XXX)" name="pr_number"
                                value="{{ old('pr_number') }}">
                            <small class="text-muted">This PR number will be used for all items in this request</small>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label">Items <span class="text-danger">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="items-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20%;">Brand <span class="text-danger">*</span></th>
                                            <th style="width: 20%;">Item Name <span class="text-danger">*</span></th>
                                            <th style="width: 12%;">Quantity <span class="text-danger">*</span></th>
                                            <th style="width: 18%;">Selling Price <span class="text-danger">*</span></th>
                                            <th style="width: 20%;">Lead Time (weeks) <span class="text-danger">*</span>
                                            </th>
                                            <th style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-container">
                                        <tr class="item-row">
                                            <td>
                                                <select class="form-control form-control-sm brand-select"
                                                    data-index="0" required>
                                                    <option value="">-- Select Brand --</option>
                                                </select>
                                                <input type="text"
                                                    class="form-control form-control-sm brand-input d-none"
                                                    name="items[0][brand]" placeholder="Enter new brand" required
                                                    disabled>
                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm item-name-select"
                                                    data-index="0" required>
                                                    <option value="">-- Select Item --</option>
                                                </select>
                                                <input type="text"
                                                    class="form-control form-control-sm item-name-input d-none"
                                                    name="items[0][name]" placeholder="Enter new item name" required
                                                    disabled>
                                            </td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="items[0][quantity]" placeholder="Qty" min="1" required>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm selling-price-input"
                                                    name="items[0][selling_price]" placeholder="0" required></td>
                                            <td>
                                                <div class="d-flex gap-1 align-items-center">
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="items[0][min_lead_time]" placeholder="Min" min="0"
                                                        required style="width: 45%;">
                                                    <span>-</span>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="items[0][max_lead_time]" placeholder="Max" min="0"
                                                        required style="width: 45%;">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger remove-item-btn"
                                                    disabled>
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="add-item-btn">
                                <i class="ti ti-plus me-1"></i>Add Item
                            </button>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="pr-status">Status <span class="text-danger">*</span></label>
                            <select required class="form-control" id="pr-status" name="status">
                                <option value="PR Created" selected>PR Created</option>
                            </select>
                        </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="pr-notes">Notes</label>
                            <textarea class="form-control" id="pr-notes" name="notes" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- / Modal --}}

    {{-- DataTable Script --}}
    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#pr-table')) {
                $('#pr-table').DataTable().destroy();
            }

            $('#pr-table').DataTable({
                serverSide: true,
                ajax: '{{ route('crm-purchase-request-data') }}',
                order: [[0, 'desc']], // Order by PR Number column (index 0) descending
                columns: [{
                        data: 'pr_number',
                        name: 'pr_number'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        render: function(data, type, row) {
                            const customerName = row.customer_name || '-';
                            const poNumber = row.customer_po_number || '-';
                            return `<div><strong>${customerName}</strong><br><small class="text-muted">${poNumber}</small></div>`;
                        }
                    },
                    {
                        data: 'project_name',
                        name: 'project_name'
                    },
                    {
                        data: 'item_list',
                        name: 'item_list'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'principal_po_number',
                        name: 'principal_po_number',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            const map = {
                                // Purchasing
                                'PR Created': 'bg-label-info',
                                'Waiting Director Approval': 'bg-label-warning',
                                'Approved': 'bg-label-success',
                                'Rejected': 'bg-label-danger',
                                'DP Received': 'bg-label-primary',

                                // Principal / Supplier
                                'Supplier Production': 'bg-label-info',
                                'Delay Production': 'bg-label-danger',
                                'Supplier Inform Goods Ready for Pick Up': 'bg-label-success',

                                // Shipment
                                'Pick Up Arrangement': 'bg-label-warning',
                                'In Transit': 'bg-label-primary',
                                'Delay Shipment': 'bg-label-danger',
                                'Shipment Delivery': 'bg-label-primary',

                                // Customs
                                'Customs Clearance': 'bg-label-warning',
                                'PIB Draft': 'bg-label-info',
                                'ID Billing Request': 'bg-label-info',
                                'Payment to Kas Negara': 'bg-label-warning',
                                'Custom Response (Red/Green/Yellow)': 'bg-label-warning',
                                'Shipment Release': 'bg-label-success',

                                // Internal
                                'Warehouse Received': 'bg-label-info',
                                'Lab Check': 'bg-label-warning',
                                'Dispatch to End Customer/Buyer': 'bg-label-primary',

                                // Customer
                                'Delivered': 'bg-label-success',

                                // Final Status
                                'Complete': 'bg-label-dark',
                            };
                            const cls = map[data] || 'bg-label-secondary';
                            return `<span class="badge ${cls}">${data}</span>`;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '80px',
                        render: function(data, type, row) {
                            return `<div style="text-align: left;">${data}</div>`;
                        }
                    }
                ],
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Purchase Request',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            $('#exportPrint').click(function() {
                $('#pr-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#pr-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#pr-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#pr-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#pr-table').DataTable().button('.buttons-copy').trigger();
            });

            // Item row counter
            let itemRowIndex = 1;

            // Format number with space separator
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }

            // Parse formatted number back to plain number
            function parseFormattedNumber(str) {
                return str.replace(/\s/g, '');
            }

            // Handle selling price input formatting
            $(document).on('input', '.selling-price-input', function() {
                let value = $(this).val();
                // Remove all spaces
                value = value.replace(/\s/g, '');
                // Remove non-numeric characters except decimal point
                value = value.replace(/[^\d.]/g, '');
                // Ensure only one decimal point
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                // Format with space separator
                if (value) {
                    const [intPart, decPart] = value.split('.');
                    let formatted = formatNumber(intPart);
                    if (decPart !== undefined) {
                        formatted += '.' + decPart;
                    }
                    $(this).val(formatted);
                }
            });

            // Load items from database
            let itemsList = [];
            let brandsList = [];

            function loadItems() {
                $.ajax({
                    url: '{{ route('crm-purchase-request-items') }}',
                    method: 'GET',
                    success: function(items) {
                        itemsList = items;
                        populateItemSelects();
                    }
                });
            }

            function loadBrands() {
                $.ajax({
                    url: '{{ route('crm-purchase-request-brands') }}',
                    method: 'GET',
                    success: function(brands) {
                        brandsList = brands;
                        populateBrandSelects();
                    }
                });
            }

            // Populate all brand selects with options
            function populateBrandSelects() {
                $('.brand-select').each(function() {
                    const currentValue = $(this).val();
                    $(this).find('option:not(:first)').remove();

                    // Add "Add New Brand" option first
                    $(this).append($('<option>', {
                        value: '__add_new__',
                        text: '+ Add New Brand'
                    }));

                    // Then add existing brands
                    brandsList.forEach(function(brand) {
                        $(this).append($('<option>', {
                            value: brand,
                            text: brand
                        }));
                    }.bind(this));

                    if (currentValue) {
                        $(this).val(currentValue);
                    }
                });
            }

            // Populate all item selects with options
            function populateItemSelects() {
                $('.item-name-select').each(function() {
                    const currentValue = $(this).val();
                    $(this).find('option:not(:first)').remove();

                    // Add "Add New Item" option first
                    $(this).append($('<option>', {
                        value: '__add_new__',
                        text: '+ Add New Item'
                    }));

                    // Then add existing items
                    itemsList.forEach(function(item) {
                        $(this).append($('<option>', {
                            value: item,
                            text: item
                        }));
                    }.bind(this));

                    if (currentValue) {
                        $(this).val(currentValue);
                    }
                });
            }

            // Handle brand select change
            $(document).on('change', '.brand-select', function() {
                const $row = $(this).closest('tr');
                const $select = $(this);
                const $input = $row.find('.brand-input');

                if ($select.val() === '__add_new__') {
                    // Show text input for new brand
                    $select.addClass('d-none').prop('required', false).prop('disabled', true);
                    $input.removeClass('d-none').prop('required', true).prop('disabled', false).val('')
                        .focus();
                }
            });

            // Handle brand input blur
            $(document).on('blur', '.brand-input', function() {
                const $input = $(this);
                const $row = $input.closest('tr');
                const $select = $row.find('.brand-select');

                if ($input.val().trim() === '' && !$input.hasClass('d-none')) {
                    // Allow going back to select if input is empty
                    $input.addClass('d-none').prop('required', false).prop('disabled', true);
                    $select.removeClass('d-none').prop('required', true).prop('disabled', false).val('');
                }
            });

            // Handle item select change
            $(document).on('change', '.item-name-select', function() {
                const $row = $(this).closest('tr');
                const $select = $(this);
                const $input = $row.find('.item-name-input');

                if ($select.val() === '__add_new__') {
                    // Show text input for new item
                    $select.addClass('d-none').prop('required', false).prop('disabled', true);
                    $input.removeClass('d-none').prop('required', true).prop('disabled', false).val('')
                        .focus();
                }
            });

            // Handle item input blur - option to go back to select
            $(document).on('blur', '.item-name-input', function() {
                const $input = $(this);
                const $row = $input.closest('tr');
                const $select = $row.find('.item-name-select');

                if ($input.val().trim() === '' && !$input.hasClass('d-none')) {
                    // Allow going back to select if input is empty
                    $input.addClass('d-none').prop('required', false).prop('disabled', true);
                    $select.removeClass('d-none').prop('required', true).prop('disabled', false).val('');
                }
            });

            // Add new item row
            $('#add-item-btn').on('click', function() {
                const itemOptionsHtml = itemsList.map(item => `<option value="${item}">${item}</option>`).join('');
                const brandOptionsHtml = brandsList.map(brand => `<option value="${brand}">${brand}</option>`).join('');
                const newRow = `
                    <tr class="item-row">
                        <td>
                            <select class="form-control form-control-sm brand-select" data-index="${itemRowIndex}" required>
                                <option value="">-- Select Brand --</option>
                                <option value="__add_new__">+ Add New Brand</option>
                                ${brandOptionsHtml}
                            </select>
                            <input type="text" class="form-control form-control-sm brand-input d-none" name="items[${itemRowIndex}][brand]" placeholder="Enter new brand" required disabled>
                        </td>
                        <td>
                            <select class="form-control form-control-sm item-name-select" data-index="${itemRowIndex}" required>
                                <option value="">-- Select Item --</option>
                                <option value="__add_new__">+ Add New Item</option>
                                ${itemOptionsHtml}
                            </select>
                            <input type="text" class="form-control form-control-sm item-name-input d-none" name="items[${itemRowIndex}][name]" placeholder="Enter new item name" required disabled>
                        </td>
                        <td><input type="number" class="form-control form-control-sm" name="items[${itemRowIndex}][quantity]" placeholder="Qty" min="1" required></td>
                        <td><input type="text" class="form-control form-control-sm selling-price-input" name="items[${itemRowIndex}][selling_price]" placeholder="0" required></td>
                        <td>
                            <div class="d-flex gap-1 align-items-center">
                                <input type="number" class="form-control form-control-sm" name="items[${itemRowIndex}][min_lead_time]" placeholder="Min" min="0" required style="width: 45%;">
                                <span>-</span>
                                <input type="number" class="form-control form-control-sm" name="items[${itemRowIndex}][max_lead_time]" placeholder="Max" min="0" required style="width: 45%;">
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-item-btn">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#items-container').append(newRow);
                itemRowIndex++;
                updateRemoveButtons();
            });

            // Remove item row
            $(document).on('click', '.remove-item-btn', function() {
                $(this).closest('tr').remove();
                reindexRows();
                updateRemoveButtons();
            });

            // Update remove button state
            function updateRemoveButtons() {
                const rowCount = $('#items-container tr').length;
                if (rowCount === 1) {
                    $('.remove-item-btn').prop('disabled', true);
                } else {
                    $('.remove-item-btn').prop('disabled', false);
                }
            }

            // Reindex rows after removal
            function reindexRows() {
                $('#items-container tr').each(function(index) {
                    $(this).find('input').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
                itemRowIndex = $('#items-container tr').length;
            }

            // Load items and brands on page load
            loadItems();
            loadBrands();

            // Handle form submission - ensure item names and brands are properly set
            $('#addNewPRForm').on('submit', function(e) {
                $('.item-row').each(function(index) {
                    const $row = $(this);

                    // Handle brand
                    const $brandSelect = $row.find('.brand-select');
                    const $brandInput = $row.find('.brand-input');

                    if ($brandSelect.is(':visible') && $brandSelect.val() && $brandSelect.val() !== '__add_new__') {
                        $brandInput.val($brandSelect.val());
                        $brandInput.prop('disabled', false);
                    } else if ($brandInput.is(':visible')) {
                        $brandInput.prop('disabled', false);
                    }

                    // Handle item name
                    const $itemSelect = $row.find('.item-name-select');
                    const $itemInput = $row.find('.item-name-input');

                    if ($itemSelect.is(':visible') && $itemSelect.val() && $itemSelect.val() !== '__add_new__') {
                        $itemInput.val($itemSelect.val());
                        $itemInput.prop('disabled', false);
                    } else if ($itemInput.is(':visible')) {
                        $itemInput.prop('disabled', false);
                    }
                });
            });

            // Load inquiry projects
            $.ajax({
                url: '{{ route('crm-inquiry-projects') }}',
                method: 'GET',
                success: function(projects) {
                    const select = $('#inquiry-project-select');
                    projects.forEach(function(project) {
                        select.append($('<option>', {
                            value: project,
                            text: project
                        }));
                    });
                }
            });

            // Handle inquiry project selection
            $('#inquiry-project-select').on('change', function() {
                const projectTitle = $(this).val();

                if (!projectTitle) {
                    return;
                }

                $.ajax({
                    url: '/crm/inquiry/project/' + encodeURIComponent(projectTitle),
                    method: 'GET',
                    success: function(inquiries) {
                        if (inquiries.length === 0) return;

                        // Auto-fill project name from first inquiry
                        $('#project-name').val(inquiries[0].title);

                        // Clear existing rows
                        $('#items-container').empty();

                        // Create a row for each inquiry
                        inquiries.forEach(function(inquiry, index) {
                            const optionsHtml = itemsList.map(item =>
                                `<option value="${item}">${item}</option>`).join('');
                            const productType = inquiry.product_type || '';
                            const isExisting = itemsList.includes(productType);

                            // Parse lead time if it exists (e.g., "10-12 weeks" or "2-3 weeks")
                            let minLeadTime = '';
                            let maxLeadTime = '';
                            if (inquiry.lead_time) {
                                const leadTimeMatch = inquiry.lead_time.match(
                                    /(\d+)\s*-\s*(\d+)/);
                                if (leadTimeMatch) {
                                    minLeadTime = leadTimeMatch[1];
                                    maxLeadTime = leadTimeMatch[2];
                                }
                            }

                            const row = `
                                <tr class="item-row">
                                    <td>
                                        <select class="form-control form-control-sm item-name-select ${isExisting ? '' : 'd-none'}" data-index="${index}" ${isExisting ? 'required' : 'disabled'}>
                                            <option value="">-- Select Item --</option>
                                            <option value="__add_new__">+ Add New Item</option>
                                            ${optionsHtml}
                                        </select>
                                        <input type="text" class="form-control form-control-sm item-name-input ${isExisting ? 'd-none' : ''}" name="items[${index}][name]" placeholder="Enter new item name" value="${productType}" ${isExisting ? 'disabled' : 'required'}>
                                    </td>
                                    <td><input type="number" class="form-control form-control-sm" name="items[${index}][quantity]" placeholder="Qty" min="1" required></td>
                                    <td><input type="text" class="form-control form-control-sm selling-price-input" name="items[${index}][selling_price]" placeholder="0" required></td>
                                    <td>
                                        <div class="d-flex gap-1 align-items-center">
                                            <input type="number" class="form-control form-control-sm" name="items[${index}][min_lead_time]" placeholder="Min" min="0" value="${minLeadTime}" required style="width: 45%;">
                                            <span>-</span>
                                            <input type="number" class="form-control form-control-sm" name="items[${index}][max_lead_time]" placeholder="Max" min="0" value="${maxLeadTime}" required style="width: 45%;">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            $('#items-container').append(row);

                            // Set the select value if item exists in list
                            if (isExisting) {
                                $(`#items-container tr:last .item-name-select`).val(
                                    productType);
                            }
                        });

                        itemRowIndex = inquiries.length;
                        updateRemoveButtons();

                        // Combine notes from all inquiries
                        const notes = inquiries
                            .filter(inq => inq.notes)
                            .map(inq => `[${inq.product_type}] ${inq.notes}`)
                            .join('\n');

                        if (notes) {
                            $('#pr-notes').val(notes);
                        }
                    }
                });
            });
        });
    </script>

@endsection
