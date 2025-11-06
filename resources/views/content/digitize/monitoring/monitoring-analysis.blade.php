@php
    $configData = Helper::appClasses();
    $isFlex = true;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Content navbar + Sidebar - Layouts')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite('resources/assets/vendor/libs/jstree/jstree.scss')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite('resources/assets/vendor/libs/jstree/jstree.js')
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite('resources/assets/js/extended-ui-treeview.js')
@endsection

<!-- Include jsTree CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css">
<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Include jsTree JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

@section('content')
    <div class="flex-shrink-1 flex-grow-0 w-px-350 border-end container-p-x container-p-y">
        <div class="layout-example-sidebar layout-example-content-inner">
            <!-- Checkbox -->
            <div class="col-md-12 col-12">
                <div class="card mb-md-0 mb-6">
                    <h5 class="card-header">Analysis</h5>
                    <div class="card-body">
                        <div id="tree"></div>

                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('monitoring-analysis-selectdata') }}" enctype="multipart/form-data"
                class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="getSelectedForm">
                @csrf <!-- CSRF protection -->
                @method('POST')
                <script>
                    $(document).ready(function() {
                        // Load the JSON data from the DatalogController
                        $.getJSON('/monitoring/analysis/data', function(data) {
                            $('#tree').jstree({
                                core: {
                                    themes: {
                                        name: 'default' // Set a valid theme name
                                    },
                                    data: data
                                },
                                plugins: ['types', 'checkbox', 'wholerow'],
                                types: {
                                    default: {
                                        icon: 'ti ti-folder'
                                    },
                                    html: {
                                        icon: 'ti ti-brand-html5 text-danger'
                                    },
                                    css: {
                                        icon: 'ti ti-brand-css3 text-info'
                                    },
                                    img: {
                                        icon: 'ti ti-photo text-success'
                                    },
                                    js: {
                                        icon: 'ti ti-brand-javascript text-warning'
                                    },
                                    file: {
                                        icon: 'ti ti-file text-success'
                                    }
                                }
                            });
                        });
                    });

                    // Capture form submission
                    $('#getSelectedForm').on('submit', function(e) {
                        const selectedDevices = [];
                        const selectedNodes = $('#tree').jstree("get_checked", true);

                        selectedNodes.forEach(function(node) {
                            if (node.id.startsWith('model_')) { // Collect only device nodes
                                selectedDevices.push(node.text); // Use the node's text
                            }
                        });

                        // Add the selected devices to the hidden input
                        $('#selectedDevicesInput').val(JSON.stringify(selectedDevices));
                    });
                </script>
                <input type="hidden" name="selectedDevices" id="selectedDevicesInput">

                <button id="submitSelection" class="btn btn-primary mt-3">Submit</button>
            </form>

            <!-- /Checkbox -->
        </div>
    </div>

    <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
        <div class="row">
            <div class="col-md-12">
                <!-- Navigation Tabs -->
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills flex-column flex-md-row gap-2 gap-lg-0" id="energyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="energy-tab" data-bs-toggle="tab" data-bs-target="#energy"
                                type="button" role="tab" aria-controls="energy" aria-selected="true">
                                <i class="ti-sm ti ti-bolt me-1_5"></i> Energy
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="realtime-tab" data-bs-toggle="tab"
                                data-bs-target="#realtime" type="button" role="tab" aria-controls="realtime"
                                aria-selected="false">
                                <i class="ti-sm ti ti-activity me-1_5"></i> Realtime
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="heatmap-tab" data-bs-toggle="tab" data-bs-target="#heatmap"
                                type="button" role="tab" aria-controls="heatmap" aria-selected="false">
                                <i class="ti-sm ti ti-flame me-1_5"></i> Heatmap
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="demand-tab" data-bs-toggle="tab" data-bs-target="#demand"
                                type="button" role="tab" aria-controls="demand" aria-selected="false">
                                <i class="ti-sm ti ti-trending-up me-1_5"></i> Demand
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tabs Content -->
                <div class="tab-content mt-4 p-0" id="energyTabsContent">
                    <!-- Energy -->
                    <div class="tab-pane fade" id="energy" role="tabpanel" aria-labelledby="energy-tab">
                        <h5 class="fw-bold mb-2">
                            <i class="ti ti-bolt me-1"></i> Energy Overview
                        </h5>
                        <p class="text-muted mb-0">
                            This section shows your active energy summary and trends.
                        </p>
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <!-- === Time Frame Selection === -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Select a Time Frame:</label>
                                    </div>
                                    <div class="col-md-10 d-flex flex-wrap align-items-center gap-2">
                                        <select class="form-select w-auto">
                                            <option>Today</option>
                                            <option>Yesterday</option>
                                            <option>This Week</option>
                                            <option>Custom</option>
                                        </select>
                                        <input type="datetime-local" class="form-control w-auto" value="2025-10-29T00:00" />
                                        <span class="mx-2 fw-semibold">To</span>
                                        <input type="datetime-local" class="form-control w-auto" value="2025-10-30T00:00" />
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="checkbox" id="compareCheck" />
                                            <label class="form-check-label" for="compareCheck">Compare to</label>
                                        </div>
                                        <input type="text" class="form-control w-auto" id="comparisonDate"
                                            placeholder="Comparison Date" disabled />
                                        <button class="btn btn-sm btn-primary ms-auto">Update Chart</button>
                                    </div>
                                </div>

                                <hr />

                                <!-- === Parameter Selection === -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Select a Parameter:</label>
                                    </div>
                                    <div class="col-md-10 d-flex flex-wrap align-items-center gap-2">
                                        <div class="btn-group" role="group" aria-label="Parameter Type">
                                            <button type="button" class="btn btn-outline-primary active">Active</button>
                                            <button type="button" class="btn btn-outline-primary">Reactive</button>
                                            <button type="button" class="btn btn-outline-primary">Apparent</button>
                                        </div>

                                        <span class="vr mx-3"></span>

                                        <div class="btn-group" role="group" aria-label="Direction">
                                            <button type="button"
                                                class="btn btn-outline-secondary active">Import</button>
                                            <button type="button" class="btn btn-outline-secondary">Export</button>
                                            <button type="button" class="btn btn-outline-secondary">Net</button>
                                            <button type="button" class="btn btn-outline-secondary">Total</button>
                                        </div>

                                        <span class="vr mx-3"></span>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="systemTypeEnergy"
                                                id="systemEnergy" checked />
                                            <label class="form-check-label" for="systemEnergy">System</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="systemTypeEnergy"
                                                id="phaseEnergy" />
                                            <label class="form-check-label" for="phaseEnergy">Phase</label>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <!-- === Time Interval Selection === -->
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Select a Time Interval:</label>
                                    </div>
                                    <div class="col-md-10 d-flex align-items-center gap-3">
                                        {{-- <select id="intervalSelect" class="form-select w-auto">
                                            <option value="1">1 Minute</option>
                                            <option value="5">5 Minutes</option>
                                            <option value="10">10 Minutes</option>
                                            <option value="15">15 Minutes</option>
                                            <option value="30">30 Minutes</option>
                                            <option value="60">60 Minutes</option>
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chart -->
                        <div class="card mt-6">
                            <h5 class="card-header">Delete Account</h5>
                            <div class="card-body">
                                <div class="alert alert-warning mb-4">
                                    <h5 class="alert-heading mb-1">
                                        Are you sure you want to delete your account?
                                    </h5>
                                    <p class="mb-0">
                                        Once you delete your account, there is no going back. Please be
                                        certain.
                                    </p>
                                </div>

                                <form id="formAccountDeactivation" onsubmit="return false;">
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="accountActivation"
                                            id="accountActivation" />
                                        <label class="form-check-label" for="accountActivation">
                                            I confirm my account deactivation
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-danger deactivate-account" disabled>
                                        Deactivate Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Realtime -->
                    <div class="tab-pane fade show active" id="realtime" role="tabpanel"
                        aria-labelledby="realtime-tab">
                        <h5 class="fw-bold mb-2">
                            <i class="ti ti-activity me-1"></i> Realtime Monitoring
                        </h5>
                        <p class="text-muted mb-0">
                            Live data feed and instant parameter updates.
                        </p>
                        <div class="tab-pane fade show active" id="realtime" role="tabpanel"
                            aria-labelledby="energy-tab">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <!-- === Time Frame Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2">
                                            <label class="form-label fw-semibold mb-0">Select a Time Frame:</label>
                                        </div>
                                        <div class="col-md-10 d-flex flex-wrap align-items-center gap-2">
                                            <select id="dateRangeSelect" class="form-select w-auto">
                                                <option value="today" selected>Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="this_week">This Week</option>
                                                <option value="custom">Custom</option>
                                            </select>

                                            <!-- Only visible if user picks Custom -->
                                            <input type="date" id="startDate" class="form-control w-auto d-none">
                                            <input type="date" id="endDate" class="form-control w-auto d-none">


                                            {{-- <input type="datetime-local" class="form-control w-auto"
                                                value="2025-10-29T00:00" />
                                            <span class="mx-2 fw-semibold">To</span>
                                            <input type="datetime-local" class="form-control w-auto"
                                                value="2025-10-30T00:00" />

                                            <div class="form-check ms-3">
                                                <input class="form-check-input" type="checkbox" id="compareCheck" />
                                                <label class="form-check-label" for="compareCheck">Compare to</label>
                                            </div> --}}

                                            {{-- <input type="text" class="form-control w-auto" id="comparisonDate"
                                                placeholder="Comparison Date" disabled /> --}}

                                            {{-- <button class="btn btn-primary waves-effect waves-light mx-auto">Update
                                                Chart</button> --}}
                                        </div>
                                    </div>

                                    <hr class="my-3" />

                                    <!-- === Parameter Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2">
                                            <label class="form-label fw-semibold mb-0">Select a Parameter:</label>
                                        </div>
                                        <div class="col-md-10 d-flex flex-wrap align-items-center gap-4">
                                            <div class="btn-group flex-wrap" role="group"
                                                aria-label="Parameter Buttons" id="paramButtons">
                                                <ul class="nav nav-pills">
                                                    <style>
                                                        .nav-item {
                                                            /* Button spacing */
                                                            border-radius: 6px;
                                                            /* Rounded edges */
                                                            margin-right: 6px;
                                                        }

                                                        .nav-item .param {
                                                            border: 1px solid #7367F0;
                                                        }
                                                    </style>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light active"
                                                            data-param="VLN">LN Voltage</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="VLL">LL Voltage</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="Current">Current</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="Active">Active</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="Reactive">Reactive</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="Apparent">Apparent</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="PF">Power Factor</button>
                                                    </li>

                                                </ul>
                                            </div>

                                            <span class="vr mx-3"></span>

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

                                    <hr class="my-3" />

                                    <!-- === Time Interval Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2">
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

                                            {{-- <div class="form-check ms-auto">
                                                <input class="form-check-input" type="checkbox" id="showTemperature" />
                                                <label class="form-check-label" for="showTemperature">Show
                                                    Temperature</label>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chart -->
                        <div class="card mt-6">
                            {{-- <h5 class="card-header">Delete Account</h5> --}}
                            <div class="card-body p-0">
                                <style>
                                    body {
                                        font-family: "Inter", sans-serif;
                                        background: #f8f9fa;
                                        /* padding: 20px; */
                                    }

                                    #Chart {
                                        width: 100%;
                                        height: 447px;
                                        background: #fff;
                                        border-radius: 8px;
                                        /* box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); */
                                        padding: 10px;
                                    }
                                </style>
                                <div id="Chart" style="height: 515px; width: 100%;"></div>

                                {{-- <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const chartDom = document.getElementById('Chart');
                                        const myChart = echarts.init(chartDom);

                                        // 🔹 Generate timeline dynamically (based on interval in minutes)
                                        let selectedInterval = 5; // default 5 minute
                                        let fullChart = generateFullChart(selectedInterval);

                                        function generateFullChart(interval = 5) {
                                            const times = [];
                                            for (let h = 0; h < 24; h++) {
                                                for (let m = 0; m < 60; m += interval) {
                                                    const hh = h.toString().padStart(2, '0');
                                                    const mm = m.toString().padStart(2, '0');
                                                    times.push(`${hh}:${mm}`);
                                                }
                                            }
                                            return times;
                                        }

                                        // 🔹 Determine parameters
                                        function getParameters(paramType) {
                                            const systemType = document.querySelector('input[name="systemTypeRealtime"]:checked').value;
                                            let params = [];

                                            if (systemType === 'system') {
                                                switch (paramType) {
                                                    case 'VLN':
                                                        params = ['Vnavg_V'];
                                                        break;
                                                    case 'VLL':
                                                        params = ['Vlavg_V'];
                                                        break;
                                                    case 'Current':
                                                        params = ['Iavg_A'];
                                                        break;
                                                    case 'Active':
                                                        params = ['Psum_kW'];
                                                        break;
                                                    case 'Reactive':
                                                        params = ['Qsum_kvar'];
                                                        break;
                                                    case 'Apparent':
                                                        params = ['Ssum_kVA'];
                                                        break;
                                                    case 'PF':
                                                        params = ['PF'];
                                                        break;
                                                }
                                            } else {
                                                switch (paramType) {
                                                    case 'VLN':
                                                        params = ['V1', 'V2', 'V3'];
                                                        break;
                                                    case 'VLL':
                                                        params = ['V12', 'V23', 'V31'];
                                                        break;
                                                    case 'Current':
                                                        params = ['I1', 'I2', 'I3'];
                                                        break;
                                                    case 'Active':
                                                        params = ['P1', 'P2', 'P3'];
                                                        break;
                                                    case 'Reactive':
                                                        params = ['Q1', 'Q2', 'Q3'];
                                                        break;
                                                    case 'Apparent':
                                                        params = ['S1', 'S2', 'S3'];
                                                        break;
                                                    case 'PF':
                                                        params = ['PF1', 'PF2', 'PF3'];
                                                        break;
                                                }
                                            }
                                            return params;
                                        }

                                        // === Fetch data ===
                                        function fetchData(params) {
                                            if (!params.length) return;

                                            const query = params.map(p => `parameters[]=${p}`).join('&');
                                            const url = `http://127.0.0.1:8000/api/v1/data/today?${query}`;

                                            fetch(url)
                                                .then(res => res.json())
                                                .then(data => {
                                                    if (!data.length) {
                                                        myChart.setOption({
                                                            series: [],
                                                            xAxis: {
                                                                data: []
                                                            },
                                                            legend: {
                                                                data: []
                                                            }
                                                        }, true);
                                                        return;
                                                    }

                                                    // 🔹 Create lookup for quick access
                                                    const lookup = {};
                                                    data.forEach(d => {
                                                        // Normalize time format to HH:MM (even if API returns HH:MM:SS or full timestamp)
                                                        const timeKey = d.time.slice(-5);
                                                        lookup[timeKey] = d;
                                                    });

                                                    // 🔹 Align data values to full 1-minute timeline (fill missing time with null)
                                                    const series = params.map(p => ({
                                                        name: p,
                                                        type: 'line',
                                                        smooth: true,
                                                        symbol: 'circle',
                                                        symbolSize: 6,
                                                        data: fullChart.map(time => lookup[time] ? lookup[time][p] : null),
                                                        lineStyle: {
                                                            width: 2,
                                                            color: randomColor(p)
                                                        },
                                                        itemStyle: {
                                                            color: randomColor(p)
                                                        }
                                                    }));

                                                    // 🔹 Calculate Y range safely
                                                    const allY = series.flatMap(s => s.data.filter(v => v !== null));
                                                    const yMin = allY.length ? Math.min(...allY) : 0;
                                                    const yMax = allY.length ? Math.max(...allY) : 1;
                                                    const yMargin = (yMax - yMin) * 0.1;

                                                    // 🔹 Apply chart options
                                                    myChart.setOption({
                                                        title: {
                                                            text: `${params.join(', ')} (Today)`,
                                                            left: 'center',
                                                            textStyle: {
                                                                fontSize: 14,
                                                                fontWeight: 'normal'
                                                            }
                                                        },
                                                        tooltip: {
                                                            trigger: 'axis'
                                                        },
                                                        grid: {
                                                            left: '1%',
                                                            right: '5%',
                                                            bottom: '15%',
                                                            top: '10%',
                                                            containLabel: true
                                                        },
                                                        xAxis: {
                                                            type: 'category',
                                                            boundaryGap: false,
                                                            data: fullChart,
                                                            name: 'Time',
                                                            nameGap: 30
                                                        },
                                                        yAxis: {
                                                            type: 'value',
                                                            splitLine: {
                                                                show: true,
                                                                lineStyle: {
                                                                    color: '#eee'
                                                                }
                                                            },
                                                            min: parseFloat((yMin - yMargin).toFixed(2)),
                                                            max: parseFloat((yMax + yMargin).toFixed(2))
                                                        },
                                                        dataZoom: [{
                                                                type: 'slider',
                                                                show: true,
                                                                xAxisIndex: [0],
                                                                bottom: 5,
                                                                height: 20
                                                            },
                                                            {
                                                                type: 'inside',
                                                                xAxisIndex: [0]
                                                            }
                                                        ],
                                                        toolbox: {
                                                            feature: {
                                                                saveAsImage: {
                                                                    title: 'Download'
                                                                },
                                                                dataZoom: {
                                                                    title: {
                                                                        zoom: 'Zoom',
                                                                        back: 'Reset'
                                                                    }
                                                                }
                                                            },
                                                            right: 20
                                                        },
                                                        legend: {
                                                            top: 25,
                                                            data: params
                                                        },
                                                        series: series
                                                    }, true);
                                                })

                                                .catch(err => console.error('Error fetching data:', err));
                                        }

                                        // 🔹 Button click handler
                                        document.querySelectorAll('#paramButtons button').forEach(button => {
                                            button.addEventListener('click', function() {
                                                const paramType = this.dataset.param;
                                                document.querySelectorAll('#paramButtons button').forEach(btn => btn.classList
                                                    .remove('active'));
                                                this.classList.add('active');
                                                const params = getParameters(paramType);
                                                fetchData(params);
                                            });
                                        });

                                        // 🔹 System/Phase change handler
                                        document.querySelectorAll('input[name="systemTypeRealtime"]').forEach(radio => {
                                            radio.addEventListener('change', () => {
                                                const activeBtn = document.querySelector('#paramButtons .active');
                                                if (activeBtn) {
                                                    const paramType = activeBtn.dataset.param;
                                                    const params = getParameters(paramType);
                                                    fetchData(params);
                                                }
                                            });
                                        });

                                        // 🔹 Interval selection handler (styled like paramButtons logic)
                                        const intervalSelect = document.getElementById('intervalSelect');
                                        if (intervalSelect) {
                                            intervalSelect.addEventListener('change', function() {
                                                const intervalValue = parseInt(this.value);

                                                // update interval value
                                                selectedInterval = intervalValue;
                                                fullChart = generateFullChart(selectedInterval);

                                                // visually indicate selection (optional)
                                                // console.log(`Interval set to ${intervalValue} minute(s)`);

                                                // determine which parameter is currently active
                                                const activeBtn = document.querySelector('#paramButtons .active');
                                                let params;

                                                if (activeBtn) {
                                                    const paramType = activeBtn.dataset.param;
                                                    params = getParameters(paramType);
                                                } else {
                                                    params = getParameters('VLN'); // fallback if nothing selected
                                                }

                                                // re-fetch data based on the same parameter but new interval
                                                fetchData(params);
                                            });
                                        }

                                        // 🔹 Colors simplified
                                        function randomColor(param) {
                                            const phaseR = ['V1', 'V12', 'I1', 'P1', 'Q1', 'S1', 'PF1'];
                                            const phaseS = ['V2', 'V23', 'I2', 'P2', 'Q2', 'S2', 'PF2'];
                                            const phaseT = ['V3', 'V31', 'I3', 'P3', 'Q3', 'S3', 'PF3'];
                                            const system = ['Vnavg_V', 'Vlavg_V', 'Iavg_A', 'Psum_kW', 'Qsum_kvar', 'Ssum_kVA', 'PF'];

                                            if (phaseR.includes(param)) return '#FF4560'; // 🔴 Red
                                            if (phaseS.includes(param)) return '#FEB019'; // 🟡 Yellow
                                            if (phaseT.includes(param)) return '#008FFB'; // 🔵 Blue
                                            if (system.includes(param)) return '#7367F0'; // 🟣 Violet (System)
                                            return '#FFA500'; // 🟠 Default fallback (Orange)
                                        }

                                        // 🔹 Load default
                                        const defaultParams = getParameters('VLN');
                                        fetchData(defaultParams);

                                        window.addEventListener('resize', () => myChart.resize());
                                    });
                                </script> --}}

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const chartDom = document.getElementById('Chart');
                                        const myChart = echarts.init(chartDom);

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
                                                    const firstDay = today.getDate() - today.getDay();
                                                    start = new Date(today.setDate(firstDay));
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
                                            const activeBtn = document.querySelector('#paramButtons .active');
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
                                                    VLN: [{
                                                        key: 'Vnavg_V',
                                                        label: 'System Average Line-to-Neutral Voltage'
                                                    }],
                                                    VLL: [{
                                                        key: 'Vlavg_V',
                                                        label: 'System Average Line-to-Line Voltage'
                                                    }],
                                                    Current: [{
                                                        key: 'Iavg_A',
                                                        label: 'System Average Current'
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

                                            if (firstKey.startsWith('V')) return 'V';
                                            if (firstKey.startsWith('I')) return 'A';
                                            if (firstKey.startsWith('Psum') || firstKey.startsWith('P')) return 'kW';
                                            if (firstKey.startsWith('Qsum') || firstKey.startsWith('Q')) return 'kVAR';
                                            if (firstKey.startsWith('Ssum') || firstKey.startsWith('S')) return 'kVA';
                                            if (firstKey.startsWith('PF')) return 'PF';

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
                                            const system = ['Vnavg_V', 'Vlavg_V', 'Iavg_A', 'Psum_kW', 'Qsum_kvar', 'Ssum_kVA', 'PF'];

                                            if (phaseR.includes(param)) return '#FF4560';
                                            if (phaseS.includes(param)) return '#FEB019';
                                            if (phaseT.includes(param)) return '#008FFB';
                                            if (system.includes(param)) return '#7367F0';
                                            return '#FFA500';
                                        }

                                        // =========================================================
                                        // 5️⃣ FETCH API DATA
                                        // =========================================================

                                        async function fetchChartData(params, start, end) {
                                            if (!params.length) return [];

                                            // const queryParams = params.map(p => `parameters[]=${p}`).join('&');
                                            const queryParams = params.map(p => `parameters[]=${p.key}`).join('&');

                                            let url = "";

                                            const startDate = start.toISOString().split('T')[0];
                                            const endDate = end.toISOString().split('T')[0];

                                            // ✅ If only 1 day (Today or Yesterday)
                                            if (startDate === endDate) {
                                                url = `http://127.0.0.1:8000/api/v1/data?date=${startDate}&${queryParams}`;
                                            }
                                            // ✅ If multi-day range (Custom or This Week)
                                            else {
                                                url =
                                                    `http://127.0.0.1:8000/api/v1/data?start_date=${startDate}&end_date=${endDate}&${queryParams}`;
                                            }

                                            // console.log("API Request:", url); // ← See it in browser console

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
                                        function renderChart(timeAxis, series, params) {
                                            const allValues = series.flatMap(s => s.data.filter(v => v !== null));
                                            const yMin = allValues.length ? Math.min(...allValues) : 0;
                                            const yMax = allValues.length ? Math.max(...allValues) : 1;
                                            const yMargin = (yMax - yMin) * 0.1;

                                            myChart.setOption({
                                                title: {
                                                    // text: `${params.join(', ')} (Today)`,
                                                    left: 'center'
                                                },
                                                tooltip: {
                                                    trigger: 'axis'
                                                },
                                                legend: {
                                                    type: 'plain', // 'plain' or 'scroll' for many items
                                                    orient: 'horizontal', // 'horizontal' or 'vertical'
                                                    top: 20, // Position from top
                                                    left: 20, // 'left' | 'right' | 'center' | 'number'
                                                    // left: 'left', // 'left' | 'right' | 'center' | 'number'
                                                    data: params.map(p => p.label), // ✅ Show readable names
                                                },
                                                grid: {
                                                    left: '2%',
                                                    right: '5%',
                                                    top: '15%',
                                                    bottom: '15%',
                                                    containLabel: true
                                                },
                                                xAxis: {
                                                    type: 'category',
                                                    boundaryGap: false,
                                                    data: timeAxis
                                                },
                                                yAxis: {
                                                    name: getYAxisLabel(params), // ✅ Dynamic label here
                                                    nameTextStyle: {
                                                        fontWeight: 'bold', // ✅ Make it bold
                                                        fontSize: 14 // (optional) adjust size
                                                    },
                                                    type: 'value',
                                                    axisLine: {
                                                        show: true, // ✅ Show the Y-axis vertical line
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
                                                dataZoom: [{
                                                    type: 'slider',
                                                    bottom: 5
                                                }, {
                                                    type: 'inside'
                                                }],
                                                toolbox: {
                                                    itemSize: 24, // ✅ Default is 15 — increase to make icons bigger
                                                    feature: {
                                                        saveAsImage: {
                                                            title: 'Download'
                                                        },
                                                        dataZoom: {
                                                            title: {
                                                                zoom: 'Zoom',
                                                                back: 'Reset'
                                                            },
                                                            yAxisIndex: false // ✅ Disable zoom for Y-axis inside toolbox
                                                        }
                                                    },
                                                    right: 20
                                                },
                                            }, true);
                                        }

                                        // =========================================================
                                        // 🔄 MAIN CONTROL FUNCTION
                                        // =========================================================
                                        async function updateChart() {
                                            const range = getSelectedDateRange();
                                            if (!range) return;

                                            const {
                                                start,
                                                end
                                            } = range;
                                            const interval = getSelectedInterval();
                                            const timeAxis = generateTimeAxis(start, end, interval);
                                            const params = getSelectedParams();

                                            // ✅ Pass start & end to API
                                            const apiData = await fetchChartData(params, start, end);

                                            const series = buildSeriesData(apiData, timeAxis, params);
                                            renderChart(timeAxis, series, params);
                                        }

                                        // =========================================================
                                        // EVENT LISTENERS
                                        // =========================================================
                                        // 📌 Show/Hide Custom Date Inputs
                                        document.getElementById('dateRangeSelect').addEventListener('change', function() {
                                            const isCustom = this.value === 'custom';
                                            document.getElementById('startDate').classList.toggle('d-none', !isCustom);
                                            document.getElementById('endDate').classList.toggle('d-none', !isCustom);

                                            if (this.value !== 'custom') {
                                                updateChart();
                                            }
                                        });

                                        // If custom date is selected, trigger chart update when both dates picked
                                        ['startDate', 'endDate'].forEach(id => {
                                            document.getElementById(id).addEventListener('change', function() {
                                                const range = getSelectedDateRange();
                                                if (range) updateChart();
                                            });
                                        });

                                        document.querySelectorAll('#paramButtons button').forEach(btn => {
                                            btn.addEventListener('click', () => {
                                                document.querySelectorAll('#paramButtons button').forEach(b => b.classList
                                                    .remove('active'));
                                                btn.classList.add('active');
                                                updateChart();
                                            });
                                        });

                                        document.querySelectorAll('input[name="systemTypeRealtime"]').forEach(r => {
                                            r.addEventListener('change', updateChart);
                                        });

                                        const intervalSelect = document.getElementById('intervalSelect');
                                        if (intervalSelect) intervalSelect.addEventListener('change', updateChart);

                                        window.addEventListener('resize', () => myChart.resize());

                                        // ✅ Load Chart First Time
                                        updateChart();
                                    });
                                </script>


                            </div>
                        </div>
                    </div>

                    <!-- Heatmap -->
                    <div class="tab-pane fade" id="heatmap" role="tabpanel" aria-labelledby="heatmap-tab">
                        <div class="card border-0 shadow-none">
                            <h5 class="fw-bold mb-2">
                                <i class="ti ti-flame me-1"></i> Heatmap Visualization
                            </h5>
                            <p class="text-muted mb-0">
                                Color-coded temperature or load intensity mapping.
                            </p>
                        </div>
                    </div>

                    <!-- Demand -->
                    <div class="tab-pane fade" id="demand" role="tabpanel" aria-labelledby="demand-tab">
                        <div class="card border-0 shadow-none">
                            <h5 class="fw-bold mb-2">
                                <i class="ti ti-trending-up me-1"></i> Demand Analysis
                            </h5>
                            <p class="text-muted mb-0">
                                Displays peak demand and usage comparison.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
