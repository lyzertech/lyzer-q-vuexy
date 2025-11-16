@extends('layouts/layoutMaster')

@section('title', 'Student List')

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

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/masonry/masonry.js',
        // datatables
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
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
    <div class="row g-6">

        <!-- Class-->
        <div class="col-xl-8 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0">
                        <h5 class="mb-1">Class Selection</h5>
                        <p class="card-subtitle">Choose Class to Show Student List</p>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs widget-nav-tabs pb-8 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
                        <!-- Loop for Class 1–6 -->

                        <li class="nav-item">
                            <a href="#" class="nav-link class-tab" data-class="1">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-school ti-md"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">1 (One)</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link class-tab" data-class="2">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-school ti-md"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">2 (One)</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link class-tab" data-class="3">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-school ti-md"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">3 (One)</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link class-tab" data-class="4">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-school ti-md"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">4 (One)</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link class-tab" data-class="5">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-school ti-md"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">5 (One)</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link class-tab" data-class="6">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-school ti-md"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">6 (One)</h6>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <!-- Sales last 6 months -->
        <div class="col-xl-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between pb-4">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Sales</h5>
                        <p class="card-subtitle">Last 6 Months</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button"
                            id="salesLastMonthMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-md text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesLastMonthMenu">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="salesLastMonth"></div>
                </div>
            </div>
        </div>

        <!-- Sales By Country -->
        <div class="col-xxl-12 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Sales by Countries</h5>
                        <p class="card-subtitle">Monthly Sales Overview</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button"
                            id="salesByCountry" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-md text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                            <a class="dropdown-item" href="javascript:void(0);">Download</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-pane fade show active" id="class1" role="tabpanel">

                        <div class="table-responsive text-start">
                            <div class="card-datatable table-responsive">
                                <table id="studentTable" class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>NIS</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Birthdate</th>
                                            <th>Parent</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <script>
                            let currentClass = 1; // default tab

                            // Init DataTable
                            let table = $('#studentTable').DataTable({
                                processing: true,
                                serverSide: false, // change to true if you want server pagination
                                ajax: {
                                    url: `/api/students/${currentClass}`,
                                    dataSrc: function(json) {
                                        console.log(json); // <---- check this
                                        return json;
                                    }
                                },
                                columns: [{ // Auto numbering
                                        data: null,
                                        render: (data, type, row, meta) => meta.row + 1
                                    },
                                    {
                                        data: 'nis'
                                    },
                                    {
                                        data: 'name'
                                    },
                                    {
                                        data: 'gender'
                                    },
                                    {
                                        data: 'birthdate'
                                    },
                                    {
                                        data: 'parent_name'
                                    },
                                    {
                                        data: 'contact_number'
                                    },
                                    {
                                        data: 'status',
                                        render: function(data) {
                                            const color = data === 'Active' ? 'success' : 'secondary';
                                            return `<span class="badge bg-${color}">${data}</span>`;
                                        }
                                    }
                                ]
                            });

                            // When user clicks the class tab
                            $('.class-tab').on('click', function() {
                                currentClass = $(this).data('class'); // get class from tab

                                table.ajax.url(`/api/students/${currentClass}`).load();
                            });
                        </script>


                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
