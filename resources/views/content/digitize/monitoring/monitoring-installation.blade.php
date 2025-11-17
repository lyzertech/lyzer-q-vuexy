@extends('layouts/layoutMaster')

@section('title', 'Monitoring Installation')

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

    {{-- Export --}}

    <div class="row">
        <div class="col-xl-12">
            {{-- <h6 class="text-muted">Within cards</h6> --}}
            <div class="card mb-4">
                <div class="card-header">
                    <div class="nav-align-top">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-within-card-Facilities"
                                    aria-controls="navs-pills-within-card-Facilities"
                                    aria-selected="true">Facilities</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-within-card-Devices"
                                    aria-controls="navs-pills-within-card-Devices" aria-selected="false">Devices</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-within-card-DevicesNotListed"
                                    aria-controls="navs-pills-within-card-DevicesNotListed" aria-selected="false">Devices
                                    Not Listed</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-within-card-MeterPoints"
                                    aria-controls="navs-pills-within-card-MeterPoints" aria-selected="false">Meter
                                    Points</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-pills-within-card-Facilities" role="tabpanel">
                            <h4 class="card-title my-0">Facilities in "Org"</h4>
                            <!-- DataTable with Buttons -->
                            <div class="">
                                <div class="card-datatable table-responsive pt-0">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <div class="card-header flex-column flex-md-row py-0">
                                            <div class="head-label text-center">
                                                {{-- <h5 class="card-title mb-0">Customer</h5> --}}
                                            </div>

                                            <div class="dt-action-buttons text-end pt-6 pt-md-0">
                                                <div class="dt-buttons btn-group flex-wrap">
                                                    {{-- <div class="btn-group">
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
                                                    </div> --}}

                                                    <button
                                                        class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#addNewFacility" aria-controls="addNewFacility">
                                                        <span><i class="ti ti-plus me-sm-1"></i>
                                                            <span class="d-none d-sm-inline-block">Add Facility</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive text-start">
                                            <div class="card-datatable table-responsive">
                                                <table class="table table-bordered" id="facility-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Facility</th>
                                                            <th>Type</th>
                                                            <th>Devices</th>
                                                            <th>Offline Devices</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- facility-table -->
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    // Destroy existing DataTable before re-initializing
                                    if ($.fn.DataTable.isDataTable('#facility-table')) {
                                        $('#facility-table').DataTable().destroy();
                                    }

                                    // Initialize DataTable with buttons for export
                                    $('#facility-table').DataTable({
                                        serverSide: true,
                                        ajax: '{{ route('monitoring-installation-facility-data') }}',
                                        columns: [{
                                                data: 'facilities',
                                                name: 'facilities'
                                            },
                                            {
                                                data: 'type',
                                                name: 'type',
                                            },
                                            {
                                                data: 'city',
                                                name: 'city'
                                            },
                                            {
                                                data: 'province',
                                                name: 'province'
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
                                        $('#facility-table').DataTable().button('.buttons-print').trigger();
                                    });
                                    $('#exportCsv').click(function() {
                                        $('#facility-table').DataTable().button('.buttons-csv').trigger();
                                    });
                                    $('#exportExcel').click(function() {
                                        $('#facility-table').DataTable().button('.buttons-excel').trigger();
                                    });
                                    $('#exportPdf').click(function() {
                                        $('#facility-table').DataTable().button('.buttons-pdf').trigger();
                                    });
                                    $('#exportCopy').click(function() {
                                        $('#facility-table').DataTable().button('.buttons-copy').trigger();
                                    });
                                });
                            </script>
                        </div>
                        <div class="tab-pane fade " id="navs-pills-within-card-Devices" role="tabpanel">
                            <h4 class="card-title my-0">Devices in "Org"</h4>
                            <!-- DataTable with Buttons -->
                            <div class="">
                                <div class="card-datatable table-responsive pt-0">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <div
                                            class="card-header flex-column flex-md-row align-items-center justify-content-between py-0">
                                            <div class="head-label text-center">
                                                {{-- <h5 class="card-title mb-0">Customer</h5> --}}
                                            </div>

                                            <div class="dt-action-buttons text-end pt-6 pt-md-0 d-flex gap-2">
                                                <button
                                                    class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#addNewDevice"
                                                    aria-controls="addNewDevice">
                                                    <span><i class="ti ti-plus me-sm-1"></i>
                                                        <span class="d-none d-sm-inline-block">Add Device</span>
                                                    </span>
                                                </button>

                                                <button
                                                    class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#bulkFacility"
                                                    aria-controls="bulkFacility">
                                                    <span><i class="ti ti-settings me-sm-1"></i>
                                                        <span class="d-none d-sm-inline-block">Bulk Facility</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="table-responsive text-start">
                                            <div class="card-datatable table-responsive">
                                                <table class="table table-bordered" id="device-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Device</th>
                                                            <th>Facility</th>
                                                            <th>Model</th>
                                                            <th>Serial Number</th>
                                                            <th>Location</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- device-table -->
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    // Destroy existing DataTable before re-initializing
                                    if ($.fn.DataTable.isDataTable('#device-table')) {
                                        $('#device-table').DataTable().destroy();
                                    }

                                    // Initialize DataTable with buttons for export
                                    $('#device-table').DataTable({
                                        serverSide: true,
                                        ajax: '{{ route('monitoring-installation-device-data') }}',
                                        columns: [{
                                                data: 'device_name',
                                                name: 'device_name'
                                            },
                                            {
                                                data: 'facility',
                                                name: 'facility'
                                            },
                                            {
                                                data: 'device_model',
                                                name: 'device_model'
                                            },
                                            {
                                                data: 'device_serial',
                                                name: 'device_serial'
                                            },
                                            {
                                                data: 'location',
                                                name: 'location'
                                            }
                                        ],
                                        displayLength: 7,
                                        lengthMenu: [7, 10, 25, 50, 75, 100, 500]
                                    });
                                });
                            </script>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-within-card-DevicesNotListed" role="tabpanel">
                            <!-- DataTable with Buttons -->
                            {{-- <div class="">
                                <div class="card-datatable table-responsive pt-0">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <div class="card-header flex-column flex-md-row">
                                            <div class="head-label text-center">
                                            </div>
                                        </div>
                                        <div class="table-responsive text-start">
                                            <div class="card-datatable table-responsive">
                                                <table class="table table-bordered" id="device-table-not-listed">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Device</th>
                                                            <th>Gateway Serial</th>
                                                            <th>Model</th>
                                                            <th>Serial Number</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- device-table-not-listed -->
                            {{-- <script type="text/javascript">
                                $(document).ready(function() {
                                    // Destroy existing DataTable before re-initializing
                                    if ($.fn.DataTable.isDataTable('#device-table-not-listed')) {
                                        $('#device-table-not-listed').DataTable().destroy();
                                    }

                                    // Initialize DataTable with buttons for export
                                    $('#device-table-not-listed').DataTable({
                                        serverSide: true,
                                        ajax: '{{ route('monitoring-installation-device-data-not-listed') }}',
                                        columns: [{
                                                data: 'device_name',
                                                name: 'device_name'
                                            },
                                            {
                                                data: 'gateway_serial',
                                                name: 'gateway_serial'
                                            },
                                            {
                                                data: 'device_model',
                                                name: 'device_model'
                                            },
                                            {
                                                data: 'device_serial',
                                                name: 'device_serial'
                                            },
                                            {
                                                data: 'device_online',
                                                name: 'device_online'
                                            }
                                        ],
                                        displayLength: 7,
                                        lengthMenu: [7, 10, 25, 50, 75, 100, 500]
                                    });
                                });
                            </script> --}}
                        </div>
                        <div class="tab-pane fade" id="navs-pills-within-card-MeterPoints" role="tabpanel">
                            <h4 class="card-title">Special MeterPoints title</h4>
                            <p class="card-text">MeterPoints</p>
                            <a href="javascript:void(0)" class="btn btn-secondary">Go MeterPoints</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Facility Modal -->
    <div class="modal fade" id="addNewFacility" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Add New Facility</h4>
                        {{-- <p class="address-subtitle">Add new address for express delivery</p> --}}
                    </div>
                    <form id="addNewFacilityForm" class="row g-6" method="post"
                        action="{{ route('monitoring-installation-facility-create') }}" enctype="multipart/form-data">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                        {{-- <div class="col-12">
                            <div class="row">
                                <div class="col-md mb-md-0 mb-4">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioHome">
                                            <span class="custom-option-body">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.2"
                                                        d="M16.625 23.625V16.625H11.375V23.625H4.37501V12.6328C4.37437 12.5113 4.39937 12.391 4.44837 12.2798C4.49737 12.1686 4.56928 12.069 4.65939 11.9875L13.4094 4.03592C13.5689 3.88911 13.7778 3.80762 13.9945 3.80762C14.2113 3.80762 14.4202 3.88911 14.5797 4.03592L23.3406 11.9875C23.4287 12.0706 23.4992 12.1706 23.548 12.2814C23.5969 12.3922 23.6231 12.5117 23.625 12.6328V23.625H16.625Z" />
                                                    <path
                                                        d="M23.625 23.625V12.6328C23.623 12.5117 23.5969 12.3922 23.548 12.2814C23.4992 12.1706 23.4287 12.0706 23.3406 11.9875L14.5797 4.03592C14.4202 3.88911 14.2113 3.80762 13.9945 3.80762C13.7777 3.80762 13.5689 3.88911 13.4094 4.03592L4.65937 11.9875C4.56926 12.069 4.49736 12.1686 4.44836 12.2798C4.39936 12.391 4.37436 12.5113 4.375 12.6328V23.625M1.75 23.625H26.25M16.625 23.625V17.5C16.625 17.2679 16.5328 17.0454 16.3687 16.8813C16.2046 16.7172 15.9821 16.625 15.75 16.625H12.25C12.0179 16.625 11.7954 16.7172 11.6313 16.8813C11.4672 17.0454 11.375 17.2679 11.375 17.5V23.625"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="custom-option-title">Home</span>
                                                <small> Delivery time (9am – 9pm) </small>
                                            </span>
                                            <input name="customRadioIcon" class="form-check-input" type="radio"
                                                value="" id="customRadioHome" checked />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md mb-md-0 mb-4">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioOffice">
                                            <span class="custom-option-body">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.2"
                                                        d="M15.75 23.625V4.375C15.75 4.14294 15.6578 3.92038 15.4937 3.75628C15.3296 3.59219 15.1071 3.5 14.875 3.5H4.375C4.14294 3.5 3.92038 3.59219 3.75628 3.75628C3.59219 3.92038 3.5 4.14294 3.5 4.375V23.625" />
                                                    <path
                                                        d="M1.75 23.625H26.25M15.75 23.625V4.375C15.75 4.14294 15.6578 3.92038 15.4937 3.75628C15.3296 3.59219 15.1071 3.5 14.875 3.5H4.375C4.14294 3.5 3.92038 3.59219 3.75628 3.75628C3.59219 3.92038 3.5 4.14294 3.5 4.375V23.625M24.5 23.625V11.375C24.5 11.1429 24.4078 10.9204 24.2437 10.7563C24.0796 10.5922 23.8571 10.5 23.625 10.5H15.75M7 7.875H10.5M8.75 14.875H12.25M7 19.25H10.5M19.25 19.25H21M19.25 14.875H21"
                                                        stroke-opacity="0.9" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="custom-option-title"> Office </span>
                                                <small> Delivery time (9am – 5pm) </small>
                                            </span>
                                            <input name="customRadioIcon" class="form-check-input" type="radio"
                                                value="" id="customRadioOffice" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalAddressFacilityName">Facility Name</label>
                            <input type="text" required id="modalAddressFacilityName" name="facilities"
                                class="form-control" placeholder="John" />
                        </div>
                        {{-- <div class="col-12 col-md-6">
                            <label class="form-label" for="modalAddressLastName">Last Name</label>
                            <input type="text" required id="modalAddressLastName" name="modalAddressLastName"
                                class="form-control" placeholder="Doe" />
                        </div> --}}
                        <div class="col-12">
                            <label class="form-label" for="modalAddressType">Type</label>
                            <select required id="modalAddressType" name="type" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="CAMPUS">Campus</option>
                                <option value="COMMUNITY CENTER">Community Center</option>
                                <option value="DATA CENTER">Data Center</option>
                                <option value="ELEMENTARY SCHOOL">Elementary School</option>
                                <option value="FIRE STATION">Fire Station</option>
                                <option value="HEALTH CARE">Health Care</option>
                                <option value="HIGH SCHOOL">High School</option>
                                <option value="INDUSTRIAL">Industrial</option>
                                <option value="LABORATORY">Laboratory</option>
                                <option value="LIBRARY">Library</option>
                                <option value="MALL">Mall</option>
                                <option value="MANUFACTURING">Manufacturing</option>
                                <option value="MEDICAL OFFICE">Medical Office</option>
                                <option value="MIDDLE SCHOOL">Middle School</option>
                                <option value="MULTI UNIT RESIDENCE">Multi Unit Residence</option>
                                <option value="MUNICIPAL BUILDING">Municipal Building</option>
                                <option value="MUSEUM">Museum</option>
                                <option value="OFFICE">Office</option>
                                <option value="OTHER">Other</option>
                                <option value="PARK">Park</option>
                                <option value="POLICE">Police</option>
                                <option value="RECREATION CENTER">Recreation Center</option>
                                <option value="RENEWABLE">Renewable</option>
                                <option value="RESIDENCE">Residence</option>
                                <option value="RESTAURANT">Restaurant</option>
                                <option value="RETAIL">Retail</option>
                                <option value="SCIENCE FACILITY">Science Facility</option>
                                <option value="SHELTER">Shelter</option>
                                <option value="SPORTS FACILITY">Sports Facility</option>
                                <option value="STUDENT CENTER">Student Center</option>
                                <option value="SUPERMARKET">Supermarket</option>
                                <option value="THEATER">Theater</option>
                                <option value="TRANSPORTATION">Transportation</option>
                                <option value="UNIVERSITY">University</option>
                                <option value="WAREHOUSE">Warehouse</option>
                            </select>
                        </div>
                        <div class="col-12 ">
                            <label class="form-label" for="modalAddressDescription">Description</label>
                            <input type="text" required id="modalAddressDescription" name="description"
                                class="form-control" placeholder="12, Business Park" />
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="modalAddressstreet_address">Street Address</label>
                            <input type="text" required id="modalAddressstreet_address" name="street_address"
                                class="form-control" placeholder="Mall Road" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalAddressCity">City</label>
                            <input type="text" required id="modalAddressCity" name="city" class="form-control"
                                placeholder="Nr. Hard Rock Cafe" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalAddressProvince">Province</label>
                            <input type="text" required id="modalAddressProvince" name="province"
                                class="form-control" placeholder="Los Angeles" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalAddressCountry">Country</label>
                            <input type="text" required id="modalAddressCountry" name="country" class="form-control"
                                placeholder="California" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalAddressZipCode">Zip Code</label>
                            <input type="text" required id="modalAddressZipCode" name="postal_code"
                                class="form-control" placeholder="99950" />
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="modalAddressTimezone">Timezone</label>
                            <input type="text" required id="modalAddressTimezone" name="timezone"
                                class="form-control" placeholder="Mall Road" />
                        </div>
                        {{-- <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" required id="billingAddress" />
                                <label for="billingAddress" class="form-label">Use as a billing address?</label>
                            </div>
                        </div> --}}
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add New Facility Modal -->

    <!-- Bulk Facility Modal -->
    <div class="modal fade" id="bulkFacility" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Bulk Facility Device</h4>
                        <p class="address-subtitle">Bulk devices for specific Facility</p>
                    </div>
                    <form id="bulkFacilityForm" class="row g-6" method="post"
                        action="{{ route('monitoring-installation-device-bulkFacility') }}" enctype="multipart/form-data">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalFacility">Facility</label>
                            <select required id="modalFacility" name="facility" class="select2 form-select"
                                data-allow-clear="true">
                                @foreach ($facility_list as $list)
                                    <option value="{{ $list }}">{{ $list }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalDeviceName">Device Name</label>
                            <small class="text-light fw-medium d-block"></small>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="selectAllDevices" />
                                <label class="form-check-label fw-bold" for="selectAllDevices">Select All</label>
                            </div>
                            <small class="text-light fw-medium d-block"></small>

                            @foreach ($device_list as $devName)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input device-checkbox" type="checkbox"
                                        id="{{ $devName->device_name }}" name="devices[]"
                                        value="{{ $devName->device_name }}" />
                                    <label class="form-check-label"
                                        for="{{ $devName->device_name }}">{{ $devName->device_name }}</label>
                                </div>
                            @endforeach

                            <script>
                                document.getElementById('selectAllDevices').addEventListener('change', function() {
                                    const checked = this.checked;
                                    document.querySelectorAll('.device-checkbox').forEach(cb => cb.checked = checked);
                                });
                            </script>
                        </div>
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalLocation">Location</label>
                            <input type="text" required id="modalLocation" name="location" class="form-control"
                                placeholder="Building 04" />
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Bulk Facility Modal -->

    <!-- Add New Device Modal -->
    <div class="modal fade" id="addNewDevice" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Add New Device</h4>
                        <p class="address-subtitle">Add new device for reading data</p>
                    </div>
                    <form id="addNewDeviceForm" class="row g-6" method="post"
                        action="{{ route('monitoring-installation-device-create') }}" enctype="multipart/form-data">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalFacility">Facility</label>
                            <select required id="modalFacility" name="facility" class="select2 form-select"
                                data-allow-clear="true">
                                @foreach ($facility_list as $list)
                                    <option value="{{ $list }}">{{ $list }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalDeviceModel">Model</label>
                            <select required id="modalDeviceModel" name="device_model" class="select2 form-select"
                                data-allow-clear="true">
                                <option value="Acuvim II-V3">Acuvim II</option>
                                <option value="Acuvim L-V4">Acuvim L-V4</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalDeviceName">Device Name</label>
                            <input type="text" required id="modalDeviceName" name="device_name" class="form-control"
                                placeholder="Power Meter Line 01" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalDeviceSerial">Serial Number</label>
                            <input type="text" required id="modalDeviceSerial" name="device_serial"
                                class="form-control" placeholder="AH2512345" />
                        </div>
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalLocation">Location</label>
                            <input type="text" required id="modalLocation" name="location" class="form-control"
                                placeholder="Building 04" />
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add New Device Modal -->

@endsection
