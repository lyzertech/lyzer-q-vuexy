@extends('layouts/layoutMaster')

@section('title', 'CRM Inquiry')

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

        {{-- Total Inquiry --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-primary p-3">
                        <i class="ti ti-file-invoice ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_inquiry }}</h2>
                        <p class="mb-0 text-muted">Total Inquiry</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Waiting Supplier Feedback --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-warning p-3">
                        <i class="ti ti-clock ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_waiting }}</h2>
                        <p class="mb-0 text-muted">Waiting Feedback</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Updated by Purchasing --}}
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="badge rounded bg-label-info p-3">
                        <i class="ti ti-edit ti-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $total_updated_by_purchasing }}</h2>
                        <p class="mb-0 text-muted">Updated by Purchasing</p>
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
                        <h5 class="card-title mb-0">Inquiry</h5>
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
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#AddNewInquiry"
                                aria-controls="AddNewInquiry">
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New Inquiry</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="inquiry-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Inquiry Number</th>
                                    <th>Project</th>
                                    <th>PIC Sales</th>
                                    <th>Product Type</th>
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

    {{-- Offcanvas: Add New Inquiry --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="AddNewInquiry" aria-labelledby="AddNewInquiryLabel">
        <div class="offcanvas-header">
            <h5 id="AddNewInquiryLabel" class="offcanvas-title">Add New Inquiry</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form method="post" action="{{ route('crm-inquiry-create') }}" enctype="multipart/form-data"
                class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewInquiryForm">
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
                    <label class="form-label" for="inquiry-project">Project</label>
                    <input required type="text" class="form-control" id="inquiry-project"
                        placeholder="Enter project name" name="title">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="inquiry-pic-sales">PIC Sales</label>
                    <select required class="form-control" id="inquiry-pic-sales" name="pic_sales">
                        <option value="">-- Select PIC Sales --</option>
                        <option value="Bambang Tri">Bambang Tri</option>
                        <option value="David">David</option>
                        <option value="Rizky">Rizky</option>
                        <option value="Eka">Eka</option>
                        <option value="Vicha">Vicha</option>
                        <option value="Setia">Setia</option>
                        <option value="Heri">Heri</option>
                        <option value="Dika">Dika</option>
                    </select>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Type</label>
                    <div id="product-type-container">
                        <div class="product-type-row mb-2">
                            <div class="input-group">
                                <select class="form-control product-type-select" required>
                                    <option value="">-- Select Product Type --</option>
                                    @foreach($product_types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                    <option value="__add_new__">+ Add New Product Type</option>
                                </select>
                                <input type="text" class="form-control product-type-input" name="product_types[]" placeholder="Enter new product type" style="display:none;" required>
                                <button type="button" class="btn btn-outline-danger remove-product" style="display:none;">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-product-type">
                        <i class="ti ti-plus me-1"></i> Add Product
                    </button>
                    <small class="text-muted d-block mt-1">Each product will be saved as a separate inquiry</small>
                </div>


                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="inquiry-notes">Notes</label>
                    <textarea class="form-control" id="inquiry-notes" name="notes" rows="3"
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
            if ($.fn.DataTable.isDataTable('#inquiry-table')) {
                $('#inquiry-table').DataTable().destroy();
            }

            $('#inquiry-table').DataTable({
                serverSide: true,
                ajax: '{{ route('crm-inquiry-data') }}',
                columns: [{
                        data: 'inquiry_number',
                        name: 'inquiry_number'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'pic_sales',
                        name: 'pic_sales'
                    },
                    {
                        data: 'product_type',
                        name: 'product_type'
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
                                'Waiting Supplier Feedback': 'bg-label-warning',
                                'Updated by Purchasing': 'bg-label-info',
                                'Pending': 'bg-label-info',
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
                order: [[0, 'desc']],
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
                        title: 'Inquiry',
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

            $('#exportPrint').click(function() { $('#inquiry-table').DataTable().button('.buttons-print').trigger(); });
            $('#exportCsv').click(function() { $('#inquiry-table').DataTable().button('.buttons-csv').trigger(); });
            $('#exportExcel').click(function() { $('#inquiry-table').DataTable().button('.buttons-excel').trigger(); });
            $('#exportPdf').click(function() { $('#inquiry-table').DataTable().button('.buttons-pdf').trigger(); });
            $('#exportCopy').click(function() { $('#inquiry-table').DataTable().button('.buttons-copy').trigger(); });
        });

        // Product Type Dynamic Add/Remove
        let productCount = 1;
        
        // Handle product type selection change
        $(document).on('change', '.product-type-select', function() {
            const $row = $(this).closest('.product-type-row');
            const $select = $row.find('.product-type-select');
            const $input = $row.find('.product-type-input');
            
            if ($(this).val() === '__add_new__') {
                $select.hide().prop('required', false);
                $input.show().prop('required', true).focus();
            } else {
                $input.val($(this).val());
            }
        });
        
        // Handle text input - if user starts typing, keep it visible
        $(document).on('input', '.product-type-input', function() {
            const $row = $(this).closest('.product-type-row');
            const $select = $row.find('.product-type-select');
            
            if ($(this).is(':visible') && $select.val() !== '__add_new__') {
                $select.val('__add_new__');
            }
        });
        
        $('#add-product-type').click(function() {
            productCount++;
            const newRow = `
                <div class="product-type-row mb-2">
                    <div class="input-group">
                        <select class="form-control product-type-select" required>
                            <option value="">-- Select Product Type --</option>
                            @foreach($product_types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                            <option value="__add_new__">+ Add New Product Type</option>
                        </select>
                        <input type="text" class="form-control product-type-input" name="product_types[]" placeholder="Enter new product type" style="display:none;" required>
                        <button type="button" class="btn btn-outline-danger remove-product">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#product-type-container').append(newRow);
            
            // Show remove button on first item if more than 1
            if (productCount > 1) {
                $('.remove-product').show();
            }
        });

        $(document).on('click', '.remove-product', function() {
            $(this).closest('.product-type-row').remove();
            productCount--;
            
            // Hide remove button if only 1 item left
            if (productCount === 1) {
                $('.remove-product').hide();
            }
        });
        
        // Form submission - ensure selected values are copied to hidden inputs
        $('#addNewInquiryForm').on('submit', function(e) {
            $('.product-type-row').each(function() {
                const $row = $(this);
                const $select = $row.find('.product-type-select');
                const $input = $row.find('.product-type-input');
                
                if ($select.is(':visible') && $select.val() && $select.val() !== '__add_new__') {
                    $input.val($select.val());
                }
            });
        });
    </script>

@endsection
