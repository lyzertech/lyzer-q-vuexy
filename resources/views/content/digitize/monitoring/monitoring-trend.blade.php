@php
    $configData = Helper::appClasses();
    $isFlex = true;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Content navbar + Sidebar - Layouts')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite('resources/assets/vendor/libs/jstree/jstree.scss')

    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
    @vite('resources/assets/vendor/libs/jstree/jstree.js')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/app-ecommerce-dashboard.js'])
    @vite('resources/assets/js/extended-ui-treeview.js')
    @vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

<!-- Include jsTree CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css">
<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Include jsTree JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

@section('content')
    <div class="border-end container-p-x container-p-y" style="width: 400px; flex-shrink: 0;">
        <div class="layout-example-sidebar layout-example-content-inner">
            <!-- Checkbox -->
            <div class="col-md-12 col-12">
                <div class="card mb-md-0 mb-6">
                    <h5 class="card-header">Analysis</h5>
                    <div class="card-body px-4">
                        <div id="tree"></div>

                    </div>
                </div>
            </div>
            <!-- /Checkbox -->
        </div>
    </div>

    <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
        <div class="row g-2">
            <div class="col-xl-12">
                <!-- Trend -->
                <div class="tab-pane fade show active" id="realtime" role="tabpanel" aria-labelledby="realtime-tab">
                    <h5 class="fw-bold mb-2">
                        <i class="ti ti-activity me-1"></i> Trend Monitoring
                    </h5>
                    <p class="text-muted mb-0">
                        Live data feed and instant parameter updates.
                    </p>
                    <div class="tab-pane fade show active" id="realtime" role="tabpanel" aria-labelledby="energy-tab">
                        <div class="card shadow-sm border-0">
                        </div>
                    </div>
                </div>
            </div>
            <!-- View sales -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <!-- === Time Frame Selection === -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3 my-3">
                                <label class="form-label fw-semibold mb-0">Select a Time Frame:</label>
                            </div>
                            <div class="col-md-9 d-flex flex-wrap align-items-center gap-2">
                                <select id="dateRangeSelect" class="form-select w-auto">
                                    <option value="today" selected>Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="this_week">This Week</option>
                                    <option value="custom">Custom</option>
                                </select>

                                <!-- Only visible if user picks Custom -->
                                <input type="date" id="startDate" class="form-control w-auto d-none">
                                <input type="date" id="endDate" class="form-control w-auto d-none">
                            </div>
                        </div>

                        <hr class="my-3" />

                        <!-- === Parameter Selection === -->
                        <div class="row align-items-center">
                            <div class="col-md-3 my-3">
                                <label class="form-label fw-semibold mb-0">Select a Parameter:</label>
                            </div>
                            <div class="col-md-9 d-flex flex-wrap align-items-center gap-4">
                                {{-- <div class="btn-group flex-wrap" role="group" aria-label="Parameter Buttons"
                                            id="paramButtonsRealtime">
                                            <ul class="nav nav-pills">
                                                <style>
                                                    .nav-item {
                                                        /* Button spacing */
                                                        border-radius: 6px;
                                                        /* Rounded edges */
                                                        margin-right: 6px;
                                                    }

                                                    .nav-item .param {
                                                        border: 1px solid #E6E6E8;
                                                    }
                                                </style>
                                                <li class="nav-item">
                                                    <button type="button"
                                                        class="nav-link param waves-effect waves-light active"
                                                        data-param="VLN">LN Voltage</button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link param waves-effect waves-light"
                                                        data-param="VLL">LL Voltage</button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link param waves-effect waves-light"
                                                        data-param="Current">Current</button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link param waves-effect waves-light"
                                                        data-param="Active">Active</button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link param waves-effect waves-light"
                                                        data-param="Reactive">Reactive</button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link param waves-effect waves-light"
                                                        data-param="Apparent">Apparent</button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link param waves-effect waves-light"
                                                        data-param="PF">Power Factor</button>
                                                </li>

                                            </ul>
                                        </div> --}}

                                <span class="vr mx-3" style="background-color:#E6E6E8;"></span>

                                <div class="form-check form-check-inline m-0">
                                    <input class="form-check-input" type="radio" name="systemTypeRealtime"
                                        id="systemRealtime" value="system" checked />
                                    <label class="form-check-label" for="systemRealtime">System</label>
                                </div>
                                <div class="form-check form-check-inline m-0">
                                    <input class="form-check-input" type="radio" name="systemTypeRealtime"
                                        id="phaseRealtime" value="phase" />
                                    <label class="form-check-label" for="phaseRealtime">Phase</label>
                                </div>
                            </div>
                        </div>

                        {{-- <hr class="my-3" /> --}}

                        <!-- === Time Interval Selection === -->
                        {{-- <div class="row align-items-center mb-3">
                                    <div class="col-md-2 my-3">
                                        <label class="form-label fw-semibold mb-0">Select a Time Interval:</label>
                                    </div>
                                    <div class="col-md-10 d-flex align-items-center gap-3">
                                        <select id="intervalSelect" class="form-select w-auto">
                                            <option value="1">1 Minute</option>
                                            <option value="5" selected>5 Minutes</option>
                                            <option value="10">10 Minutes</option>
                                            <option value="15">15 Minutes</option>
                                            <option value="30">30 Minutes</option>
                                            <option value="60">60 Minutes</option>
                                        </select>
                                    </div>
                                </div> --}}
                    </div>
                </div>
            </div>
            <!-- View sales -->

            <!-- Statistics -->
            <div class="col-xl-6 col-md-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Statistics</h5>
                        <small class="text-muted">Updated 1 month ago</small>
                    </div>
                    <div class="card-body d-flex align-items-end">
                        <div class="w-100">
                            <div class="row gy-3">
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-primary me-4 p-2"><i
                                                class="ti ti-chart-pie-2 ti-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0">230k</h5>
                                            <small>Sales</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-info me-4 p-2"><i class="ti ti-users ti-lg"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">8.549k</h5>
                                            <small>Customers</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-danger me-4 p-2"><i
                                                class="ti ti-shopping-cart ti-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0">1.423k</h5>
                                            <small>Products</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-success me-4 p-2"><i
                                                class="ti ti-currency-dollar ti-lg"></i></div>
                                        <div class="card-info">
                                            <h5 class="mb-0">$9745</h5>
                                            <small>Revenue</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics -->

            <!-- Current -->
            <div class="col-xl-5">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <style>
                            #ChartCurrent {
                                width: 100%;
                                height: 300px;
                                background: #fff;
                                border-radius: 8px;
                                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                                padding: 10px;
                            }
                        </style>
                        <div id="ChartCurrent" style="width: 100%; height: 300px;"></div>
                        <!-- Current Statistics Info -->
                        <div class="card shadow-sm border-0 mt-2" style="border-radius: 8px;">
                            <div class="card-header pb-1 pt-2 px-3 d-flex align-items-center justify-content-between"
                                style="background: transparent; border-bottom: 1px solid #f0f0f0;">
                                <h6 class="mb-0 fw-bold text-muted" style="font-size: 1rem;">Current Statistics</h6>
                                <span class="badge bg-label-secondary text-body">Live</span>
                            </div>
                            <div class="card-body pt-2 pb-2 px-3">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0 align-middle">
                                        <thead>
                                            <tr class="text-muted" style="font-size: 0.95rem;">
                                                <th class="border-0">Phase</th>
                                                <th class="border-0">Min</th>
                                                <th class="border-0">Max</th>
                                                <th class="border-0">Avg</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="fw-semibold" style="color:#4caf50;">I1</span></td>
                                                <td><span id="i1-min">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="i1-max">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="i1-avg">-</span> <span class="text-muted">A</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="fw-semibold" style="color:#ff9800;">I2</span></td>
                                                <td><span id="i2-min">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="i2-max">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="i2-avg">-</span> <span class="text-muted">A</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="fw-semibold" style="color:#00bcd4;">I3</span></td>
                                                <td><span id="i3-min">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="i3-max">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="i3-avg">-</span> <span class="text-muted">A</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="fw-semibold" style="color:#cddc39;">IN</span></td>
                                                <td><span id="in-min">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="in-max">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="in-avg">-</span> <span class="text-muted">A</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="fw-semibold" style="color:#f44336;">IPE</span></td>
                                                <td><span id="ipe-min">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="ipe-max">-</span> <span class="text-muted">A</span></td>
                                                <td><span id="ipe-avg">-</span> <span class="text-muted">A</span></td>
                                            </tr>
                                            <script>
                                                // Update statistics table with chart/device data
                                                function updateCurrentStats(stats) {
                                                    const statMap = [{
                                                            key: 'I1',
                                                            min: 'i1-min',
                                                            max: 'i1-max',
                                                            avg: 'i1-avg'
                                                        },
                                                        {
                                                            key: 'I2',
                                                            min: 'i2-min',
                                                            max: 'i2-max',
                                                            avg: 'i2-avg'
                                                        },
                                                        {
                                                            key: 'I3',
                                                            min: 'i3-min',
                                                            max: 'i3-max',
                                                            avg: 'i3-avg'
                                                        },
                                                        {
                                                            key: 'IN',
                                                            min: 'in-min',
                                                            max: 'in-max',
                                                            avg: 'in-avg'
                                                        },
                                                        {
                                                            key: 'IPE',
                                                            min: 'ipe-min',
                                                            max: 'ipe-max',
                                                            avg: 'ipe-avg'
                                                        },
                                                        {
                                                            key: 'Iavg_A',
                                                            min: 'iavg-min',
                                                            max: 'iavg-max',
                                                            avg: 'iavg-avg'
                                                        }
                                                    ];
                                                    statMap.forEach(({
                                                        key,
                                                        min,
                                                        max,
                                                        avg
                                                    }) => {
                                                        if (stats[key]) {
                                                            const minEl = document.getElementById(min);
                                                            const maxEl = document.getElementById(max);
                                                            const avgEl = document.getElementById(avg);
                                                            if (minEl) minEl.textContent = stats[key].min;
                                                            if (maxEl) maxEl.textContent = stats[key].max;
                                                            if (avgEl) avgEl.textContent = stats[key].avg;
                                                        }
                                                    });
                                                }
                                            </script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Current -->

            <div class="col-xl-7 col-12">
                <div class="row g-2">

                    <!-- Voltage L-N -->
                    <div class="col-xl-6 col-sm-6">
                        <div class="card h-100">
                            {{-- <div class="card-header pb-0">
                                <h5 class="card-title mb-1">Voltage L-N</h5>
                                <p class="card-subtitle">Line to Neutral</p>
                            </div> --}}
                            <div class="card-body p-0">
                                <style>
                                    #ChartVLN {
                                        width: 100%;
                                        height: 300px;
                                        background: #fff;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                                        padding: 10px;
                                    }
                                </style>
                                <div id="ChartVLN" style="width: 100%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Voltage L-N -->


                    <!-- Voltage L-L -->
                    <div class="col-xl-6 col-sm-6">
                        <div class="card h-100">
                            {{-- <div class="card-header pb-2">
                                <h5 class="card-title mb-1">Voltage L-L</h5>
                                <p class="card-subtitle">Line to Line</p>
                            </div> --}}
                            <div class="card-body p-0">
                                <style>
                                    #ChartVLL {
                                        width: 100%;
                                        height: 300px;
                                        background: #fff;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                                        padding: 10px;
                                    }
                                </style>
                                <div id="ChartVLL" style="width: 100%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Voltage L-L -->


                    <!-- Frequency -->
                    <div class="col-xl-12">
                        <div class="card h-100">
                            {{-- <div class="card-header pb-2">
                                <h5 class="card-title mb-1">Frequency</h5>
                                <p class="card-subtitle">System Frequency</p>
                            </div> --}}
                            <div class="card-body p-0">
                                <style>
                                    #ChartFreq {
                                        width: 100%;
                                        height: 300px;
                                        background: #fff;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                                        padding: 10px;
                                    }
                                </style>
                                <div id="ChartFreq" style="width: 100%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Frequency -->


                    <!-- Main Monitoring Chart (removed, now split into four charts above) -->
                </div>
            </div>

            <!-- Earning Reports -->
            <div class="col-xxl-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Earning Reports</h5>
                            <p class="card-subtitle">Weekly Earnings Overview</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1"
                                type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-md text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                <a class="dropdown-item" href="javascript:void(0);">Download</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <ul class="p-0 m-0">
                            <li class="d-flex align-items-center mb-5">
                                <div class="me-4">
                                    <span class="badge bg-label-primary rounded p-1_5"><i
                                            class='ti ti-chart-pie-2 ti-md'></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Net Profit</h6>
                                        <small class="text-body">12.4k Sales</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-4">
                                        <small>$1,619</small>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class='ti ti-chevron-up text-success'></i>
                                            <small class="text-muted">18.6%</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="me-4">
                                    <span class="badge bg-label-success rounded p-1_5"><i
                                            class='ti ti-currency-dollar ti-md'></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Total Income</h5>
                                            <small class="text-body">Sales, Affiliation</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-4">
                                        <small>$3,571</small>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class='ti ti-chevron-up text-success'></i>
                                            <small class="text-muted">39.6%</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="me-4">
                                    <span class="badge bg-label-secondary text-body rounded p-1_5"><i
                                            class='ti ti-credit-card ti-md'></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Total Expenses</h6>
                                        <small class="text-body">ADVT, Marketing</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-4">
                                        <small>$430</small>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class='ti ti-chevron-up text-success'></i>
                                            <small class="text-muted">52.8%</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div id="reportBarChart"></div>
                    </div>
                </div>
            </div>
            <!--/ Earning Reports -->

            <!-- Popular Product -->
            <div class="col-xxl-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title m-0 me-2">
                            <h5 class="mb-1">Popular Products</h5>
                            <p class="card-subtitle">Total 10.4k Visitors</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1"
                                type="button" id="popularProduct" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-md text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="popularProduct">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-6">
                                <div class="me-4">
                                    <img src="{{ asset('assets/img/products/iphone.png') }}" alt="User"
                                        class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Apple iPhone 13</h6>
                                        <small class="text-body d-block">Item: #FXZ-4567</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0">$999.29</p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6">
                                <div class="me-4">
                                    <img src="{{ asset('assets/img/products/nike-air-jordan.png') }}" alt="User"
                                        class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Nike Air Jordan</h6>
                                        <small class="text-body d-block">Item: #FXZ-3456</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0">$72.40</p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6">
                                <div class="me-4">
                                    <img src="{{ asset('assets/img/products/headphones.png') }}" alt="User"
                                        class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Beats Studio 2</h6>
                                        <small class="text-body d-block">Item: #FXZ-9485</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0">$99</p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6">
                                <div class="me-4">
                                    <img src="{{ asset('assets/img/products/apple-watch.png') }}" alt="User"
                                        class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Apple Watch Series 7</h6>
                                        <small class="text-body d-block">Item: #FXZ-2345</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0">$249.99</p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6">
                                <div class="me-4">
                                    <img src="{{ asset('assets/img/products/amazon-echo.png') }}" alt="User"
                                        class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Amazon Echo Dot</h6>
                                        <small class="text-body d-block">Item: #FXZ-8959</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0">$79.40</p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="me-4">
                                    <img src="{{ asset('assets/img/products/play-station.png') }}" alt="User"
                                        class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Play Station Console</h6>
                                        <small class="text-body d-block">Item: #FXZ-7892</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0">$129.48</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Popular Product -->

            <!-- Sales by Countries tabs-->
            <div class="col-xxl-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Orders by Countries</h5>
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
                    </div>
                    <div class="card-body p-0">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                                        aria-selected="true">New</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-link-preparing"
                                        aria-controls="navs-justified-link-preparing"
                                        aria-selected="false">Preparing</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-link-shipping"
                                        aria-controls="navs-justified-link-shipping"
                                        aria-selected="false">Shipping</button>
                                </li>
                            </ul>
                            <div class="tab-content border-0  mx-1">
                                <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class='ti ti-circle-check'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Myrtle Ullrich</h6>
                                                <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class='ti ti-map-pin'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Barry Schowalter</h6>
                                                <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-1 border-light border-top border-dashed my-4"></div>
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class='ti ti-circle-check'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Veronica Herman</h6>
                                                <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class='ti ti-map-pin'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Helen Jacobs</h6>
                                                <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class='ti ti-circle-check'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Barry Schowalter</h6>
                                                <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class='ti ti-map-pin'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Myrtle Ullrich</h6>
                                                <p class="text-body mb-0">101 Boulder, California(CA), 95959 </p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-1 border-light border-top border-dashed my-4"></div>
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class='ti ti-circle-check'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Veronica Herman</h6>
                                                <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class='ti ti-map-pin'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Helen Jacobs</h6>
                                                <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class='ti ti-circle-check'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Veronica Herman</h6>
                                                <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class='ti ti-map-pin'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Barry Schowalter</h6>
                                                <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-1 border-light border-top border-dashed my-4"></div>
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class='ti ti-circle-check'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Myrtle Ullrich</h6>
                                                <p class="text-body mb-0">162 Windsor, California(CA), 95492 </p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class='ti ti-map-pin'></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Helen Jacobs</h6>
                                                <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sales by Countries tabs -->
        </div>
    </div>

    <style>
        /* Hover effect */
        .jstree-anchor:hover .file-node {
            color: var(--bs-secondary) !important;
        }

        /* Selected node */
        .jstree-clicked .file-node {
            color: #fff !important;
        }
    </style>

    <style>
        .layout-example-sidebar {
            position: sticky;
            top: 1rem;
            align-self: flex-start;
        }

        #tree {
            max-height: calc(100vh - 280px);
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 6px;
        }

        #tree::-webkit-scrollbar {
            width: 8px;
        }

        #tree::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.12);
            border-radius: 6px;
        }
    </style>

    <script>
        window.APP_URL = "{{ config('app.url') }}";
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // No single chart instance; we'll use four containers

            // ✅ 1. Call JsTree API
            $.getJSON('/monitoring/analysis/data', function(data) {
                $('#tree').jstree({
                    core: {
                        themes: {
                            name: 'default' // Set a valid theme name
                        },
                        data: data
                    },
                    plugins: ['types', 'wholerow'],
                    types: {
                        default: {
                            icon: 'ti ti-folder'
                        },
                        facility: {
                            icon: 'ti ti-building-community text-warning'
                        },
                        location: {
                            icon: 'ti ti-building text-success'
                        },
                        file: {
                            icon: 'ti ti-activity-heartbeat text-primary file-node'
                        }
                    }
                });
            });

            // ✅ 2. Ensure jsTree is fully ready

            // Auto-select first device node and set default params on jsTree ready
            $('#tree').on('ready.jstree', function() {
                const tree = $('#tree').jstree(true);
                // Do not select any device by default
                tree.deselect_all();
                // Remove chart on load (clear all chart containers)
                ['ChartCurrent', 'ChartVLN', 'ChartVLL', 'ChartFreq'].forEach(id => {
                    const dom = document.getElementById(id);
                    if (dom) {
                        const chart = echarts.getInstanceByDom(dom);
                        if (chart) chart.clear();
                    }
                });
            });

            // ✅ 3. Detect device selection
            $('#tree').on('click.jstree', '.jstree-anchor', function(e) {
                const tree = $('#tree').jstree(true);
                const node = tree.get_node(this);

                tree.toggle_node(node);
            });

            $('#tree').on('select_node.jstree', function(e, data) {
                if (data.node.id.startsWith('model_')) {
                    updateAllCharts();
                }
            });

            // Prevent page scrolling when using mouse wheel over the tree (keeps right pane stable)
            (function() {
                const treeEl = document.getElementById('tree');
                if (!treeEl) return;
                treeEl.addEventListener('wheel', function(e) {
                    const delta = e.deltaY;
                    const atTop = treeEl.scrollTop === 0;
                    const atBottom = Math.abs(treeEl.scrollHeight - treeEl.clientHeight - treeEl
                        .scrollTop) < 1;
                    if ((delta < 0 && atTop) || (delta > 0 && atBottom)) {
                        e.preventDefault();
                    }
                }, {
                    passive: false
                });
            })();

            // ✅ 4. Safe function to get selected device
            function getSelectedDevice() {
                const tree = $('#tree').jstree(true);
                if (!tree || typeof tree.get_selected !== 'function') return null;

                const selected = tree.get_selected(true);
                if (selected.length > 0) {
                    const node = selected[0];
                    if (node.type === 'file' || node.id.startsWith('model_')) {
                        // ...existing code...
                        return node.text; // <-- this is device_name
                    }
                }
                return null;
            }

            // =========================================================
            // 1️⃣ TIME AXIS (Start-End Date + Interval)
            // =========================================================
            function generateTimeAxis(start, end, interval) {
                const times = [];
                let current = new Date(start);

                while (current <= end) {
                    const yyyy = current.getFullYear();
                    const mm = String(current.getMonth() + 1).padStart(2, '0');
                    const dd = String(current.getDate()).padStart(2, '0');
                    const hh = String(current.getHours()).padStart(2, '0');
                    const min = String(current.getMinutes()).padStart(2, '0');

                    times.push(`${yyyy}-${mm}-${dd} ${hh}:${min}`);
                    current.setMinutes(current.getMinutes() + interval);
                }
                return times;
            }

            // ✅ Full-day timestamp (00:00 to 23:59) for Today
            function getSelectedDateRange() {
                const selection = document.getElementById('dateRangeSelect').value;
                const today = new Date();
                let start = new Date();
                let end = new Date();

                switch (selection) {
                    case "today":
                        start.setHours(0, 0, 0, 0);
                        end.setHours(23, 59, 0, 0);
                        break;

                    case "yesterday":
                        start.setDate(today.getDate() - 1);
                        end.setDate(today.getDate() - 1);
                        start.setHours(0, 0, 0, 0);
                        end.setHours(23, 59, 0, 0);
                        break;

                    case "this_week":
                        const day = today.getDay(); // 0 = Sunday
                        const diff = today.getDate() - (day === 0 ? 6 : day - 1);
                        start = new Date(today.setDate(diff));
                        start.setHours(0, 0, 0, 0);
                        end = new Date();
                        end.setHours(23, 59, 0, 0);
                        break;

                    case "custom":
                        const startInput = document.getElementById('startDate').value;
                        const endInput = document.getElementById('endDate').value;
                        if (!startInput || !endInput) return null; // 🛑 IMPORTANT FIX
                        start = new Date(startInput);
                        start.setHours(0, 0, 0, 0);
                        end = new Date(endInput);
                        end.setHours(23, 59, 0, 0);
                        break;
                }

                return {
                    start,
                    end
                };
            }

            // =========================================================
            // 2️⃣ GET SELECTED PARAMETERS & SYSTEM TYPE
            // =========================================================
            function getSelectedParams() {
                const activeBtn = document.querySelector('#paramButtonsRealtime .active');
                if (!activeBtn) return ['V1', 'V2', 'V3']; // fallback
                return getParameters(activeBtn.dataset.param);
            }

            function getSystemType() {
                return document.querySelector('input[name="systemTypeRealtime"]:checked')?.value || 'phase';
            }

            function getParameters(paramType) {
                const systemType = getSystemType();
                const map = {
                    phase: {
                        VLN: [{
                                key: 'V1',
                                label: 'Phase 1 Line-to-Neutral Voltage'
                            },
                            {
                                key: 'V2',
                                label: 'Phase 2 Line-to-Neutral Voltage'
                            },
                            {
                                key: 'V3',
                                label: 'Phase 3 Line-to-Neutral Voltage'
                            }
                        ],
                        VLL: [{
                                key: 'V12',
                                label: 'Phase 1-2 Line-to-Line Voltage'
                            },
                            {
                                key: 'V23',
                                label: 'Phase 2-3 Line-to-Line Voltage'
                            },
                            {
                                key: 'V31',
                                label: 'Phase 3-1 Line-to-Line Voltage'
                            }
                        ],
                        Current: [{
                                key: 'I1',
                                label: 'Phase 1 Current'
                            },
                            {
                                key: 'I2',
                                label: 'Phase 2 Current'
                            },
                            {
                                key: 'I3',
                                label: 'Phase 3 Current'
                            }
                        ],
                        Active: [{
                                key: 'P1',
                                label: 'Phase 1 Active Power'
                            },
                            {
                                key: 'P2',
                                label: 'Phase 2 Active Power'
                            },
                            {
                                key: 'P3',
                                label: 'Phase 3 Active Power'
                            }
                        ],
                        Reactive: [{
                                key: 'Q1',
                                label: 'Phase 1 Reactive Power'
                            },
                            {
                                key: 'Q2',
                                label: 'Phase 2 Reactive Power'
                            },
                            {
                                key: 'Q3',
                                label: 'Phase 3 Reactive Power'
                            }
                        ],
                        Apparent: [{
                                key: 'S1',
                                label: 'Phase 1 Apparent Power'
                            },
                            {
                                key: 'S2',
                                label: 'Phase 2 Apparent Power'
                            },
                            {
                                key: 'S3',
                                label: 'Phase 3 Apparent Power'
                            }
                        ],
                        PF: [{
                                key: 'PF1',
                                label: 'Phase 1 Power Factor'
                            },
                            {
                                key: 'PF2',
                                label: 'Phase 2 Power Factor'
                            },
                            {
                                key: 'PF3',
                                label: 'Phase 3 Power Factor'
                            }
                        ]
                    },

                    system: {
                        Freq_Hz: [{
                            key: 'Freq_Hz',
                            label: 'System Frequency'
                        }],
                        VLN: [{
                            key: 'Vnavg_V',
                            label: 'Voltage L-N'
                            // label: 'System Average Line-to-Neutral Voltage'
                        }],
                        VLL: [{
                            key: 'Vlavg_V',
                            label: 'Voltage L-L'
                            // label: 'System Average Line-to-Line Voltage'
                        }],
                        Current: [{
                            key: 'Iavg_A',
                            label: 'Current'
                            // label: 'System Average Current'
                        }],
                        Active: [{
                            key: 'Psum_kW',
                            label: 'System Active Power (kW)'
                        }],
                        Reactive: [{
                            key: 'Qsum_kvar',
                            label: 'System Reactive Power (kVAR)'
                        }],
                        Apparent: [{
                            key: 'Ssum_kVA',
                            label: 'System Apparent Power (kVA)'
                        }],
                        PF: [{
                            key: 'PF',
                            label: 'System Power Factor'
                        }]
                    }
                };

                return map[systemType][paramType] || [];
            }

            function getYAxisLabel(params) {
                if (!params || params.length === 0) return '';

                const firstKey = params[0].key; // Check first selected parameter

                if (firstKey.startsWith('Freq')) return 'Hz';
                if (firstKey.startsWith('V')) return 'V';
                if (firstKey.startsWith('I')) return 'A';
                if (firstKey.startsWith('PF')) return 'PF';
                if (firstKey.startsWith('Psum') || firstKey.startsWith('P')) return 'kW';
                if (firstKey.startsWith('Qsum') || firstKey.startsWith('Q')) return 'kVAR';
                if (firstKey.startsWith('Ssum') || firstKey.startsWith('S')) return 'kVA';

                return ''; // default
            }

            // =========================================================
            // 3️⃣ GET SELECTED INTERVAL
            // =========================================================
            function getSelectedInterval() {
                const intervalSelect = document.getElementById('intervalSelect');
                return intervalSelect ? parseInt(intervalSelect.value) : 5;
            }

            // =========================================================
            // 4️⃣ COLOR CONFIGURATION
            // =========================================================
            function getColor(param) {
                const phaseR = ['V1', 'V12', 'I1', 'P1', 'Q1', 'S1', 'PF1'];
                const phaseS = ['V2', 'V23', 'I2', 'P2', 'Q2', 'S2', 'PF2'];
                const phaseT = ['V3', 'V31', 'I3', 'P3', 'Q3', 'S3', 'PF3'];
                const system = ['Freq_Hz', 'Vnavg_V', 'Vlavg_V', 'Iavg_A',
                    'Psum_kW', 'Qsum_kvar', 'Ssum_kVA', 'PF'
                ];

                // if (param === 'Freq_Hz') return '#00B894'; // green for frequency
                if (phaseR.includes(param)) return '#FF4560';
                if (phaseS.includes(param)) return '#FEB019';
                if (phaseT.includes(param)) return '#008FFB';
                if (system.includes(param)) return '#7367F0';
                return '#FFA500';
            }

            // =========================================================
            // 5️⃣ FETCH API DATA
            // =========================================================

            async function fetchChartData(params, start, end, deviceName) {
                if (!params.length) return [];

                // const queryParams = params.map(p => `parameters[]=${p}`).join('&');
                const queryParams = params.map(p => `parameters[]=${p.key}`).join('&');

                let url = "";

                const startDate = start.toISOString().split('T')[0];
                const endDate = end.toISOString().split('T')[0];

                const API = window.APP_URL;

                // ✅ If 1 day
                if (startDate === endDate) {
                    url =
                        `${API}/api/v1/data?date=${startDate}&device_name=${encodeURIComponent(deviceName)}&${queryParams}`;
                }
                // ✅ If multiple days
                else {
                    url =
                        `${API}/api/v1/data?start_date=${startDate}&end_date=${endDate}&device_name=${encodeURIComponent(deviceName)}&${queryParams}`;
                }

                // ...existing code...

                try {
                    const response = await fetch(url);
                    return await response.json();
                } catch (err) {
                    console.error("API Fetch Error:", err);
                    return [];
                }
            }

            // =========================================================
            // 6️⃣ BUILD SERIES (Align Data to Time Axis)
            // =========================================================
            function buildSeriesData(apiData, timeAxis, params) {
                const lookup = {};
                apiData.forEach(d => {
                    const timeKey = d.time.slice(0, 16); // "YYYY-MM-DD HH:mm"
                    lookup[timeKey] = d;
                });

                return params.map(p => ({
                    name: p.label, // ← Show readable text on legend
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 6,
                    data: timeAxis.map(t => lookup[t] ? lookup[t][p.key] : null), // ✅ Use API key

                    lineStyle: {
                        width: 2,
                        color: getColor(p.key) // ← Use key for color
                    },
                    itemStyle: {
                        color: '#ffffff', // ✅ White fill inside the circle
                        borderColor: getColor(p.key),
                        borderWidth: 2 // ✅ Outline thickness
                    }
                }));
            }

            // =========================================================
            // 7️⃣ RENDER CHART
            // =========================================================
            function renderChart(containerId, timeAxis, series, params) {
                const chartDom = document.getElementById(containerId);
                if (!chartDom) return;
                let chartInstance = echarts.getInstanceByDom(chartDom);
                if (!chartInstance) chartInstance = echarts.init(chartDom);
                const allValues = series.flatMap(s => s.data.filter(v => v !== null));
                const yMin = allValues.length ? Math.min(...allValues) : 0;
                if (containerId === 'ChartCurrent' && series.length >= 3) {
                    // Calculate min/max/avg for I1, I2, I3 from chart data
                    const stats = {};
                    ['I1', 'I2', 'I3'].forEach((key, idx) => {
                        const phaseSeries = series[idx];
                        if (phaseSeries) {
                            const values = phaseSeries.data.filter(v => v !== null);
                            const min = values.length ? Math.min(...values) : '-';
                            const max = values.length ? Math.max(...values) : '-';
                            const avg = values.length ? (values.reduce((a, b) => a + b, 0) / values.length)
                                .toFixed(0) : '-';
                            stats[key] = {
                                min,
                                max,
                                avg
                            };
                            // ...existing code...
                        }
                    });
                    // Optionally, handle IN and IPE if present in params/series
                    ['IN', 'IPE'].forEach((key) => {
                        const idx = params.findIndex(p => p.key === key);
                        if (idx !== -1 && series[idx]) {
                            const values = series[idx].data.filter(v => v !== null);
                            const min = values.length ? Math.min(...values) : '-';
                            const max = values.length ? Math.max(...values) : '-';
                            const avg = values.length ? (values.reduce((a, b) => a + b, 0) / values.length)
                                .toFixed(0) : '-';
                            stats[key] = {
                                min,
                                max,
                                avg
                            };
                        }
                    });
                    // Handle Iavg_A if present
                    if (params.some(p => p.key === 'Iavg_A')) {
                        const iavgIdx = params.findIndex(p => p.key === 'Iavg_A');
                        if (iavgIdx !== -1 && series[iavgIdx]) {
                            const values = series[iavgIdx].data.filter(v => v !== null);
                            const min = values.length ? Math.min(...values) : '-';
                            const max = values.length ? Math.max(...values) : '-';
                            const avg = values.length ? (values.reduce((a, b) => a + b, 0) / values.length).toFixed(
                                0) : '-';
                            stats.Iavg_A = {
                                min,
                                max,
                                avg
                            };
                            // ...existing code...
                        }
                    }
                    // Update the statistics table from chart data
                    updateCurrentStats(stats);
                }
                // ...existing code...
                const yMax = allValues.length ? Math.max(...allValues) : 1;
                const yMargin = (yMax - yMin) * 0.1;
                const deviceName = getSelectedDevice();
                chartInstance.clear();
                chartInstance.setOption({
                    title: {
                        // text: deviceName,
                        text: params.map(p => p.label),
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function(items) {
                            const unit = getYAxisLabel(params);
                            let html = `${items[0].axisValue}<br/>`;
                            items.forEach(p => {
                                const value = (p.value !== null) ? Number(p.value).toFixed(2) :
                                    '0.00';
                                html += `${p.marker} ${p.seriesName}: ${value} ${unit}<br/>`;
                            });
                            return html;
                        }
                    },
                    // legend: {
                    //     type: 'plain',
                    //     orient: 'horizontal',
                    //     top: 20,
                    //     left: 20,
                    //     data: params.map(p => p.label),
                    // },
                    grid: {
                        left: '2%',
                        right: '2%',
                        top: '15%',
                        bottom: '10%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: timeAxis
                    },
                    yAxis: {
                        name: getYAxisLabel(params),
                        nameTextStyle: {
                            fontWeight: 'bold',
                            fontSize: 14,
                            padding: [0, 0, -12, 0] // [top, right, bottom, left] - move unit down
                        },
                        type: 'value',
                        axisLine: {
                            show: true
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee'
                            }
                        },
                        min: parseFloat((yMin - yMargin).toFixed(2)),
                        max: parseFloat((yMax + yMargin).toFixed(2))
                    },
                    series: series,
                    // dataZoom: [{
                    //     type: 'slider',
                    //     bottom: 5
                    // }, {
                    //     type: 'inside'
                    // }],
                    toolbox: {
                        // feature: {
                        //     saveAsImage: {},
                        //     restore: {}
                        // },
                        // right: 20
                    }
                }, true);
            }

            // =========================================================
            // 🔄 MAIN CONTROL FUNCTION
            // =========================================================

            // New: update all four charts
            async function updateAllCharts() {
                const deviceName = getSelectedDevice();
                if (!deviceName) return;
                const range = getSelectedDateRange();
                if (!range) return;
                const {
                    start,
                    end
                } = range;
                const interval = getSelectedInterval();
                const timeAxis = generateTimeAxis(start, end, interval);
                // Chart configs
                const chartTypes = [{
                        id: 'ChartCurrent',
                        param: 'Current'
                    },
                    {
                        id: 'ChartVLN',
                        param: 'VLN'
                    },
                    {
                        id: 'ChartVLL',
                        param: 'VLL'
                    },
                    {
                        id: 'ChartFreq',
                        param: 'Freq_Hz'
                    }
                ];
                for (const chart of chartTypes) {
                    let params;
                    if (chart.param === 'Freq_Hz') {
                        params = [{
                            key: 'Freq_Hz',
                            label: 'Frequency'
                        }];
                    } else {
                        params = getParameters(chart.param);
                    }
                    const apiData = await fetchChartData(params, start, end, deviceName);

                    // Log the lowest value of 'Iavg_A'
                    if (params.some(p => p.key === 'Iavg_A')) {
                        const iavgValues = apiData.map(d => d['Iavg_A']).filter(v => v !== undefined && v !==
                            null);
                        const minIavg = iavgValues.length ? Math.min(...iavgValues) : null;
                        // ...existing code...
                    }
                    // Log the lowest value of 'I1', 'I2', 'I3'
                    if (params.some(p => ['I1', 'I2', 'I3'].includes(p.key))) {
                        ['I1', 'I2', 'I3'].forEach(key => {
                            const values = apiData.map(d => d[key]).filter(v => v !== undefined && v !==
                                null);
                            const minVal = values.length ? Math.min(...values) : null;
                            // ...existing code...
                        });
                    }

                    const series = buildSeriesData(apiData, timeAxis, params);
                    renderChart(chart.id, timeAxis, series, params);

                    // If Current chart, calculate min/max/avg and update stats
                    if (chart.id === 'ChartCurrent' && params.length >= 3) {
                        // Extract arrays for I1, I2, I3, IN, IPE
                        const keys = ['I1', 'I2', 'I3', 'IN', 'IPE'];
                        const stats = {};
                        keys.forEach(key => {
                            const values = apiData.map(d => Number(d[key])).filter(v => !isNaN(v));
                            if (values.length) {
                                const min = Math.min(...values);
                                const max = Math.max(...values);
                                const avg = (values.reduce((a, b) => a + b, 0) / values.length);
                                stats[key] = {
                                    min: min.toFixed(0),
                                    max: max.toFixed(0),
                                    avg: avg.toFixed(0)
                                };
                            } else {
                                stats[key] = {
                                    min: '-',
                                    max: '-',
                                    avg: '-'
                                };
                            }
                        });
                        updateCurrentStats(stats);
                    }
                }
            }

            // =========================================================
            // EVENT LISTENERS
            // =========================================================
            // 📌 Show/Hide Custom Date Inputs
            document.getElementById('dateRangeSelect').addEventListener('change', function() {
                const isCustom = this.value === 'custom';
                document.getElementById('startDate').classList.toggle('d-none', !isCustom);
                document.getElementById('endDate').classList.toggle('d-none', !isCustom);
                if (!isCustom) updateAllCharts();
            });

            // 📌 Make date input fully clickable (open picker on click)
            ['startDate', 'endDate'].forEach(id => {
                const input = document.getElementById(id);
                input.addEventListener('click', function() {
                    this.showPicker?.(); // Open calendar when clicking anywhere
                });
            });

            // If custom date is selected, trigger chart update when both dates picked
            ['startDate', 'endDate'].forEach(id => {
                document.getElementById(id).addEventListener('change', function() {
                    const range = getSelectedDateRange();
                    if (range) updateAllCharts();
                });
            });

            document.querySelectorAll('#paramButtonsRealtime button').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('#paramButtonsRealtime button').forEach(b => b
                        .classList.remove('active'));
                    btn.classList.add('active');
                    updateAllCharts();
                });
            });

            document.querySelectorAll('input[name="systemTypeRealtime"]').forEach(r => {
                r.addEventListener('change', updateAllCharts);
            });

            const intervalSelect = document.getElementById('intervalSelect');
            if (intervalSelect) intervalSelect.addEventListener('change', updateAllCharts);
            window.addEventListener('resize', function() {
                ['ChartCurrent', 'ChartVLN', 'ChartVLL', 'ChartFreq'].forEach(id => {
                    const dom = document.getElementById(id);
                    if (dom) {
                        const chart = echarts.getInstanceByDom(dom);
                        if (chart) chart.resize();
                    }
                });
            });

            // ✅ Load Chart First Time
            updateAllCharts();
        });
    </script>


@endsection
