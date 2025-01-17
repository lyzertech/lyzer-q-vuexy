@extends('layouts/layoutMaster')

@section('title', 'CRM Customer')

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

    <!-- Recap Tracker -->
    <div class="row g-6 mb-6">

        <!-- Customer Tracker -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Customer Tracker</h5>
                        {{-- <p class="card-subtitle">Last 30 Days</p> --}}
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                        <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
                            <h2 class="mb-0">{{ $total_customers }}</h2>
                            <p class="mb-0">Total Company</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                        <ul class="p-0 m-0">
                            <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                                <div class="badge rounded bg-label-primary p-1_5">
                                    <div class="avatar">
                                        <img src="/img/logo/aii.png" alt="">
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">Total Customers</h6>
                                    <small class="text-muted">{{ $total_purchasing_aii }}</small>
                                </div>
                            </li>
                            <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                                <div class="badge rounded bg-label-success p-1_5">
                                    <div class="avatar">
                                        <img src="/img/logo/sep.png" alt="">
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">Total Customers</h6>
                                    <small class="text-muted">{{ $total_purchasing_sep }}</small>
                                </div>
                            </li>
                            {{-- <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                                <div class="badge rounded bg-label-info p-1_5"><i class="ti ti-circle-check ti-md"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">Open Tickets</h6>
                                    <small class="text-muted">0</small>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Customer Tracker -->

        <!-- Customer Distribution -->
        <div class="col-md-2">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Customer Distribution</h5>
                        {{-- <p class="card-subtitle">Last 30 Days</p> --}}
                    </div>
                </div>
                <div class="card-body row">
                    @foreach ($sales_distribution as $distribution)
                        <div class="row">
                            <ul class="p-0 m-0">
                                <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">

                                    {{-- <div class="badge rounded bg-label-success p-1_5"> --}}
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2">
                                            <img src="/assets/img/avatars/9.png" alt="Avatar" class="rounded-circle">
                                        </div>
                                    </div>
                                    {{-- </div> --}}
                                    <div>
                                        <h6 class="mb-0 text-nowrap">{{ $distribution->sales }}</h6>
                                        <small class="text-muted">{{ $distribution->total_customers }}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!--/ Customer Distribution -->

        <!-- Area Distribution -->
        <div class="col-xl-4 col-md-2">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between pb-4">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Customer by Area</h5>
                        {{-- <p class="card-subtitle">Last 6 Months</p> --}}
                    </div>
                </div>
                <div class="card-body row">
                    <div id="main"></div>

                    <script>
                        // Pass PHP data to JavaScript
                        var areaData = @json($area_distribution);

                        // Convert the data into ECharts format
                        var chartData = areaData.map(item => ({
                            value: item.value,
                            name: item.area
                        }));

                        // Initialize the chart
                        var chartDom = document.getElementById('main');
                        var myChart = echarts.init(chartDom);

                        // Configure the chart options
                        var option = {
                            tooltip: {
                                trigger: 'item'
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {
                                        show: true
                                    },
                                    // dataView: {
                                    //     show: true,
                                    //     readOnly: false
                                    // },
                                    // restore: {
                                    //     show: true
                                    // },
                                    // saveAsImage: {
                                    //     show: true
                                    // }
                                }
                            },
                            series: [{
                                // name: 'Nightingale Chart',
                                type: 'pie',
                                radius: [10, 100],
                                center: ['50%', '50%'],
                                roseType: 'area',
                                itemStyle: {
                                    borderRadius: 8
                                },
                                data: chartData
                            }]
                        };

                        myChart.setOption(option);


                        // Set the chart option
                        myChart.setOption(option);
                    </script>
                </div>
            </div>
        </div>
        <!--/ Area Distribution -->


    </div>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Customer</h5>
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
                                            <i class="ti ti-file-text me-1"></i>Csv
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportExcel">
                                            <i class="ti ti-file-spreadsheet me-1"></i>Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportPdf">
                                            <i class="ti ti-file-description me-1"></i>Pdf
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
                                data-bs-toggle="offcanvas" data-bs-target="#AddNewCustomer" aria-controls="AddNewCustomer">
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New Customer</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="customer-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Company</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Area</th>
                                    <th>Sales</th>
                                    {{-- <th>Phone Number</th> --}}
                                    {{-- <th>Mobile Phone</th> --}}
                                    {{-- <th>Status</th> --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to add new record -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="AddNewCustomer" aria-labelledby="AddNewCustomerLabel">
        <div class="offcanvas-header">
            <h5 id="AddNewCustomerLabel" class="offcanvas-title">Add New Customer</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form method="post" action="{{ route('crm-customer-create') }}" enctype="multipart/form-data"
                class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm">
                @csrf <!-- CSRF protection -->
                @method('POST')
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-company">Company</label>
                    <input required type="text" class="form-control" id="add-user-company"
                        placeholder="PT. Amptron Instrumindo" name="company" aria-label="company">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-fullname">Full Name</label>
                    <input required type="text" class="form-control" id="add-user-fullname" placeholder="John Doe"
                        name="name" aria-label="John Doe">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-position">Position</label>
                    <input required type="text" class="form-control" id="add-user-position"
                        placeholder="Supply Chain" name="position" aria-label="LyZer Tech">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-email">Email</label>
                    <input required type="text" id="add-user-email" class="form-control"
                        placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="add-user-sales" class="form-label">Sales</label>
                    <select id="add-user-sales" class="form-select" name="sales">
                        <option>Choose Sales</option>
                        @foreach ($sales_list as $sales)
                            <option value="{{ $sales->name }}">{{ $sales->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-area">Area</label>
                    <input required type="text" class="form-control" id="add-user-area" placeholder="Jakarta"
                        name="area" aria-label="Jakarta">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-address">Address</label>
                    <input required type="text" class="form-control" id="add-user-address" placeholder="Blok N15-16"
                        name="address" aria-label="Blok N15-16">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-phonenumber">Phone Number</label>
                    <input required type="text" class="form-control" id="add-user-phonenumber"
                        placeholder="+62888 8888 8888" name="phonenumber" aria-label="Jakarta">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-mobilephone">Mobile Phone</label>
                    <input required type="text" class="form-control" id="add-user-mobilephone"
                        placeholder="+62888 8888 8888" name="mobilephone" aria-label="Jakarta">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </form>
        </div>
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
                ajax: '{{ route('crm-customer-data') }}',
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'area',
                        name: 'area',
                        render: function(data, type, row) {
                            return `
                              <div class="d-flex justify-content-start align-items-center user-name">
                                  <div class="d-flex flex-column">
                                      <span class="emp_name text-truncate">${data}</span>
                                      <hr hidden>
                                      <small class="emp_post text-truncate text-muted" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                          ${row.address}
                                      </small>
                                  </div>
                              </div>
                          `;
                        }
                    },
                    {
                        data: 'sales',
                        name: 'sales'
                    },
                    // {
                    //     data: 'phonenumber',
                    //     name: 'phonenumber'
                    // },
                    // {
                    //     data: 'mobilephone',
                    //     name: 'mobilephone'
                    // },
                    // {
                    //     data: 'status',
                    //     name: 'status',
                    //     render: function(data, type, row) {
                    //         return (data === 1 || data === "1") ? 'Active' : 'Inactive';
                    //     }
                    // },
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
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100, 500],
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

@endsection
