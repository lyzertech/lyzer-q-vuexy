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

        {{-- PR Created --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-info p-3">
                        <i class="ti ti-file-check ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_pr_created }}</h2>
                        <p class="mb-0 text-muted">PR Created</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Waiting Director Approval --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-warning p-3">
                        <i class="ti ti-clock ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_waiting_approval }}</h2>
                        <p class="mb-0 text-muted">Waiting Approval</p>
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
                                type="button" data-bs-toggle="modal" data-bs-target="#AddNewPR"
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
                                    <th>Customer Name</th>
                                    <th>Project Name</th>
                                    <th>Item</th>
                                    <th>PO Number</th>
                                    <th>Quantity</th>
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

    {{-- Modal: Add New PR --}}
    <div class="modal fade" tabindex="-1" id="AddNewPR" aria-labelledby="AddNewPRLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="AddNewPRLabel" class="modal-title">Add New Purchase Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
            <form method="post" action="{{ route('crm-purchase-request-create') }}" enctype="multipart/form-data"
                class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewPRForm">
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

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="inquiry-project-select">Select from Inquiry (Optional)</label>
                    <select class="form-control" id="inquiry-project-select">
                        <option value="">-- Select Inquiry Project --</option>
                    </select>
                    <small class="text-muted">Auto-fill form from existing inquiry</small>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="customer-name">Customer Name <span class="text-danger">*</span></label>
                    <input required type="text" class="form-control" id="customer-name" 
                        placeholder="Enter customer name" name="customer_name" value="{{ old('customer_name') }}">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="customer-po-number">Customer PO Number <span class="text-danger">*</span></label>
                    <input required type="text" class="form-control" id="customer-po-number" 
                        placeholder="Enter PO number" name="customer_po_number" value="{{ old('customer_po_number') }}">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="project-name">Project Name <span class="text-danger">*</span></label>
                    <input required type="text" class="form-control" id="project-name" 
                        placeholder="Enter project name" name="project_name" value="{{ old('project_name') }}">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label">Items <span class="text-danger">*</span></label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="items-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 25%;">Item Name <span class="text-danger">*</span></th>
                                    <th style="width: 12%;">Quantity <span class="text-danger">*</span></th>
                                    <th style="width: 18%;">Selling Price <span class="text-danger">*</span></th>
                                    <th style="width: 18%;">Expected Delivery <span class="text-danger">*</span></th>
                                    <th style="width: 17%;">Lead Time <span class="text-danger">*</span></th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-container">
                                <tr class="item-row">
                                    <td><input type="text" class="form-control form-control-sm" name="items[0][name]" placeholder="Item name" required></td>
                                    <td><input type="number" class="form-control form-control-sm" name="items[0][quantity]" placeholder="Qty" min="1" required></td>
                                    <td><input type="text" class="form-control form-control-sm selling-price-input" name="items[0][selling_price]" placeholder="0" required></td>
                                    <td><input type="date" class="form-control form-control-sm" name="items[0][expected_delivery_date]" required></td>
                                    <td><input type="text" class="form-control form-control-sm" name="items[0][lead_time]" placeholder="e.g., 2-3 weeks" required></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" disabled>
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
                    <label class="form-label" for="attachment-customer-po">Attachment Customer PO</label>
                    <input type="file" class="form-control" id="attachment-customer-po" 
                        name="attachment_customer_po" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    <small class="text-muted">Max size: 10MB. Formats: PDF, JPG, PNG, DOC, DOCX</small>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="pr-status">Status <span class="text-danger">*</span></label>
                    <select required class="form-control" id="pr-status" name="status">
                        <option value="PR Created" selected>PR Created</option>
                        <option value="Waiting Director Approval">Waiting Director Approval</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="pr-notes">Notes</label>
                        <textarea class="form-control" id="pr-notes" name="notes" rows="3"
                            placeholder="Additional notes...">{{ old('notes') }}</textarea>
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
{{--/ Modal --}}

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
                        data: 'customer_name',
                        name: 'customer_name'
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
                        data: 'customer_po_number',
                        name: 'customer_po_number'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            const map = {
                                'PR Created': 'bg-label-info',
                                'Waiting Director Approval': 'bg-label-warning',
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

            // Add new item row
            $('#add-item-btn').on('click', function() {
                const newRow = `
                    <tr class="item-row">
                        <td><input type="text" class="form-control form-control-sm" name="items[${itemRowIndex}][name]" placeholder="Item name" required></td>
                        <td><input type="number" class="form-control form-control-sm" name="items[${itemRowIndex}][quantity]" placeholder="Qty" min="1" required></td>
                        <td><input type="text" class="form-control form-control-sm selling-price-input" name="items[${itemRowIndex}][selling_price]" placeholder="0" required></td>
                        <td><input type="date" class="form-control form-control-sm" name="items[${itemRowIndex}][expected_delivery_date]" required></td>
                        <td><input type="text" class="form-control form-control-sm" name="items[${itemRowIndex}][lead_time]" placeholder="e.g., 2-3 weeks" required></td>
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
                            const row = `
                                <tr class="item-row">
                                    <td><input type="text" class="form-control form-control-sm" name="items[${index}][name]" placeholder="Item name" value="${inquiry.product_type || ''}" required></td>
                                    <td><input type="number" class="form-control form-control-sm" name="items[${index}][quantity]" placeholder="Qty" min="1" required></td>
                                    <td><input type="text" class="form-control form-control-sm selling-price-input" name="items[${index}][selling_price]" placeholder="0" required></td>
                                    <td><input type="date" class="form-control form-control-sm" name="items[${index}][expected_delivery_date]" required></td>
                                    <td><input type="text" class="form-control form-control-sm" name="items[${index}][lead_time]" placeholder="e.g., 2-3 weeks" value="${inquiry.lead_time || ''}" required></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            $('#items-container').append(row);
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
