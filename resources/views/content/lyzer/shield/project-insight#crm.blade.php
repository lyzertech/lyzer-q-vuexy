@extends('layouts/layoutMaster')

@section('title', 'Project Insight CRM')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
        //datatables
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
        // Buttons and Pickers
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
        // Additional Features
        'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite([
        // datatables
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    ])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite([
        // datatables
        'resources/assets/js/tables-datatables-customer.js',
    ])
@endsection

@section('content')

    {{-- Datatables --}}
    <!-- Optional: jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.js"></script>
    <!-- Optional: Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    {{-- ECharts --}}
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

    {{-- @include('layouts.navbar-shield') --}}

    <!-- DataTable with Buttons -->
    <div class="row g-6">
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-datatable table-responsive pt-0">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header flex-column flex-md-row">
                            <div class="head-label text-center">
                                <h5 class="card-title mb-0">Customer</h5>
                            </div>
                        </div>
                        <div class="table-responsive text-start">
                            <div class="card-datatable table-responsive">
                                <table class="table table-bordered" id="customer-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Company</th>
                                            <th>Name</th>
                                            <th>Sales</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visit Report by AII-SEP-->
        <div class="col-xxl-4 col-md-6">
            <div class="card h-100">
                <div class="card-body p-0">
                    <div class="nav-align-top">
                        <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced my-2" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                                    aria-selected="true">Visit Report AII</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-link-preparing"
                                    aria-controls="navs-justified-link-preparing" aria-selected="false">Visit Report
                                    SEP</button>
                            </li>
                        </ul>
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                <div class="col-xl-12 col-lg-6 col-md-6">
                                    <div class="">
                                        <div class="card-datatable table-responsive pt-0">
                                            <div id="DataTables_Table_0_wrapper"
                                                class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                <div class="table-responsive text-start">
                                                    <div class="card-datatable table-responsive">
                                                        <table class="table table-bordered" id="visit-report-table">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Company</th>
                                                                    <th>Status</th>
                                                                    <th>Prospek</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                                <div class="col-xl-12 col-lg-6 col-md-6">
                                    <div class="">
                                        <div class="card-datatable table-responsive pt-0">
                                            <div id="DataTables_Table_0_wrapper"
                                                class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                <div class="table-responsive text-start">
                                                    <div class="card-datatable table-responsive">
                                                        <table class="table table-bordered" id="visit-report-sep-table">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Company</th>
                                                                    <th>Status</th>
                                                                    <th>Prospek</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sales by Countries tabs -->
    </div>

    <!-- customer-table -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#customer-table')) {
                $('#customer-table').DataTable().destroy();
            }

            // Initialize DataTable with buttons for export
            $('#customer-table').DataTable({
                serverSide: true,
                ajax: '{{ route('insight#crm-customer-data') }}',
                columns: [{
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2">
                                            <img src="/assets/img/avatars/9.png" alt="Avatar" class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="emp_name text-truncate">${data}</span>
                                        <hr hidden>
                                        <small class="emp_post text-truncate text-muted">${row.position}</small>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'sales',
                        name: 'sales'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '100px', // Set fixed width directly in JavaScript
                        render: function(data, type, row) {
                            return `
                                <div style="text-align: left;">
                                    ${data}
                                </div>
                            `;
                        }
                    }
                ],
                displayLength: 4,
                lengthMenu: [4, 10, 25, 50, 75, 100, 500],
                // dom: 'Bfrtip',  // Define placement for buttons
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible' // Print only visible columns
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Customer Table',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // Fit the table to the page width
                            var table = doc.content[1].table;

                            // Set the table widths to fit the page
                            table.widths = Array(table.body[0].length).fill(
                                '*'); // This ensures that columns take equal width

                            // Optional: Adjust the margins and font size for better fit
                            doc.pageMargins = [10, 10, 10, 15]; // Set small margins
                            doc.styles.tableHeader.fontSize = 10; // Reduce font size in header
                            doc.styles.tableBodyOdd.fontSize = 8; // Reduce font size in body
                            doc.styles.tableBodyEven.fontSize = 8; // Reduce font size in body

                            // Ensure that the table fits well in the page
                            table.layout =
                                'lightHorizontalLines'; // This adds light lines between rows
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible' // Copy only visible columns
                        }
                    }
                ]
            });

            // Optional: Bind the dropdown buttons to DataTable buttons (if you want more control)
            $('#exportPrint').click(function() {
                $('#customer-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#customer-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#customer-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#customer-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#customer-table').DataTable().button('.buttons-copy').trigger();
            });
        });
    </script>

    <!-- visit-report-AII-table -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#visit-report-table')) {
                $('#visit-report-table').DataTable().destroy();
            }

            // Initialize DataTable with buttons for export
            $('#visit-report-table').DataTable({
                serverSide: true,
                ajax: '{{ route('insight#crm-visit-report-data') }}',
                columns: [{
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            let badgeText = '';

                            // Get the current time and visit time
                            const currentTime = new Date(); // Current time
                            const visitTime = new Date(row
                                .visit_date); // Visit time from the dataset

                            // Check if current time matches or is after the visit time
                            const isInProgress = currentTime >= visitTime;

                            // Determine badge class and text based on the status and time
                            if (data === 'Planned' && isInProgress) {
                                badgeClass = 'bg-label-info';
                                badgeText = 'In Progress';
                            } else {
                                switch (data) {
                                    case 'Planned':
                                        badgeClass = 'bg-label-warning';
                                        badgeText = 'Planned';
                                        break;
                                    case 'In Progress':
                                        badgeClass = 'bg-label-info';
                                        badgeText = 'In Progress';
                                        break;
                                    case 'Submitted':
                                        badgeClass = 'bg-label-primary';
                                        badgeText = 'Submitted';
                                        break;
                                    case 'Acknowledge':
                                        badgeClass = 'bg-label-danger';
                                        badgeText = 'Acknowledge';
                                        break;
                                    case 'Completed':
                                        badgeClass = 'bg-label-success';
                                        badgeText = 'Completed';
                                        break;
                                    default:
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Unknown';
                                }
                            }

                            // Return the badge HTML
                            return `<span class="badge ${badgeClass}">${badgeText}</span>`;
                        }
                    },
                    {
                        data: 'prospek',
                        name: 'prospek',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            let badgeText = '';

                            // Get the current time and visit time
                            const currentTime = new Date(); // Current time
                            const visitTime = new Date(row
                                .visit_date); // Visit time from the dataset

                            // Check if current time matches or is after the visit time
                            const isInProgress = currentTime >= visitTime;

                            // Determine badge class and text based on the status and time
                            if (data === 'Planned' && isInProgress) {
                                badgeClass = 'bg-label-info';
                                badgeText = 'In Progress';
                            } else {
                                switch (data) {
                                    case '0':
                                        badgeClass = 'bg-label-warning';
                                        badgeText = 'No';
                                        break;
                                    case '1':
                                        badgeClass = 'bg-label-success';
                                        badgeText = 'Yes';
                                        break;
                                    default:
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Unknown';
                                }
                            }

                            // Return the badge HTML
                            return `<span class="badge ${badgeClass}">${badgeText}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '100px', // Set fixed width directly in JavaScript
                        render: function(data, type, row) {
                            return `
                                <div style="text-align: left;">
                                    ${data}
                                </div>
                            `;
                        }
                    }
                ],
                displayLength: 4,
                lengthMenu: [4, 10, 25, 50, 75, 100, 500],
                // dom: 'Bfrtip',  // Define placement for buttons
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible' // Print only visible columns
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Customer Table',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // Fit the table to the page width
                            var table = doc.content[1].table;

                            // Set the table widths to fit the page
                            table.widths = Array(table.body[0].length).fill(
                                '*'); // This ensures that columns take equal width

                            // Optional: Adjust the margins and font size for better fit
                            doc.pageMargins = [10, 10, 10, 15]; // Set small margins
                            doc.styles.tableHeader.fontSize = 10; // Reduce font size in header
                            doc.styles.tableBodyOdd.fontSize = 8; // Reduce font size in body
                            doc.styles.tableBodyEven.fontSize = 8; // Reduce font size in body

                            // Ensure that the table fits well in the page
                            table.layout =
                                'lightHorizontalLines'; // This adds light lines between rows
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible' // Copy only visible columns
                        }
                    }
                ]
            });

            // Optional: Bind the dropdown buttons to DataTable buttons (if you want more control)
            $('#exportPrint').click(function() {
                $('#visit-report-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#visit-report-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#visit-report-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#visit-report-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#visit-report-table').DataTable().button('.buttons-copy').trigger();
            });
        });
    </script>

    <!-- visit-report-SEP-table -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#visit-report-sep-table')) {
                $('#visit-report-sep-table').DataTable().destroy();
            }

            // Initialize DataTable with buttons for export
            $('#visit-report-sep-table').DataTable({
                serverSide: true,
                ajax: '{{ route('insight#crm-visit-report-sep-data') }}',
                columns: [{
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            let badgeText = '';

                            // Get the current time and visit time
                            const currentTime = new Date(); // Current time
                            const visitTime = new Date(row
                                .visit_date); // Visit time from the dataset

                            // Check if current time matches or is after the visit time
                            const isInProgress = currentTime >= visitTime;

                            // Determine badge class and text based on the status and time
                            if (data === 'Planned' && isInProgress) {
                                badgeClass = 'bg-label-info';
                                badgeText = 'In Progress';
                            } else {
                                switch (data) {
                                    case 'Planned':
                                        badgeClass = 'bg-label-warning';
                                        badgeText = 'Planned';
                                        break;
                                    case 'In Progress':
                                        badgeClass = 'bg-label-info';
                                        badgeText = 'In Progress';
                                        break;
                                    case 'Submitted':
                                        badgeClass = 'bg-label-primary';
                                        badgeText = 'Submitted';
                                        break;
                                    case 'Acknowledge':
                                        badgeClass = 'bg-label-danger';
                                        badgeText = 'Acknowledge';
                                        break;
                                    case 'Completed':
                                        badgeClass = 'bg-label-success';
                                        badgeText = 'Completed';
                                        break;
                                    default:
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Unknown';
                                }
                            }

                            // Return the badge HTML
                            return `<span class="badge ${badgeClass}">${badgeText}</span>`;
                        }
                    },
                    {
                        data: 'prospek',
                        name: 'prospek',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            let badgeText = '';

                            // Get the current time and visit time
                            const currentTime = new Date(); // Current time
                            const visitTime = new Date(row
                                .visit_date); // Visit time from the dataset

                            // Check if current time matches or is after the visit time
                            const isInProgress = currentTime >= visitTime;

                            // Determine badge class and text based on the status and time
                            if (data === 'Planned' && isInProgress) {
                                badgeClass = 'bg-label-info';
                                badgeText = 'In Progress';
                            } else {
                                switch (data) {
                                    case '0':
                                        badgeClass = 'bg-label-warning';
                                        badgeText = 'No';
                                        break;
                                    case '1':
                                        badgeClass = 'bg-label-success';
                                        badgeText = 'Yes';
                                        break;
                                    default:
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Unknown';
                                }
                            }

                            // Return the badge HTML
                            return `<span class="badge ${badgeClass}">${badgeText}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '100px', // Set fixed width directly in JavaScript
                        render: function(data, type, row) {
                            return `
                                <div style="text-align: left;">
                                    ${data}
                                </div>
                            `;
                        }
                    }
                ],
                displayLength: 4,
                lengthMenu: [4, 10, 25, 50, 75, 100, 500],
                // dom: 'Bfrtip',  // Define placement for buttons
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible' // Print only visible columns
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Customer Table',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // Fit the table to the page width
                            var table = doc.content[1].table;

                            // Set the table widths to fit the page
                            table.widths = Array(table.body[0].length).fill(
                                '*'); // This ensures that columns take equal width

                            // Optional: Adjust the margins and font size for better fit
                            doc.pageMargins = [10, 10, 10, 15]; // Set small margins
                            doc.styles.tableHeader.fontSize = 10; // Reduce font size in header
                            doc.styles.tableBodyOdd.fontSize = 8; // Reduce font size in body
                            doc.styles.tableBodyEven.fontSize = 8; // Reduce font size in body

                            // Ensure that the table fits well in the page
                            table.layout =
                                'lightHorizontalLines'; // This adds light lines between rows
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible' // Copy only visible columns
                        }
                    }
                ]
            });

            // Optional: Bind the dropdown buttons to DataTable buttons (if you want more control)
            $('#exportPrint').click(function() {
                $('#visit-report-sep-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#visit-report-sep-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#visit-report-sep-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#visit-report-sep-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#visit-report-sep-table').DataTable().button('.buttons-copy').trigger();
            });
        });
    </script>


@endsection
