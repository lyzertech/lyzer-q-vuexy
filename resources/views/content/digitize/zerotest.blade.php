@extends('base.0layout')

@section('title', 'Labs')

@section('link')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('zone-link')
    <!-- Optional: jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="sneat/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Optional: Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection

@section('content')
    <style>
        table thead tr{
            background-color: #ffffff;
        }
        /* Odd rows - light gray */
        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Even rows - white */
        table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Optional: Hover effect */
        table tbody tr:hover {
            background-color: #e6f7ff;
        }
    </style>

    <div class="flex-grow-1 container-p-y container-fluid">
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-12">
                <table id="realtimeTable" class="table table-bordered display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Phase A</th>
                            <th>Phase B</th>
                            <th>Phase C</th>
                            <th>Average</th>
                            <th>System</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Line-to-Neutral Voltage (V)</td>
                            <td>230.010</td>
                            <td>230.010</td>
                            <td>230.010</td>
                            <td>230.010</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Line-to-Line Voltage (V)</td>
                            <td>398.397</td>
                            <td>398.370</td>
                            <td>398.397</td>
                            <td>398.388</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Current (A)</td>
                            <td>5.000</td>
                            <td>5.000</td>
                            <td>5.000</td>
                            <td>5.000</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Active Power (kW)</td>
                            <td>1.150</td>
                            <td>1.150</td>
                            <td>1.150</td>
                            <td>-</td>
                            <td>3.450</td>
                        </tr>
                        <tr>
                            <td>Reactive Power (kVar)</td>
                            <td>0.000</td>
                            <td>0.000</td>
                            <td>0.000</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Frequency (Hz)</td>
                            <td>59.999</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Session</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2" id="FValue"></h4>
                                    <small class="text-success" id="FValuediff"></small>
                                </div>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-user bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Session</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2" id="U1Value"></h4>
                                    <small class="text-success" id="U1Valuediff"></small>
                                </div>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-user bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Function to fetch data from the API
                function fetchMeteringData() {
                    const apiUrl = 'http://127.0.0.1:8000/api/v1/metering';

                    fetch(apiUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json(); // Parse the JSON response
                        })
                        .then(data => {
                            // Sort the data by the 'created_at' field in descending order (latest first)
                            const sortedData = data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                            // Get the 2 latest entries
                            const latestData = sortedData.slice(0, 2);

                            // Extract values from the latest 2 entries
                            const fields = [
                                'F', 'U1', 'U2', 'U3', 'Uavg', 'U12', 'U23', 'U31', 'Ulavg',
                                'IL1', 'IL2', 'IL3', 'Iavg', 'In', 'Pa', 'Pb', 'Pc', 'Psum',
                                'Qa', 'Qb', 'Qc', 'Qsum', 'Sa', 'Sb', 'Sc', 'Ssum', 'PFa',
                                'PFb', 'PFc', 'PFsum', 'U_unbl', 'I_unbl', 'LCR', 'P_Dmd',
                                'Q_Dmd', 'S_Dmd', 'I1_Dmd', 'I2_Dmd', 'I3_Dmd', 'Ep_Imp',
                                'Ep_Exp', 'Eq_Imp', 'Eq_Exp', 'Ep_sum', 'Ep_net', 'Eq_sum',
                                'Eq_net', 'Es', 'Epa_Imp', 'Epa_Exp', 'Epb_Imp', 'Epb_Exp',
                                'Epc_Imp', 'Epc_Exp', 'Eqa_Imp', 'Eqa_Exp', 'Eqb_Imp', 'Eqb_Exp',
                                'Eqc_Imp', 'Eqc_Exp', 'Esa', 'Esb', 'Esc', 'PhsAngV2toV1',
                                'PhsAngV3toV1', 'PhsAngI1toV1', 'PhsAngI2toV1', 'PhsAngI3toV1'
                            ];

                            // Extract values from the latest 2 entries for each field
                            const latestValues = {};
                            fields.forEach(field => {
                                latestValues[field] = latestData.map(item => item[field]);
                            });

                            // Log the values to the console for debugging
                            console.log('Latest Values:', latestValues);

                            // Display the extracted values in the elements
                            Object.keys(latestValues).forEach(field => {
                                const fieldElement = document.getElementById(field + 'Value');
                                if (fieldElement) {
                                    fieldElement.textContent = `${field}: ${latestValues[field].join(', ')}`;
                                }
                            });

                            // Calculate and display percentage differences for selected fields
                            const calculatePercentageDiff = (latest, previous) => {
                                if (previous !== 0) {
                                    return ((latest - previous) / previous) * 100;
                                }
                                return 0;
                            };

                            const percentageDiffs = {};
                            fields.forEach(field => {
                                const latestValue = latestValues[field][0];
                                const previousValue = latestValues[field][1];
                                percentageDiffs[field] = calculatePercentageDiff(latestValue, previousValue);
                            });

                            // Display percentage differences for fields where applicable
                            Object.keys(percentageDiffs).forEach(field => {
                                const diffElement = document.getElementById(field + 'Valuediff');
                                if (diffElement) {
                                    diffElement.textContent = `${percentageDiffs[field].toFixed(2)}%`;
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            document.getElementById('freq').textContent = 'Error fetching data: ' + error.message;
                        });
                }

                // Call the function once when the page loads
                fetchMeteringData();

                // Set interval to fetch data every 5 seconds (5000 milliseconds)
                setInterval(fetchMeteringData, 5000); // Fetch data every 5 seconds
            </script>


        </div>
        <div class="row">
            <div id="Area Chart with Time Axis" style="width: 600px;height:400px;"></div>
            <div id="Stacked Line Chart" style="width: 900px;height:400px;"></div>
            <div id="LineRace" style="width: 900px;height:400px;"></div>

            <script>
                var chartDom = document.getElementById('Area Chart with Time Axis');
                var myChart = echarts.init(chartDom);
                var option;

                let base = +new Date(1988, 9, 3);
                let oneDay = 24 * 3600 * 1000;
                let data = [
                    [base, Math.random() * 300]
                ];
                for (let i = 1; i < 20000; i++) {
                    let now = new Date((base += oneDay));
                    data.push([+now, Math.round((Math.random() - 0.5) * 20 + data[i - 1][1])]);
                }
                option = {
                    tooltip: {
                        trigger: 'axis',
                        position: function(pt) {
                            return [pt[0], '10%'];
                        }
                    },
                    title: {
                        left: 'center',
                        text: 'Large Ara Chart'
                    },
                    toolbox: {
                        feature: {
                            dataZoom: {
                                yAxisIndex: 'none'
                            },
                            restore: {},
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'time',
                        boundaryGap: false
                    },
                    yAxis: {
                        type: 'value',
                        boundaryGap: [0, '100%']
                    },
                    dataZoom: [{
                            type: 'inside',
                            start: 0,
                            end: 20
                        },
                        {
                            start: 0,
                            end: 20
                        }
                    ],
                    series: [{
                        name: 'Fake Data',
                        type: 'line',
                        smooth: true,
                        symbol: 'none',
                        areaStyle: {},
                        data: data
                    }]
                };

                option && myChart.setOption(option);
            </script>

            <script>
                var chartDom = document.getElementById('Stacked Line Chart');
                var myChart = echarts.init(chartDom);
                var option;

                option = {
                    title: {
                        text: 'Stacked Line'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                            name: 'Email',
                            type: 'line',
                            stack: 'Total',
                            data: [120, 132, 101, 134, 90, 230, 210]
                        },
                        {
                            name: 'Union Ads',
                            type: 'line',
                            stack: 'Total',
                            data: [220, 182, 191, 234, 290, 330, 310]
                        },
                        {
                            name: 'Video Ads',
                            type: 'line',
                            stack: 'Total',
                            data: [150, 232, 201, 154, 190, 330, 410]
                        },
                        {
                            name: 'Direct',
                            type: 'line',
                            stack: 'Total',
                            data: [320, 332, 301, 334, 390, 330, 320]
                        },
                        {
                            name: 'Search Engine',
                            type: 'line',
                            stack: 'Total',
                            data: [820, 932, 901, 934, 1290, 1330, 1320]
                        }
                    ]
                };

                option && myChart.setOption(option);
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var chartDom = document.getElementById('LineRace');
                    var myChart = echarts.init(chartDom);
                    var option;

                    // Fetch the data from the local JSON file
                    $.get('/data/asset/data/life-expectancy-table.json', function(_rawData) {
                        run(_rawData);
                    });

                    function run(_rawData) {
                        const countries = [
                            'Finland', 'France', 'Germany', 'Iceland',
                            'Norway', 'Poland', 'Russia', 'United Kingdom'
                        ];

                        const datasetWithFilters = [];
                        const seriesList = [];
                        echarts.util.each(countries, function(country) {
                            var datasetId = 'dataset_' + country;
                            datasetWithFilters.push({
                                id: datasetId,
                                fromDatasetId: 'dataset_raw',
                                transform: {
                                    type: 'filter',
                                    config: {
                                        and: [{
                                                dimension: 'Year',
                                                gte: 1950
                                            },
                                            {
                                                dimension: 'Country',
                                                '=': country
                                            }
                                        ]
                                    }
                                }
                            });
                            seriesList.push({
                                type: 'line',
                                datasetId: datasetId,
                                showSymbol: false,
                                name: country,
                                endLabel: {
                                    show: true,
                                    formatter: function(params) {
                                        return params.value[3] + ': ' + params.value[0];
                                    }
                                },
                                labelLayout: {
                                    moveOverlap: 'shiftY'
                                },
                                emphasis: {
                                    focus: 'series'
                                },
                                encode: {
                                    x: 'Year',
                                    y: 'Income',
                                    label: ['Country', 'Income'],
                                    itemName: 'Year',
                                    tooltip: ['Income']
                                }
                            });
                        });

                        option = {
                            animationDuration: 10000,
                            dataset: [{
                                    id: 'dataset_raw',
                                    source: _rawData
                                },
                                ...datasetWithFilters
                            ],
                            title: {
                                text: 'Income of Germany and France since 1950'
                            },
                            tooltip: {
                                order: 'valueDesc',
                                trigger: 'axis'
                            },
                            xAxis: {
                                type: 'category',
                                nameLocation: 'middle'
                            },
                            yAxis: {
                                name: 'Income'
                            },
                            grid: {
                                right: 140
                            },
                            series: seriesList
                        };

                        myChart.setOption(option);
                    }

                    option && myChart.setOption(option);
                });
            </script>
        </div>

    </div>
@endsection
