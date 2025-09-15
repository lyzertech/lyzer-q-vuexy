@extends('layouts/layoutMaster')

@section('title', 'CRM Visit Report')

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

    <!-- Recap Tracker -->
    <div class="row g-6 mb-6">
        <!-- Visit Report Recap -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Sales Visit Report</h5>
                        {{-- <p class="card-subtitle">Last 30 Days</p> --}}
                    </div>
                </div>
                <div class="card-body row">
                    @foreach ($visit_reports as $sales_visit)
                        <div class="col">
                            <ul class="p-0 m-0">
                                <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                                    {{-- <div class="badge rounded bg-label-success p-1_5"> --}}
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2">
                                            {{-- <img src="/assets/img/avatars/9.png" alt="Avatar" class="rounded-circle"> --}}
                                            <img src="{{ asset('assets/img/avatars/' . $sales_visit->sales . '.png') }}"
                                                alt="Avatar" class="rounded-circle">
                                        </div>
                                    </div>
                                    {{-- </div> --}}
                                    <div>
                                        <h6 class="mb-0 text-nowrap">{{ $sales_visit->sales }}</h6>
                                        <small class="text-muted">{{ $sales_visit->total_visits }}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!--/ Visit Report Recap -->

        <!-- Total Prospek -->
        <div class="col-md-2">
            <div class="row my-4">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-4">
                        <div class="avatar avatar-lg">
                            <div class="avatar-initial bg-label-primary rounded">
                                <div>
                                    <img src="{{ asset('assets/svg/icons/laptop.svg') }}" alt="paypal" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Total Visit Report</p>
                            <h4 class="text-primary mb-0">{{ $total_visit_reports }}</h4>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-12">
                    <div class="d-flex align-items-center gap-4">
                        <div class="avatar avatar-lg">
                            <div class="avatar-initial bg-label-success rounded">
                                <div>
                                    <img src="{{ asset('assets/svg/icons/check.svg') }}" alt="Check" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Visit Prospek</p>
                            <h4 class="text-success mb-0">{{ $prospek_yes }}</h4>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-4">
                        <div class="avatar avatar-lg">
                            <div class="avatar-initial bg-label-success rounded">
                                <div>
                                    <img src="{{ asset('assets/svg/icons/laptop-green.svg') }}" alt="laptop-green"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Prospek Results</p>
                            <h4 class="text-success mb-0">
                                {{ $total_visit_reports > 0 ? number_format(($prospek_yes / $total_visit_reports) * 100, 2) : 0 }}%
                            </h4>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-12">
                    <div class="d-flex align-items-center gap-4">
                        <div class="avatar avatar-lg">
                            <div class="avatar-initial bg-label-danger rounded">
                                <div>
                                    <img src="{{ asset('assets/svg/icons/icons8-x.svg') }}" alt="Check"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Visit Not Prospek</p>
                            <h4 class="text-danger mb-0">{{ $prospek_no }}</h4>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        @php
            $metrics = [
                [
                    'title' => 'Completed',
                    'icon' => null,
                    'color' => 'success',
                    'value' => $completed,
                    'format' => 'number',
                    'text_color' => 'white',
                ],
                [
                    'title' => 'Checked',
                    'icon' => null,
                    'color' => 'danger',
                    'value' => $checked,
                    'format' => 'number',
                    'text_color' => 'white',
                ],
                [
                    'title' => 'Reviewed',
                    'icon' => null,
                    'color' => 'warning',
                    'value' => $reviewed,
                    'format' => 'number',
                    'text_color' => 'white',
                ],
                [
                    'title' => 'Submitted',
                    'icon' => null,
                    'color' => 'primary',
                    'value' => $submitted,
                    'format' => 'number',
                    'text_color' => 'white',
                ],
                [
                    'title' => 'Planned',
                    'icon' => null,
                    'color' => 'info',
                    'value' => $planned,
                    'format' => 'number',
                    'text_color' => 'white',
                ],
                [
                    'title' => 'Cancelled',
                    'icon' => null,
                    'color' => 'secondary',
                    'value' => $cancelled,
                    'format' => 'number',
                    'text_color' => 'white',
                ],
            ];
        @endphp

        <div class="col-md-3">
            <div class="card">
                <div class="row row-cols-2 g-3">
                    @foreach ($metrics as $metric)
                        <div class="col">
                            <div class="d-flex align-items-center gap-3 bg-white p-2 rounded">
                                <div class="avatar bg-white border border-{{ $metric['color'] }} text-{{ $metric['color'] }} rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 66px; height: 66px; font-size: 1.5rem;">
                                    {{ $metric['value'] }}{{ $metric['suffix'] ?? '' }}
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-{{ $metric['color'] }}" style="font-size: 1rem;">
                                        {{ $metric['title'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Custom Filter --}}
        <div class="col-md-4">
            <div class="col-xxl-12 col-lg-12">
                <div class="card h-100">
                    {{-- <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Time Filter</h5>
                            <p class="card-subtitle">62 deliveries in progress</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1"
                                type="button" id="salesByCountryTabs" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-md text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountryTabs">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body p-0">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-link-preparing"
                                        aria-controls="navs-justified-link-preparing" aria-selected="false">Custom</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                                        aria-selected="true">Quick Filters</button>
                                </li>
                            </ul>
                            <div class="tab-content border-0  mx-1">
                                <div class="tab-pane fade show active" id="navs-justified-link-preparing" role="tabpanel">
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <form id="filterForm" method="GET" action="{{ route('crm-visit-report') }}"
                                            class="rounded">
                                            <div class="row g-3 align-items-end">
                                                <!-- Year Range -->
                                                <div class="col-md-3">
                                                    <label for="yearFromFilter" class="form-label">Year From</label>
                                                    <select id="yearFromFilter" name="year_from" class="form-select">
                                                        <option value="">All</option>
                                                        @for ($y = now()->year; $y >= 2020; $y--)
                                                            <option value="{{ $y }}"
                                                                {{ request('year_from') == $y ? 'selected' : '' }}>
                                                                {{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="yearToFilter" class="form-label">Year To</label>
                                                    <select id="yearToFilter" name="year_to" class="form-select">
                                                        <option value="">All</option>
                                                        @for ($y = now()->year; $y >= 2020; $y--)
                                                            <option value="{{ $y }}"
                                                                {{ request('year_to') == $y ? 'selected' : '' }}>
                                                                {{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <!-- Month Range -->
                                                <div class="col-md-3">
                                                    <label for="monthFromFilter" class="form-label">Month From</label>
                                                    <select id="monthFromFilter" name="month_from" class="form-select">
                                                        <option value="">All</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                                                {{ request('month_from') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="monthToFilter" class="form-label">Month To</label>
                                                    <select id="monthToFilter" name="month_to" class="form-select">
                                                        <option value="">All</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                                                {{ request('month_to') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <!-- Sales -->
                                                <div class="col-md-6">
                                                    <label for="salesFilter" class="form-label">Sales Name</label>
                                                    <select id="salesFilter" name="sales" class="form-select">
                                                        <option value="">All</option>
                                                        <option value="David"
                                                            {{ request('sales') == 'David' ? 'selected' : '' }}>David
                                                        </option>
                                                        <option value="Vicha"
                                                            {{ request('sales') == 'Vicha' ? 'selected' : '' }}>Vicha
                                                        </option>
                                                        <option value="Heri Go"
                                                            {{ request('sales') == 'Heri Go' ? 'selected' : '' }}>Heri Go
                                                        </option>
                                                        <option value="Dika"
                                                            {{ request('sales') == 'Dika' ? 'selected' : '' }}>Dika
                                                        </option>
                                                    </select>
                                                </div>

                                                <!-- Submit -->
                                                <div class="col-md-6 text-end">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="ti ti-filter me-1"></i> Apply Filter
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-justified-new" role="tabpanel">
                                    <div class="col-12 col-lg-12">
                                        <div class="d-flex justify-content-between flex-column mb-4 mb-md-0">
                                            <ul class="nav nav-align-left nav-pills flex-column">
                                                @php
                                                    use Carbon\Carbon;

                                                    // This Month
                                                    $thisMonth = Carbon::now();
                                                    $thisMonthUrl = route('crm-visit-report', [
                                                        'year_from' => $thisMonth->year,
                                                        'year_to' => $thisMonth->year,
                                                        'month_from' => $thisMonth->format('m'),
                                                        'month_to' => $thisMonth->format('m'),
                                                    ]);

                                                    // This Year
                                                    $thisYear = Carbon::now()->year;
                                                    $thisYearUrl = route('crm-visit-report', [
                                                        'year_from' => $thisYear,
                                                        'year_to' => $thisYear,
                                                    ]);

                                                    // Last 3 Months
                                                    $threeMonthsAgo = Carbon::now()->subMonthsNoOverflow(2); // include current month
                                                    $current = Carbon::now();
                                                    $last3MonthsUrl = route('crm-visit-report', [
                                                        'year_from' => $threeMonthsAgo->year,
                                                        'month_from' => $threeMonthsAgo->format('m'),
                                                        'year_to' => $current->year,
                                                        'month_to' => $current->format('m'),
                                                    ]);
                                                @endphp

                                                <div class="mb-4 mb-md-0">
                                                    <div class="card border-0">
                                                        {{-- <h6 class="text-primary fw-bold mb-3"><i
                                                                class="ti ti-filter me-2"></i>Quick Filters</h6> --}}
                                                        <div class="d-grid gap-2">
                                                            <!-- This Month -->
                                                            <a href="{{ $thisMonthUrl }}"
                                                                class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                                                                <span><i class="ti ti-calendar me-2"></i> This Month</span>
                                                                <i class="ti ti-chevron-right"></i>
                                                            </a>

                                                            <!-- This Year -->
                                                            <a href="{{ $thisYearUrl }}"
                                                                class="btn btn-outline-success d-flex align-items-center justify-content-between">
                                                                <span><i class="ti ti-calendar-time me-2"></i> This
                                                                    Year</span>
                                                                <i class="ti ti-chevron-right"></i>
                                                            </a>

                                                            <!-- Last 3 Months -->
                                                            <a href="{{ $last3MonthsUrl }}"
                                                                class="btn btn-outline-info d-flex align-items-center justify-content-between">
                                                                <span><i class="ti ti-calendar-stats me-2"></i> Last 3
                                                                    Months</span>
                                                                <i class="ti ti-chevron-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </ul>
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


    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Visit Report</h5>
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
                            <button type="button"
                                class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#AddNewVisit">
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New Visit Report</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="visit-report-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Sales</th>
                                    <th>Company</th>
                                    <th>Meeting Point - Tandem</th>
                                    <th>Visit Date & Time</th>
                                    <th>Purpose</th>
                                    <th>Follow Up Date</th>
                                    <th>Status</th>
                                    <th>Prospek</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to add new visit -->
    <div class="modal-onboarding modal fade animate__animated" tabindex="-1" id="AddNewVisit"
        aria-labelledby="AddNewVisitReport">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div id="modalCarouselControls" class="carousel slide pb-6 mb-2" data-bs-interval="false">
                    {{-- <div class="carousel-indicators">
                        <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="0"
                            class="active"></button>
                        <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="2"></button>
                    </div> --}}
                    <div class="carousel-inner">
                        <form method="post" action="{{ route('crm-visit-report-create') }}"
                            enctype="multipart/form-data">
                            @csrf <!-- CSRF protection -->
                            <div class="modal-content text-center">
                                <div class="modal-body p-0">
                                    <!-- Carousel Item 1 -->
                                    <div class="carousel-item active">
                                        <div class="onboarding-media">
                                            <div class="mx-2">
                                                <img src="../../assets/img/illustrations/girl-with-laptop-light.png"
                                                    alt="girl-with-laptop-light" width="222" class="img-fluid"
                                                    data-app-dark-img="illustrations/girl-with-laptop-dark.png"
                                                    data-app-light-img="illustrations/girl-with-laptop-light.png">
                                            </div>
                                        </div>
                                        <div class="onboarding-content">
                                            <h4 class="onboarding-title text-body">Visit Information</h4>
                                            <div class="row g-6">
                                                <!-- Customer Name -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="customer-company">Customer
                                                            Company</label>
                                                        <select id="customer-company" class="form-select"
                                                            name="customer_name">
                                                            <option value="">Select Company</option>
                                                            @foreach ($companies as $cust)
                                                                <option value="{{ $cust }}">
                                                                    {{ $cust }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Sales -->
                                                {{-- <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="sales">Sales</label>
                                                    </div>
                                                </div> --}}
                                                {{-- <input type="hidden" id="sales" name="sales"
                                                    value="{{ auth()->user()->name }}"> --}}
                                                {{-- <div>{{ auth()->user()->sales }}</div> --}}

                                                <!-- Contact Person -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="customer-name">Contact
                                                            Person</label>
                                                        <select id="customer-name" class="form-select"
                                                            name="contact_person">
                                                            <option value="">Select Name</option>
                                                            @foreach ($customer->sortBy('company') as $cust)
                                                                <option value="{{ $cust->name }}"
                                                                    data-company="{{ $cust->company }}">
                                                                    {{ $cust->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <!-- Sales -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label for="add-user-sales" class="form-label">Sales</label>
                                                        <select id="add-user-sales" class="form-select" name="sales">
                                                            <option>Choose Sales</option>
                                                            @foreach ($sales_list as $sales)
                                                                <option value="{{ $sales->name }}">{{ $sales->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Location -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="location">Meeting Point -
                                                            Tandem</label>
                                                        <input required type="text" id="location"
                                                            class="form-control" placeholder="Meruya Utara - Sales"
                                                            name="location">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <!-- Purpose -->
                                                <div class="col-sm-12">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="purpose">Purpose</label>
                                                        <input required type="text" id="purpose"
                                                            class="form-control"
                                                            placeholder="Present Transducer & Annunciator" name="purpose">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <!-- Visit Date -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="visit_date">Visit Date</label>
                                                        <input required class="form-control" type="date"
                                                            id="visit_date" name="visit_date">
                                                    </div>
                                                </div>

                                                <!-- Visit Time -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="visit_time">Visit Time</label>
                                                        <select class="form-control" id="visit_time" name="visit_time">
                                                            <!-- Options will be dynamically generated -->
                                                        </select>
                                                    </div>
                                                </div>

                                                <script>
                                                    // Generate time options dynamically
                                                    function generateTimeOptions(start, end, interval) {
                                                        const select = document.getElementById('visit_time');
                                                        const startTime = start.split(':').map(Number); // Convert "07:00" to [7, 0]
                                                        const endTime = end.split(':').map(Number); // Convert "18:00" to [18, 0]
                                                        let [hour, minute] = startTime;

                                                        while (hour < endTime[0] || (hour === endTime[0] && minute <= endTime[1])) {
                                                            const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                                                            const option = document.createElement('option');
                                                            option.value = time;
                                                            option.textContent = time;
                                                            select.appendChild(option);

                                                            // Increment by the interval
                                                            minute += interval;
                                                            if (minute >= 60) {
                                                                minute = 0;
                                                                hour++;
                                                            }
                                                        }
                                                    }

                                                    // Generate options from 07:00 to 18:00 with 30-minute intervals
                                                    generateTimeOptions('07:00', '18:00', 30);
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Carousel Item 2 -->
                                    <div class="carousel-item">
                                        <div class="onboarding-media">
                                            <div class="mx-2">
                                                <img src="../../assets/img/illustrations/boy-with-laptop-light.png"
                                                    alt="boy-with-laptop-light" width="219" class="img-fluid"
                                                    data-app-dark-img="illustrations/boy-with-laptop-dark.png"
                                                    data-app-light-img="illustrations/boy-with-laptop-light.png">
                                            </div>
                                        </div>
                                        <div class="onboarding-content">
                                            <h4 class="onboarding-title text-body">Example Request Information</h4>
                                            <div class="row g-6">
                                                <!-- Notes -->
                                                <div class="col-sm-12">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="notes">Notes</label>
                                                        <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <!-- Customer Feedback -->
                                                <div class="col-sm-12">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="customer_feedback">Customer
                                                            Feedback</label>
                                                        <textarea class="form-control" id="customer_feedback" rows="3" name="customer_feedback"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Carousel Item 3 -->
                                    <div class="carousel-item">
                                        <div class="onboarding-media">
                                            <div class="mx-2">
                                                <img src="../../assets/img/illustrations/girl-verify-password-light.png"
                                                    alt="girl-verify-password-light" width="239" class="img-fluid"
                                                    data-app-dark-img="illustrations/girl-verify-password-dark.png"
                                                    data-app-light-img="illustrations/girl-verify-password-light.png">
                                            </div>
                                        </div>
                                        <div class="onboarding-content">
                                            <h4 class="onboarding-title text-body">Next Steps</h4>
                                            <div class="row g-6">
                                                <!-- Next Steps -->
                                                <div class="col-sm-12">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="next_steps">Next Steps</label>
                                                        <textarea class="form-control" id="next_steps" rows="4" name="next_steps"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <!-- Follow Up Date -->
                                                <div class="col-sm-6">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="follow_up_date">Follow Up
                                                            Date</label>
                                                        <input class="form-control" type="date" id="follow_up_date"
                                                            name="follow_up_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-label-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <a class="carousel-control-prev" href="#modalCarouselControls" role="button" data-bs-slide="prev">
                        <i class="bx bx-chevrons-left lh-1"></i><span>Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#modalCarouselControls" role="button" data-bs-slide="next">
                        <span>Next</span><i class="bx bx-chevrons-right lh-1"></i>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- visit-report-table -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#visit-report-table')) {
                $('#visit-report-table').DataTable().destroy();
            }

            // Initialize DataTable with buttons for export
            $('#visit-report-table').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route('crm-visit-report-data') }}' + window.location.search,
                },
                columns: [{
                        data: 'sales',
                        name: 'sales'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="d-flex flex-column">
                                        <span class="emp_name text-truncate">${data}</span>
                                        <small class="emp_post text-truncate text-muted">${row.contact_person}</small>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'visit_date',
                        name: 'visit_date',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="d-flex flex-column">
                                        <span class="emp_name text-truncate">${data}</span>
                                        <small class="emp_post text-truncate text-muted">${row.visit_time}</small>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'follow_up_date',
                        name: 'follow_up_date'
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
                                badgeText = 'Planned';
                            } else {
                                switch (data) {
                                    case 'Planned':
                                        badgeClass = 'bg-label-info';
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
                                    case 'Reviewed':
                                        badgeClass = 'bg-label-warning';
                                        badgeText = 'Reviewed';
                                        break;
                                    case 'Checked':
                                        badgeClass = 'bg-label-danger';
                                        badgeText = 'Checked';
                                        break;
                                    case 'Acknowledge':
                                        badgeClass = 'bg-label-danger';
                                        badgeText = 'Acknowledge';
                                        break;
                                    case 'Cancelled':
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Cancelled';
                                        break;
                                    case 'Completed':
                                        badgeClass = 'bg-label-success';
                                        badgeText = 'Completed';
                                        break;
                                    default:
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Unknown';
                                        break;
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
                                    case '2':
                                        badgeClass = 'bg-label-secondary';
                                        badgeText = 'Cancelled';
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
                        searchable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    const followUpDate = new Date(data.follow_up_date); // Parse follow-up date
                    const today = new Date(); // Get today's date

                    // Check if follow_up_date is null or invalid
                    // Check if follow_up_date is null or invalid
                    if (!data.follow_up_date || isNaN(followUpDate.getTime())) {
                        $(row).css('background-color',
                            '#ffffff'); // White background if follow_up_date is NULL or invalid
                        return;
                    }

                    const twoDaysBefore = new Date(followUpDate); // Clone follow-up date
                    twoDaysBefore.setDate(followUpDate.getDate() - 2); // 2 days before

                    // Remove time for date-only comparison
                    followUpDate.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);
                    twoDaysBefore.setHours(0, 0, 0, 0);

                    // Apply row color and show alert
                    if (followUpDate.getTime() === today.getTime() && data.follow_up_date_status ===
                        '0') {
                        $(row).css('background-color', '#f5c6cb'); // Red for today
                        alert(`Today is the follow-up date for ${data.customer_name}!`);
                    } else if (today.getTime() >= twoDaysBefore.getTime() && today.getTime() <
                        followUpDate.getTime()) {
                        $(row).css('background-color', '#fff3cd'); // Yellow for 1-2 days before
                    } else if (followUpDate > today) {
                        $(row).css('background-color', '#ffffff'); // Green for future dates
                    } else if (followUpDate < today && data.follow_up_date_status === '0') {
                        $(row).css('background-color', '#f5c6cb'); // Red for overdue dates
                    } else if (data.follow_up_date_status === '1') {
                        $(row).css('background-color', '#ffffff'); // White background status 1
                    } else {
                        $(row).css('background-color', '#ffffff'); // Red for overdue dates
                    }
                },
                order: [
                    [3, 'dsc']
                ],
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
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
                        title: 'Visit Report Table',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // Fit the table to the page width
                            var table = doc.content[1].table;

                            // Set the table widths to fit the page
                            table.widths = Array(table.body[0].length).fill(
                                '*'); // This ensures that columns take equal width

                            // Optional: Adjust the margins and font size for better fit
                            doc.pageMargins = [10, 10, 10, 10]; // Set small margins
                            doc.styles.tableHeader.fontSize = 10; // Reduce font size in header
                            doc.styles.tableBodyOdd.fontSize = 8; // Reduce font size in body
                            doc.styles.tableBodyEven.fontSize = 8; // Reduce font size in body

                            // Ensure that the table fits well in the page
                            table.layout =
                                'lightHorizontalLines'; // This adds light lines between rows
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                            columns: [0, 1, 2, 3, 4, 5]
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

    {{-- visit-customer-filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('customer-company');
            const nameSelect = document.getElementById('customer-name');

            // Store all options in a variable
            const allOptions = Array.from(nameSelect.querySelectorAll('option[data-company]'));

            companySelect.addEventListener('change', function() {
                const selectedCompany = this.value;

                // Clear the existing options
                nameSelect.innerHTML = '<option value="">Select Name</option>';

                // Add filtered options based on the selected company
                allOptions.forEach(option => {
                    if (option.getAttribute('data-company') === selectedCompany ||
                        selectedCompany === "") {
                        nameSelect.appendChild(option);
                    }
                });
            });
        });
    </script>

@endsection
