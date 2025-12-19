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
    <div class="border-end container-p-x container-p-y" style="width: 400px; flex-shrink: 0;">
        <div class="layout-example-sidebar layout-example-content-inner">
            <!-- Checkbox -->
            <div class="col-md-12 col-12">
                <div class="card mb-md-0 mb-6">
                    <h5 class="card-header">Datalog</h5>
                    <div class="card-body px-4">
                        <div id="tree"></div>

                    </div>
                </div>
            </div>

            <!-- /Checkbox -->
        </div>
    </div>

    <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
        <div class="row">
            <div class="col-md-12">
                {{-- @include('content.digitize.monitoring.monitoring-analysis-nav') --}}

                <!-- Tabs Content -->
                <div class="tab-content mt-4 p-0" id="energyTabsContent">
                    <!-- Realtime -->
                    <div class="tab-pane fade show active" id="realtime" role="tabpanel" aria-labelledby="realtime-tab">
                        <h5 class="fw-bold mb-2">
                            <i class="ti ti-activity me-1"></i> Datalog Table
                        </h5>
                        <p class="text-muted mb-0">
                            Time-stamped datalog tables for accurate historical data analysis.
                        </p>
                        <div class="tab-pane fade show active" id="realtime" role="tabpanel" aria-labelledby="energy-tab">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <!-- === Time Frame Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2 my-3">
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
                                        </div>
                                    </div>

                                    <hr class="my-3" />

                                    <!-- === Parameter Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2 my-3">
                                            <label class="form-label fw-semibold mb-0">Select a Parameter:</label>
                                        </div>
                                        <div class="col-md-10 d-flex flex-wrap align-items-center gap-4">
                                            <div class="btn-group flex-wrap" role="group" aria-label="Parameter Buttons"
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

                                    <hr class="my-3" />

                                    <!-- === Time Interval Selection === -->
                                    <div class="row align-items-center mb-3">
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div class="card mt-6">
                            <div class="card-body p-0">
                                <style>
                                    body {
                                        font-family: "Inter", sans-serif;
                                        background: #f8f9fa;
                                        /* padding: 20px; */
                                    }

                                    #Chart {
                                        width: 100%;
                                        height: 100%;
                                        background: #fff;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                                        padding: 10px;
                                    }
                                </style>
                                <div id="Chart" style="width: 100%; height: 505px;"></div>

                            </div>
                        </div>

                    </div>


                </div>

            </div>
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

    <script>
        window.APP_URL = "{{ config('app.url') }}";
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chartDom = document.getElementById('Chart');
            const myChart = echarts.init(chartDom);

            // ✅ 1. Call JsTree API
            $.getJSON('/monitoring/analysis/data', function(data) {
                $('#tree').jstree({
                    core: {
                        themes: {
                            name: 'default' // Set a valid theme name
                        },
                        data: data
                    },
                    plugins: ['types',
                        // 'checkbox',
                        'wholerow'
                    ],
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
            $('#tree').on('ready.jstree', function() {
                // console.log("✅ jsTree Loaded");
            });

            // ✅ 3. Detect device selection
            $('#tree').on('click.jstree', '.jstree-anchor', function(e) {
                const tree = $('#tree').jstree(true);
                const node = tree.get_node(this);

                tree.toggle_node(node);
            });

            $('#tree').on('select_node.jstree', function(e, data) {
                if (data.node.id.startsWith('model_')) {
                    updateChart();
                }
            });

            // ✅ 4. Safe function to get selected device
            function getSelectedDevice() {
                const tree = $('#tree').jstree(true);
                if (!tree || typeof tree.get_selected !== 'function') return null;

                const selected = tree.get_selected(true);
                if (selected.length > 0) {
                    const node = selected[0];
                    if (node.type === 'file' || node.id.startsWith('model_')) {
                        // console.log("DEVICE NAME FOUND >>>", node.text);
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
                const deviceName = getSelectedDevice();

                myChart.clear(); // ✅ Remove all old series, axes, zoom, events
                myChart.setOption({
                    title: {
                        text: deviceName,
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'axis',
                        // axisPointer: {
                        //     type: 'line'
                        // },
                        formatter: function(items) {
                            // items = array of data points (ECharts format)

                            const unit = getYAxisLabel(params); // 👈 use your existing logic

                            let html = `${items[0].axisValue}<br/>`;

                            items.forEach(p => {
                                const value = (p.value !== null) ?
                                    Number(p.value).toFixed(2) :
                                    '0.00';

                                html += `${p.marker} ${p.seriesName}: ${value} ${unit}<br/>`;
                            });

                            return html;
                        }
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
                                // title: {
                                //     zoom: 'Zoom',
                                //     back: 'Reset'
                                // },
                                yAxisIndex: false // ✅ Disable zoom for Y-axis inside toolbox
                            },
                            // ✅ Add Data View
                            dataView: {
                                title: 'Data View',
                                readOnly: true,
                                optionToContent: function(opt) {
                                    const axisData = opt.xAxis[0].data;
                                    const series = opt.series;

                                    // Device name
                                    const device = getSelectedDevice() || "Unknown Device";

                                    // Parameter & unit
                                    const paramName = series[0]?.name || "Parameter";
                                    const unit = getYAxisLabel(params) || "";

                                    // Build table with title + 2 decimals
                                    let html = `
                                          <button id="downloadCSV" style="margin-bottom:8px;">Download CSV</button>

                                          <table border="1" style="width:100%;text-align:center;border-collapse:collapse;">
                                              <tr>
                                                  <th colspan="${series.length + 1}" style="background:#f2f2f2;">
                                                      Device: ${device}
                                                  </th>
                                              </tr>
                                              <tr>
                                                  <th colspan="${series.length + 1}" style="background:#f9f9f9;">
                                                      Parameter: ${paramName} (${unit})
                                                  </th>
                                              </tr>

                                              <tr>
                                                  <th>Time</th>
                                      `;

                                    series.forEach(s => {
                                        html += `<th>${s.name} (${unit})</th>`;
                                    });

                                    html += `</tr>`;

                                    axisData.forEach((time, i) => {
                                        html += `<tr><td>${time}</td>`;

                                        series.forEach(s => {
                                            let val = s.data[i];
                                            let formatted = (val != null && !isNaN(
                                                    val)) ? Number(val).toFixed(2) :
                                                'null';
                                            html += `<td>${formatted}</td>`;
                                        });

                                        html += `</tr>`;
                                    });

                                    html += `</table>`;

                                    // CSV Export (also 2 decimals)
                                    setTimeout(() => {
                                        document.getElementById('downloadCSV').onclick =
                                            function() {
                                                let csv = "";

                                                // Metadata
                                                csv += `Device,${device}\n`;
                                                csv += `Parameter,${paramName} (${unit})\n\n`;

                                                // Header
                                                csv += 'Time,' + series.map(s =>
                                                    `${s.name} (${unit})`).join(',') + '\n';

                                                // Rows
                                                axisData.forEach((time, i) => {
                                                    const row = series.map(s => {
                                                        let val = s.data[i];
                                                        return (val != null && !
                                                                isNaN(val)) ?
                                                            Number(val).toFixed(
                                                                2) : 'null';
                                                    });
                                                    csv += time + ',' + row.join(',') +
                                                        '\n';
                                                });

                                                // Download
                                                const blob = new Blob([csv], {
                                                    type: 'text/csv'
                                                });
                                                const url = URL.createObjectURL(blob);

                                                const a = document.createElement('a');
                                                a.href = url;
                                                a.download =
                                                    `data_${device.replace(/\s+/g,'_')}.csv`;
                                                a.click();
                                                URL.revokeObjectURL(url);
                                            };
                                    });

                                    return html;
                                }
                            },
                            restore: {
                                title: 'Restore' // ✅ Add the restore feature
                            }
                        },
                        right: 20
                    },
                }, true);
            }

            // =========================================================
            // 🔄 MAIN CONTROL FUNCTION
            // =========================================================

            function getCommonChartInputs() {
                const deviceName = getSelectedDevice();
                if (!deviceName) return null;

                const range = getSelectedDateRange();
                if (!range) return null;

                const {
                    start,
                    end
                } = range;
                const interval = getSelectedInterval();
                const timeAxis = generateTimeAxis(start, end, interval);

                return {
                    deviceName,
                    start,
                    end,
                    interval,
                    timeAxis
                };
            }

            async function updateChart() {
                const input = getCommonChartInputs();
                if (!input) return;

                const {
                    deviceName,
                    start,
                    end,
                    interval,
                    timeAxis
                } = input;

                const params = getSelectedParams();

                // ✅ Pass start & end to API
                const apiData = await fetchChartData(params, start, end, deviceName);

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

                // If not custom, update chart directly
                if (!isCustom) {
                    updateChart();
                }
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
                    if (range) updateChart();
                });
            });

            document.querySelectorAll('#paramButtonsRealtime button').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('#paramButtonsRealtime button').forEach(b => b
                        .classList
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


@endsection
