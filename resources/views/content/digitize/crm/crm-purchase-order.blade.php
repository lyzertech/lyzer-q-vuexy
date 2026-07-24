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
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="po-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Principal PO Number</th>
                                    <th>Packing List</th>
                                    <th>Item</th>
                                    <th>Customer Name</th>
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

    {{-- DataTable Script --}}
    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#po-table')) {
                $('#po-table').DataTable().destroy();
            }

            $('#po-table').DataTable({
                serverSide: true,
                ajax: '{{ route('crm-purchase-order-data') }}',
                order: [[0, 'desc']], // Order by Principal PO Number column (index 0) descending
                columns: [{
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
                        name: 'customer_name'
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
        });
    </script>

@endsection
