@extends('layouts/layoutMaster')

@section('title', 'CRM Purchase Order')

{{-- Vendor Styles --}}
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

{{-- Vendor Scripts --}}
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')

    {{-- CDN Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Purchase Order</h5>
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
                                data-bs-toggle="modal" data-bs-target="#AddNewPO" aria-controls="AddNewPO">
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New PO</span>
                                </span>
                            </button>

                            <button class="btn btn-secondary create-new btn-info waves-effect waves-light ms-2" type="button"
                                data-bs-toggle="modal" data-bs-target="#OCPrincipal" aria-controls="OCPrincipal">
                                <span><i class="ti ti-file-text me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">OC Principal</span>
                                </span>
                            </button>

                            <button class="btn btn-secondary create-new btn-warning waves-effect waves-light ms-2" type="button"
                                data-bs-toggle="modal" data-bs-target="#UpdateStatus" aria-controls="UpdateStatus">
                                <span><i class="ti ti-edit me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Update Status</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="po-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Brand</th>
                                    <th>Principal PO Number</th>
                                    <th>Packing List</th>
                                    <th>Item</th>
                                    <th>Customer Name / PO Number</th>
                                    <th>Expected Delivery Date</th>
                                    <th>Principal Delivery Date</th>
                                    <th>Status</th>
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

    {{-- Modal: Add New PO --}}
    <div class="modal fade" tabindex="-1" id="AddNewPO" aria-labelledby="AddNewPOLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="AddNewPOLabel" class="modal-title">Add New Purchase Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="principal-po-number">Principal PO Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="principal-po-number" placeholder="Enter Principal PO Number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="brand-filter">Filter by Brand</label>
                        <select class="form-control" id="brand-filter">
                            <option value="">All Brands</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="pr-list-table">
                            <thead class="table-light">
                                <tr>
                                    <th><input type="checkbox" id="select-all-pr" class="form-check-input"></th>
                                    <th>PR Number</th>
                                    <th>Customer PO Number</th>
                                    <th>Customer Name</th>
                                    <th>Brand</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-po-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- / Modal --}}

    {{-- Modal: OC Principal --}}
    <div class="modal fade" tabindex="-1" id="OCPrincipal" aria-labelledby="OCPrincipalLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="OCPrincipalLabel" class="modal-title">OC Principal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="oc-brand-filter">Filter by Brand</label>
                        <select class="form-control" id="oc-brand-filter">
                            <option value="">All Brands</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="oc-pr-list-table">
                            <thead class="table-light">
                                <tr>
                                    <th><input type="checkbox" id="oc-select-all-pr" class="form-check-input"></th>
                                    <th>Principal PO Number</th>
                                    <th>PR Number</th>
                                    <th>Customer Name / PO Number</th>
                                    <th>Brand</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Principal Delivery Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="oc-submit-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- / Modal --}}

    {{-- Modal: Update Status --}}
    <div class="modal fade" tabindex="-1" id="UpdateStatus" aria-labelledby="UpdateStatusLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="UpdateStatusLabel" class="modal-title">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="us-status-select">Select Status to Update <span class="text-danger">*</span></label>
                        <select class="form-control" id="us-status-select" required>
                            <option value="">-- Choose Status --</option>
                            <!-- Purchasing -->
                            <optgroup label="Purchasing">
                                <option value="PR Created">PR Created</option>
                                <option value="DP Received">DP Received</option>
                            </optgroup>

                            <!-- Principal / Supplier -->
                            <optgroup label="Principal / Supplier">
                                <option value="Supplier Production">Supplier Production</option>
                                <option value="Delay Production">Delay Production</option>
                                <option value="Supplier Inform Goods Ready for Pick Up">Supplier Inform Goods Ready for Pick Up</option>
                            </optgroup>

                            <!-- Shipment -->
                            <optgroup label="Shipment">
                                <option value="Pick Up Arrangement">Pick Up Arrangement</option>
                                <option value="In Transit">In Transit</option>
                                <option value="Delay Shipment">Delay Shipment</option>
                                <option value="Shipment Delivery">Shipment Delivery</option>
                            </optgroup>

                            <!-- Customs -->
                            <optgroup label="Customs">
                                <option value="Customs Clearance">Customs Clearance</option>
                                <option value="PIB Draft">PIB Draft</option>
                                <option value="ID Billing Request">ID Billing Request</option>
                                <option value="Payment to Kas Negara">Payment to Kas Negara</option>
                                <option value="Custom Response (Red/Green/Yellow)">Custom Response (Red/Green/Yellow)</option>
                                <option value="Shipment Release">Shipment Release</option>
                            </optgroup>

                            <!-- Internal -->
                            <optgroup label="Internal">
                                <option value="Warehouse Received">Warehouse Received</option>
                                <option value="Lab Check">Lab Check</option>
                                <option value="Dispatch to End Customer/Buyer">Dispatch to End Customer/Buyer</option>
                            </optgroup>

                            <!-- Customer -->
                            <optgroup label="Customer">
                                <option value="Delivered">Delivered</option>
                            </optgroup>

                            <!-- Final Status -->
                            <optgroup label="Final Status">
                                <option value="Complete">Complete</option>
                                <option value="Rejected">Rejected</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="us-brand-filter">Filter by Brand</label>
                        <select class="form-control" id="us-brand-filter">
                            <option value="">All Brands</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="us-pr-list-table">
                            <thead class="table-light">
                                <tr>
                                    <th><input type="checkbox" id="us-select-all-pr" class="form-check-input"></th>
                                    <th>Principal PO Number</th>
                                    <th>PR Number</th>
                                    <th>Customer Name / PO Number</th>
                                    <th>Brand</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Principal Delivery Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="us-submit-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- / Modal --}}

    {{-- DataTable Script --}}
    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#po-table')) {
                $('#po-table').DataTable().destroy();
            }

            $('#po-table').DataTable({
                serverSide: true,
                ajax: '{{ route('crm-purchase-order-data') }}',
                order: [[1, 'desc']], // Order by Principal PO Number column (index 1) descending
                columns: [{
                        data: 'brand',
                        name: 'brand',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'principal_po_number',
                        name: 'principal_po_number',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'packing_list',
                        name: 'packing_list',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'item_list',
                        name: 'item_list'
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
                        data: 'expected_delivery_date',
                        name: 'expected_delivery_date',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'principal_delivery_date',
                        name: 'principal_delivery_date',
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
                displayLength: 15,
                lengthMenu: [7, 10, 15, 25, 50, 75, 100],
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
                        title: 'Purchase Order',
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
                $('#po-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#po-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#po-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#po-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#po-table').DataTable().button('.buttons-copy').trigger();
            });

            // Initialize PR list table in modal
            let prListTable;
            $('#AddNewPO').on('shown.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#pr-list-table')) {
                    $('#pr-list-table').DataTable().destroy();
                }

                prListTable = $('#pr-list-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('crm-purchase-request-data') }}',
                        data: function(d) {
                            d.no_principal_po = true;
                        }
                    },
                    order: [[1, 'desc']],
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            width: '40px',
                            render: function(data, type, row) {
                                return `<input type="checkbox" class="form-check-input pr-checkbox" data-id="${row.id_purchase_request}">`;
                            }
                        },
                        {
                            data: 'pr_number',
                            name: 'pr_number'
                        },
                        {
                            data: 'customer_po_number',
                            name: 'customer_po_number'
                        },
                        {
                            data: 'customer_name',
                            name: 'customer_name'
                        },
                        {
                            data: 'brand_list',
                            name: 'brand_list',
                            render: function(data, type, row) {
                                return data ? data : '-';
                            }
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
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                const map = {
                                    'PR Created': 'bg-label-info',
                                    'Waiting Director Approval': 'bg-label-warning',
                                    'Approved': 'bg-label-success',
                                    'Rejected': 'bg-label-danger',
                                    'DP Received': 'bg-label-primary',
                                    'Supplier Production': 'bg-label-info',
                                    'Delay Production': 'bg-label-danger',
                                    'Supplier Inform Goods Ready for Pick Up': 'bg-label-success',
                                    'Pick Up Arrangement': 'bg-label-warning',
                                    'In Transit': 'bg-label-primary',
                                    'Delay Shipment': 'bg-label-danger',
                                    'Shipment Delivery': 'bg-label-primary',
                                    'Customs Clearance': 'bg-label-warning',
                                    'PIB Draft': 'bg-label-info',
                                    'ID Billing Request': 'bg-label-info',
                                    'Payment to Kas Negara': 'bg-label-warning',
                                    'Custom Response (Red/Green/Yellow)': 'bg-label-warning',
                                    'Shipment Release': 'bg-label-success',
                                    'Warehouse Received': 'bg-label-info',
                                    'Lab Check': 'bg-label-warning',
                                    'Dispatch to End Customer/Buyer': 'bg-label-primary',
                                    'Delivered': 'bg-label-success',
                                    'Complete': 'bg-label-dark',
                                };
                                const cls = map[data] || 'bg-label-secondary';
                                return `<span class="badge ${cls}">${data}</span>`;
                            }
                        }
                    ],
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100]
                });

                // Load brands for filter
                $.ajax({
                    url: '{{ route('crm-purchase-request-brands') }}',
                    method: 'GET',
                    success: function(brands) {
                        const select = $('#brand-filter');
                        brands.forEach(function(brand) {
                            select.append($('<option>', {
                                value: brand,
                                text: brand
                            }));
                        });
                    }
                });

                // Handle brand filter change
                $('#brand-filter').off('change').on('change', function() {
                    const selectedBrand = $(this).val();
                    prListTable.column(4).search(selectedBrand).draw();
                });

                // Handle select all checkbox
                $('#select-all-pr').off('change').on('change', function() {
                    const isChecked = $(this).prop('checked');
                    $('.pr-checkbox').prop('checked', isChecked);
                });

                // Handle individual checkbox
                $(document).on('change', '.pr-checkbox', function() {
                    const totalCheckboxes = $('.pr-checkbox').length;
                    const checkedCheckboxes = $('.pr-checkbox:checked').length;
                    $('#select-all-pr').prop('checked', totalCheckboxes === checkedCheckboxes);
                });

                // Handle submit button
                $('#submit-po-btn').off('click').on('click', function() {
                    const principalPoNumber = $('#principal-po-number').val().trim();
                    const selectedIds = [];

                    $('.pr-checkbox:checked').each(function() {
                        selectedIds.push($(this).data('id'));
                    });

                    if (!principalPoNumber) {
                        alert('Please enter Principal PO Number');
                        return;
                    }

                    if (selectedIds.length === 0) {
                        alert('Please select at least one purchase request');
                        return;
                    }

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route('crm-purchase-order-update-principal-po') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            principal_po_number: principalPoNumber,
                            pr_ids: selectedIds
                        },
                        success: function(response) {
                            alert('Principal PO Number updated successfully!');
                            $('#AddNewPO').modal('hide');
                            $('#po-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    });
                });
            });

            // Clean up table on modal close
            $('#AddNewPO').on('hidden.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#pr-list-table')) {
                    $('#pr-list-table').DataTable().destroy();
                }
                $('#brand-filter').val('').find('option:not(:first)').remove();
                $('#principal-po-number').val('');
                $('#select-all-pr').prop('checked', false);
            });

            // Initialize OC Principal modal
            let ocPrListTable;
            $('#OCPrincipal').on('shown.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#oc-pr-list-table')) {
                    $('#oc-pr-list-table').DataTable().destroy();
                }

                ocPrListTable = $('#oc-pr-list-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('crm-purchase-request-data') }}',
                        data: function(d) {
                            d.has_principal_po = true;
                        }
                    },
                    order: [[1, 'desc']],
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            width: '40px',
                            render: function(data, type, row) {
                                return `<input type="checkbox" class="form-check-input oc-pr-checkbox" data-id="${row.id_purchase_request}">`;
                            }
                        },
                        {
                            data: 'principal_po_number',
                            name: 'principal_po_number',
                            render: function(data, type, row) {
                                return data ? data : '-';
                            }
                        },
                        {
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
                            data: 'brand_list',
                            name: 'brand_list',
                            render: function(data, type, row) {
                                return data ? data : '-';
                            }
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
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                const map = {
                                    'PR Created': 'bg-label-info',
                                    'Waiting Director Approval': 'bg-label-warning',
                                    'Approved': 'bg-label-success',
                                    'Rejected': 'bg-label-danger',
                                    'DP Received': 'bg-label-primary',
                                    'Supplier Production': 'bg-label-info',
                                    'Delay Production': 'bg-label-danger',
                                    'Supplier Inform Goods Ready for Pick Up': 'bg-label-success',
                                    'Pick Up Arrangement': 'bg-label-warning',
                                    'In Transit': 'bg-label-primary',
                                    'Delay Shipment': 'bg-label-danger',
                                    'Shipment Delivery': 'bg-label-primary',
                                    'Customs Clearance': 'bg-label-warning',
                                    'PIB Draft': 'bg-label-info',
                                    'ID Billing Request': 'bg-label-info',
                                    'Payment to Kas Negara': 'bg-label-warning',
                                    'Custom Response (Red/Green/Yellow)': 'bg-label-warning',
                                    'Shipment Release': 'bg-label-success',
                                    'Warehouse Received': 'bg-label-info',
                                    'Lab Check': 'bg-label-warning',
                                    'Dispatch to End Customer/Buyer': 'bg-label-primary',
                                    'Delivered': 'bg-label-success',
                                    'Complete': 'bg-label-dark',
                                };
                                const cls = map[data] || 'bg-label-secondary';
                                return `<span class="badge ${cls}">${data}</span>`;
                            }
                        },
                        {
                            data: 'principal_delivery_date',
                            name: 'principal_delivery_date',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                const existingDate = data && data !== '-' ? data : '';
                                return `<input type="date" class="form-control form-control-sm oc-delivery-date" data-id="${row.id_purchase_request}" value="${existingDate}">`;
                            }
                        }
                    ],
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100]
                });

                // Load brands for filter
                $.ajax({
                    url: '{{ route('crm-purchase-request-brands') }}',
                    method: 'GET',
                    success: function(brands) {
                        const select = $('#oc-brand-filter');
                        brands.forEach(function(brand) {
                            select.append($('<option>', {
                                value: brand,
                                text: brand
                            }));
                        });
                    }
                });

                // Handle brand filter change
                $('#oc-brand-filter').off('change').on('change', function() {
                    const selectedBrand = $(this).val();
                    ocPrListTable.column(4).search(selectedBrand).draw();
                });

                // Handle select all checkbox
                $('#oc-select-all-pr').off('change').on('change', function() {
                    const isChecked = $(this).prop('checked');
                    $('.oc-pr-checkbox').prop('checked', isChecked);
                });

                // Handle individual checkbox
                $(document).on('change', '.oc-pr-checkbox', function() {
                    const totalCheckboxes = $('.oc-pr-checkbox').length;
                    const checkedCheckboxes = $('.oc-pr-checkbox:checked').length;
                    $('#oc-select-all-pr').prop('checked', totalCheckboxes === checkedCheckboxes);
                });

                // Handle submit button
                $('#oc-submit-btn').off('click').on('click', function() {
                    const selectedData = [];

                    $('.oc-pr-checkbox:checked').each(function() {
                        const prId = $(this).data('id');
                        const dateInput = $(this).closest('tr').find('.oc-delivery-date');
                        const deliveryDate = dateInput.val();

                        if (!deliveryDate) {
                            alert('Please select a delivery date for all selected items');
                            selectedData.length = 0;
                            return false;
                        }

                        selectedData.push({
                            id: prId,
                            delivery_date: deliveryDate
                        });
                    });

                    if (selectedData.length === 0) {
                        alert('Please select at least one purchase request');
                        return;
                    }

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route('crm-purchase-order-update-delivery-date') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            items: selectedData
                        },
                        success: function(response) {
                            alert('Principal Delivery Date updated successfully!');
                            $('#OCPrincipal').modal('hide');
                            $('#po-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    });
                });
            });

            // Clean up OC Principal modal on close
            $('#OCPrincipal').on('hidden.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#oc-pr-list-table')) {
                    $('#oc-pr-list-table').DataTable().destroy();
                }
                $('#oc-brand-filter').val('').find('option:not(:first)').remove();
                $('#oc-select-all-pr').prop('checked', false);
            });

            // Initialize Update Status modal
            let usPrListTable;
            $('#UpdateStatus').on('shown.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#us-pr-list-table')) {
                    $('#us-pr-list-table').DataTable().destroy();
                }

                usPrListTable = $('#us-pr-list-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('crm-purchase-request-data') }}',
                        data: function(d) {
                            d.has_principal_po_all = true;
                        }
                    },
                    order: [[1, 'desc']],
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            width: '40px',
                            render: function(data, type, row) {
                                return `<input type="checkbox" class="form-check-input us-pr-checkbox" data-id="${row.id_purchase_request}">`;
                            }
                        },
                        {
                            data: 'principal_po_number',
                            name: 'principal_po_number',
                            render: function(data, type, row) {
                                return data ? data : '-';
                            }
                        },
                        {
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
                            data: 'brand_list',
                            name: 'brand_list',
                            render: function(data, type, row) {
                                return data ? data : '-';
                            }
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
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                const map = {
                                    'PR Created': 'bg-label-info',
                                    'Waiting Director Approval': 'bg-label-warning',
                                    'Approved': 'bg-label-success',
                                    'Rejected': 'bg-label-danger',
                                    'DP Received': 'bg-label-primary',
                                    'Supplier Production': 'bg-label-info',
                                    'Delay Production': 'bg-label-danger',
                                    'Supplier Inform Goods Ready for Pick Up': 'bg-label-success',
                                    'Pick Up Arrangement': 'bg-label-warning',
                                    'In Transit': 'bg-label-primary',
                                    'Delay Shipment': 'bg-label-danger',
                                    'Shipment Delivery': 'bg-label-primary',
                                    'Customs Clearance': 'bg-label-warning',
                                    'PIB Draft': 'bg-label-info',
                                    'ID Billing Request': 'bg-label-info',
                                    'Payment to Kas Negara': 'bg-label-warning',
                                    'Custom Response (Red/Green/Yellow)': 'bg-label-warning',
                                    'Shipment Release': 'bg-label-success',
                                    'Warehouse Received': 'bg-label-info',
                                    'Lab Check': 'bg-label-warning',
                                    'Dispatch to End Customer/Buyer': 'bg-label-primary',
                                    'Delivered': 'bg-label-success',
                                    'Complete': 'bg-label-dark',
                                };
                                const cls = map[data] || 'bg-label-secondary';
                                return `<span class="badge ${cls}">${data}</span>`;
                            }
                        },
                        {
                            data: 'principal_delivery_date',
                            name: 'principal_delivery_date',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                const existingDate = data && data !== '-' ? data : '';
                                return `<input type="date" class="form-control form-control-sm us-delivery-date" data-id="${row.id_purchase_request}" value="${existingDate}">`;
                            }
                        }
                    ],
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100]
                });

                // Load brands for filter
                $.ajax({
                    url: '{{ route('crm-purchase-request-brands') }}',
                    method: 'GET',
                    success: function(brands) {
                        const select = $('#us-brand-filter');
                        brands.forEach(function(brand) {
                            select.append($('<option>', {
                                value: brand,
                                text: brand
                            }));
                        });
                    }
                });

                // Handle brand filter change
                $('#us-brand-filter').off('change').on('change', function() {
                    const selectedBrand = $(this).val();
                    usPrListTable.column(4).search(selectedBrand).draw();
                });

                // Handle select all checkbox
                $('#us-select-all-pr').off('change').on('change', function() {
                    const isChecked = $(this).prop('checked');
                    $('.us-pr-checkbox').prop('checked', isChecked);
                });

                // Handle individual checkbox
                $(document).on('change', '.us-pr-checkbox', function() {
                    const totalCheckboxes = $('.us-pr-checkbox').length;
                    const checkedCheckboxes = $('.us-pr-checkbox:checked').length;
                    $('#us-select-all-pr').prop('checked', totalCheckboxes === checkedCheckboxes);
                });

                // Handle submit button
                $('#us-submit-btn').off('click').on('click', function() {
                    const selectedStatus = $('#us-status-select').val();
                    const selectedData = [];

                    if (!selectedStatus) {
                        alert('Please select a status to update');
                        return;
                    }

                    $('.us-pr-checkbox:checked').each(function() {
                        const prId = $(this).data('id');
                        const dateInput = $(this).closest('tr').find('.us-delivery-date');
                        const deliveryDate = dateInput.val();

                        selectedData.push({
                            id: prId,
                            delivery_date: deliveryDate || null
                        });
                    });

                    if (selectedData.length === 0) {
                        alert('Please select at least one purchase request');
                        return;
                    }

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route('crm-purchase-order-update-status') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: selectedStatus,
                            items: selectedData
                        },
                        success: function(response) {
                            alert('Status updated successfully!');
                            $('#UpdateStatus').modal('hide');
                            $('#po-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    });
                });
            });

            // Clean up Update Status modal on close
            $('#UpdateStatus').on('hidden.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#us-pr-list-table')) {
                    $('#us-pr-list-table').DataTable().destroy();
                }
                $('#us-brand-filter').val('').find('option:not(:first)').remove();
                $('#us-status-select').val('');
                $('#us-select-all-pr').prop('checked', false);
            });
        });
    </script>

@endsection
