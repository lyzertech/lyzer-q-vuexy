@extends('layouts/layoutMaster')

@section('title', 'CRM Purchase Request')

{{-- Vendor Styles --}}
@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
        'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    ])
@endsection

{{-- Vendor Scripts --}}
@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    ])
@endsection

@section('content')

    {{-- CDN Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    {{-- Summary Cards --}}
    <div class="row g-6 mb-6">

        {{-- Total PR --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-primary p-3">
                        <i class="ti ti-file-invoice ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_pr }}</h2>
                        <p class="mb-0 text-muted">Total PR</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-warning p-3">
                        <i class="ti ti-clock ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_pending }}</h2>
                        <p class="mb-0 text-muted">Pending</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Approved --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-success p-3">
                        <i class="ti ti-circle-check ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_approved }}</h2>
                        <p class="mb-0 text-muted">Approved</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-danger p-3">
                        <i class="ti ti-circle-x ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_rejected }}</h2>
                        <p class="mb-0 text-muted">Rejected</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{--/ Summary Cards --}}

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

                            <button class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#AddNewPR"
                                aria-controls="AddNewPR">
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
                                    <th>Title</th>
                                    <th>Requested By</th>
                                    <th>Department</th>
                                    <th>Priority</th>
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
    {{--/ DataTable --}}

    {{-- Offcanvas: Add New PR --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="AddNewPR" aria-labelledby="AddNewPRLabel">
        <div class="offcanvas-header">
            <h5 id="AddNewPRLabel" class="offcanvas-title">Add New Purchase Request</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form method="post" action="{{ route('crm-purchase-request-create') }}" enctype="multipart/form-data"
                class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewPRForm">
                @csrf
                @method('POST')

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-number">PR Number</label>
                    <input required type="text" class="form-control" id="pr-number" placeholder="PR-2025-001"
                        name="pr_number">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-title">Title</label>
                    <input required type="text" class="form-control" id="pr-title"
                        placeholder="Purchase of office supplies" name="title">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-requested-by">Requested By</label>
                    <input required type="text" class="form-control" id="pr-requested-by" placeholder="John Doe"
                        name="requested_by">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-department">Department</label>
                    <input required type="text" class="form-control" id="pr-department" placeholder="Procurement"
                        name="department">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-priority">Priority</label>
                    <select class="form-control" id="pr-priority" name="priority" required>
                        <option value="">-- Select Priority --</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-status">Status</label>
                    <select class="form-control" id="pr-status" name="status">
                        <option value="Pending" selected>Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-notes">Notes</label>
                    <textarea class="form-control" id="pr-notes" name="notes" rows="3"
                        placeholder="Additional notes..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </form>
        </div>
    </div>
    {{--/ Offcanvas --}}

    {{-- DataTable Script --}}
    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#pr-table')) {
                $('#pr-table').DataTable().destroy();
            }

            $('#pr-table').DataTable({
                serverSide: true,
                ajax: '{{ route('crm-purchase-request-data') }}',
                columns: [{
                        data: 'pr_number',
                        name: 'pr_number'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'requested_by',
                        name: 'requested_by'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'priority',
                        name: 'priority',
                        render: function(data, type, row) {
                            const map = {
                                'Low': 'bg-label-secondary',
                                'Medium': 'bg-label-info',
                                'High': 'bg-label-warning',
                                'Urgent': 'bg-label-danger',
                            };
                            const cls = map[data] || 'bg-label-secondary';
                            return `<span class="badge ${cls}">${data}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            const map = {
                                'Pending': 'bg-label-warning',
                                'Approved': 'bg-label-success',
                                'Rejected': 'bg-label-danger',
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
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Purchase Request',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: { columns: ':visible' }
                    }
                ]
            });

            $('#exportPrint').click(function() { $('#pr-table').DataTable().button('.buttons-print').trigger(); });
            $('#exportCsv').click(function() { $('#pr-table').DataTable().button('.buttons-csv').trigger(); });
            $('#exportExcel').click(function() { $('#pr-table').DataTable().button('.buttons-excel').trigger(); });
            $('#exportPdf').click(function() { $('#pr-table').DataTable().button('.buttons-pdf').trigger(); });
            $('#exportCopy').click(function() { $('#pr-table').DataTable().button('.buttons-copy').trigger(); });
        });
    </script>

@endsection
