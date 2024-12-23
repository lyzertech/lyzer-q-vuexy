@extends('base.1layout')

@section('title', 'Monitoring')

@section('link')
    <script src="vendor/echarts.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="sneat/assets/vendor/libs/flatpickr/flatpickr.css">
    <link rel="stylesheet" href="sneat/assets/vendor/css/pages/app-calendar.css">
    <link rel="stylesheet" href="sneat/assets/vendor/libs/jstree/jstree.css">

@endsection

@section('zone-link')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="sneat/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="sneat/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="sneat/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="sneat/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="sneat/assets/vendor/libs/jstree/jstree.js"></script>


    <!-- Page JS -->
    <script src="sneat/assets/js/app-user-list.js"></script>
    <script src="sneat/assets/js/extended-ui-treeview.js"></script>
@endsection

@section('content')

    <div class="flex-grow-1 container-p-y container-fluid">

        {{-- Facility --}}
        <div class="card mb-4">
            <div class="row row-bordered g-0">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <label for="exampleFormControlSelect1" class="form-label" hidden>Example select</label>
                                <select class="form-select" id="exampleFormControlSelect1"
                                    aria-label="Default select example">
                                    <option selected="">Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-8">

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center">
                    <div class="card-body px-xl-9" style="position: relative;">
                        <button type="button" class="btn btn-text-primary">Main System Diagram</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Measurement --}}
        <div class="row">
            <div class="col-xxl-2 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-start row">
                        <div class="col-sm-12">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">List Devices</h5>
                                <div id="jstree">
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#jstree').jstree({
                                            'core': {
                                                "themes": {
                                                    "dots": false, // Disable the dots
                                                },
                                                'data': {!! $treeData !!} // Pass the tree data from the controller
                                            }
                                        });
                                    });
                                </script>

                                <a href="javascript:;" class="mt-4 btn btn-sm btn-label-primary">View Badges</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-10 col-lg-12 col-md-10 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body pb-4">
                                <span class="d-block fw-medium mb-1">Order</span>
                                <h4 class="card-title mb-0">276k</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-4">

                                </div>
                                <p class="mb-1">Sales</p>
                                <h4 class="card-title mb-3">$4,679</h4>
                                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body pb-4">
                                <span class="d-block fw-medium mb-1">Order</span>
                                <h4 class="card-title mb-0">276k</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-4">

                                </div>
                                <p class="mb-1">Sales</p>
                                <h4 class="card-title mb-3">$4,679</h4>
                                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 justify-content-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="card card-border-shadow-primary h-100 text-left">
                            <div class="row">
                                <div class="col-lg-12 px-2">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col-lg-4 pt-1">
                                                <h4>Real-time</h4>
                                            </div>
                                            <div class="col-lg-8">
                                                <ul class="nav nav-pills" role="tablist" id="tabList"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-content" id="tabContent"></div>
                                </div>
                                {{-- <div class="col-lg-3 px-2 mt-4">
                                    <div class="" id="datepicker"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-md-12">
                        <div class="card card-border-shadow-primary h-100 text-left">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col-lg-4 pt-1">
                                        <h4>Energy</h4>
                                    </div>
                                    <div class="col-lg-8 card card-border-shadow-primary h-100">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card">Today</h5>
                                            </div>
                                            <div class="col">
                                                <h5 class="card">Week</h5>
                                            </div>
                                            <div class="col">
                                                <h5 class="card">Month</h5>
                                            </div>
                                            <div class="col">
                                                <h5 class="card">Year</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col" id="energy" style="width: 60vw; height: 50vh;"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>






        <script>
            // Define your tabs here
            const tabs = [{
                    id: 'F',
                    label: 'Freq'
                },
                {
                    id: 'U1',
                    label: 'V1'
                },
                {
                    id: 'U2',
                    label: 'V2'
                },
                {
                    id: 'U3',
                    label: 'V3'
                },
                {
                    id: 'U12',
                    label: 'V12'
                },
                {
                    id: 'U23',
                    label: 'V23'
                },
                {
                    id: 'U31',
                    label: 'V31'
                },
                {
                    id: 'IL1',
                    label: 'I1'
                },
                {
                    id: 'IL2',
                    label: 'I2'
                },
                {
                    id: 'IL3',
                    label: 'I3'
                },
                // Add more tabs as needed
            ];

            const tabList = document.getElementById('tabList');
            const tabContent = document.getElementById('tabContent');

            // Loop to create tabs and corresponding content panes
            tabs.forEach((tab, index) => {
                // Create <li> wrapper
                const listItem = document.createElement('li');
                listItem.className = 'nav-item';
                listItem.role = 'presentation';

                // Create tab button
                const tabButton = document.createElement('button');
                tabButton.type = 'button';
                tabButton.className = `nav-link ${index === 0 ? 'active' : ''}`;
                tabButton.setAttribute('data-bs-toggle', 'tab');
                tabButton.setAttribute('data-bs-target', `#navs-pills-${tab.id}`);
                tabButton.innerText = tab.label;

                listItem.appendChild(tabButton); // Append button to <li>
                tabList.appendChild(listItem); // Append <li> to the tab list

                // Create content pane
                const contentPane = document.createElement('div');
                contentPane.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
                contentPane.id = `navs-pills-${tab.id}`;
                contentPane.innerHTML = `
                <div class="d-flex justify-content-center">
                    <div id="${tab.id}" style="width: 45vw; height: 50vh;"></div>
                </div>
            `;
                tabContent.appendChild(contentPane); // Append pane to tab content
            });
        </script>


        {{-- Real-time --}}
        <script>
            // Initialize Flatpickr with inline option enabled
            flatpickr("#datepicker", {
                inline: true,
                disableMobile: true,
                locale: {
                    firstDayOfWeek: 1
                }, // Sets Monday as the first day of the week
                onChange: function(selectedDates, dateStr, instance) {
                    const selectedDate = new Date(dateStr);
                    renderChartsForSelectedDate(selectedDate);
                },
                onOpen: function() {
                    document.querySelector(".flatpickr-calendar").classList.add("animate");
                },
                onClose: function() {
                    document.querySelector(".flatpickr-calendar").classList.remove("animate");
                }
            });

            function renderChartsForSelectedDate(selectedDate) {
                // Format selected date to YYYY-MM-DD
                const formattedDate = selectedDate.toISOString().split('T')[0];

                // Render the charts for the selected date
                renderChart('F', 'Frequency Over Time', 'Frequency (Hz)', 'F', 'Hz', selectedDate);
                renderChart('U1', 'U1 Over Time', 'Voltage (V)', 'U1', 'V', selectedDate);
                renderChart('U2', 'U2 Over Time', 'Voltage (V)', 'U2', 'V', selectedDate);
                renderChart('U3', 'U3 Over Time', 'Voltage (V)', 'U3', 'V', selectedDate);
                renderChart('U12', 'U12 Over Time', 'Voltage (V)', 'U12', 'V', selectedDate);
                renderChart('U23', 'U23 Over Time', 'Voltage (V)', 'U23', 'V', selectedDate);
                renderChart('U31', 'U31 Over Time', 'Voltage (V)', 'U31', 'V', selectedDate);
                renderChart('IL1', 'IL1 Over Time', 'Current (A)', 'IL1', 'A', selectedDate);
                renderChart('IL2', 'IL2 Over Time', 'Current (A)', 'IL2', 'A', selectedDate);
                renderChart('IL3', 'IL3 Over Time', 'Current (A)', 'IL3', 'A', selectedDate);
            }

            function renderChart(containerId, titleText, yAxisName, dataKey, unit, selectedDate) {
                var dom = document.getElementById(containerId);
                var myChart = echarts.init(dom, null, {
                    renderer: 'canvas',
                    useDirtyRect: false
                });

                // Fetch data for the selected date
                fetch(`http://127.0.0.1:8000/api/v1/metering?date=${selectedDate.toISOString().split('T')[0]}`)
                    .then(response => response.json())
                    .then(data => {
                        // Extract updated_at and specified dataKey values for the chart without modifying seconds
                        let chartData = data.map(item => ({
                            name: item.updated_at,
                            value: [item.updated_at, item[dataKey]]
                        }));

                        // Process data to exclude nulls for gaps over the interval
                        let filledData = fillMissingData(chartData, 5); // 5-minute interval

                        // Calculate the min and max values from the data for the Y-axis range
                        const values = filledData.map(item => item.value[1]).filter(value => value !== null);
                        const minValue = Math.min(...values);
                        const maxValue = Math.max(...values);

                        // Add a margin of 10% to both min and max for better visualization
                        const margin = (maxValue - minValue) * 0.01;
                        const yAxisMin = (minValue - margin).toFixed(2); // Keep two decimal places
                        const yAxisMax = (maxValue + margin).toFixed(2); // Keep two decimal places

                        var option = {
                            title: {
                                text: titleText
                            },
                            tooltip: {
                                trigger: 'axis',
                                formatter: function(params) {
                                    params = params[0];
                                    let date = new Date(params.name);
                                    return (
                                        date.getHours().toString().padStart(2, '0') + ':' +
                                        date.getMinutes().toString().padStart(2, '0') + ' ' +
                                        titleText +
                                        ' : ' + (params.value[1] !== null ? params.value[1] + ' ' + unit :
                                            'No Data')
                                    );
                                },
                                axisPointer: {
                                    animation: false
                                }
                            },
                            toolbox: {
                                feature: {
                                    dataZoom: {
                                        yAxisIndex: 'none'
                                    },
                                    dataView: {
                                        readOnly: false
                                    },
                                    restore: {},
                                    saveAsImage: {}
                                }
                            },
                            xAxis: {
                                type: 'time',
                                splitLine: {
                                    show: false
                                },
                                min: new Date(selectedDate.setHours(0, 0, 0, 0)), // Start of the selected date
                                max: new Date(selectedDate.setHours(23, 59, 59, 999)) // End of the selected date
                            },
                            yAxis: {
                                type: 'value',
                                boundaryGap: [0, '100%'],
                                splitLine: {
                                    show: false
                                },
                                name: yAxisName,
                                min: yAxisMin, // Set dynamic min value, rounded
                                max: yAxisMax // Set dynamic max value, rounded
                            },

                            dataZoom: [{
                                    type: 'inside',
                                    start: 0,
                                    end: 100
                                },
                                {
                                    start: 0,
                                    end: 100
                                }
                            ],

                            series: [{
                                name: titleText,
                                type: 'line',
                                showSymbol: true,
                                connectNulls: false, // Do not connect gaps, show breaks instead
                                smooth: true, // Enable smooth curve
                                data: filledData
                            }]
                        };

                        myChart.setOption(option);
                    })
                    .catch(error => console.error('Error fetching data:', error));

                window.addEventListener('resize', myChart.resize);
            }

            // Function to fill missing data points at regular intervals (5-minute)
            function fillMissingData(data, intervalMinutes) {
                const filledData = [];
                const intervalMillis = intervalMinutes * 60 * 1000; // Convert minutes to milliseconds

                // Round the first data point's timestamp
                let currentTime = roundToNearestInterval(new Date(data[0].name), intervalMinutes).getTime();
                filledData.push({
                    name: new Date(currentTime).toISOString(),
                    value: [new Date(currentTime).toISOString(), data[0].value[1]] // Use original value
                });

                // Loop through the data and fill missing intervals
                for (let i = 1; i < data.length; i++) {
                    let nextTime = roundToNearestInterval(new Date(data[i].name), intervalMinutes).getTime();

                    // Add missing intervals between data points
                    while (nextTime - currentTime > intervalMillis) {
                        currentTime += intervalMillis; // Increment by 5-minute intervals
                        filledData.push({
                            name: new Date(currentTime).toISOString(),
                            value: [new Date(currentTime).toISOString(), null] // Empty data point
                        });
                    }

                    // Add the current data point
                    filledData.push({
                        name: new Date(nextTime).toISOString(),
                        value: [new Date(nextTime).toISOString(), data[i].value[1]]
                    });
                    currentTime = nextTime;
                }

                return filledData;
            }

            // Helper function to round timestamp to nearest interval
            function roundToNearestInterval(date, intervalMinutes) {
                const intervalMillis = intervalMinutes * 60 * 1000;
                const roundedMillis = Math.round(date.getTime() / intervalMillis) * intervalMillis;
                return new Date(roundedMillis);
            }

            // Initial chart render for the current date (optional)
            renderChartsForSelectedDate(new Date());
        </script>

        {{-- Energy --}}
        <script>
            // Define days of the week and initialize data structure
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const dataByDay = {
                'Sun': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                },
                'Mon': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                },
                'Tue': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                },
                'Wed': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                },
                'Thu': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                },
                'Fri': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                },
                'Sat': {
                    start: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    end: {
                        Ep_sum: null,
                        Eq_sum: null
                    },
                    difference: {
                        Ep_sum: 0,
                        Eq_sum: 0
                    }
                }
            };

            // Helper function to check if a date is in the current week
            function isInCurrentWeek(date) {
                const today = new Date();
                const dayOfWeek = today.getUTCDay();
                const weekStart = new Date(today);
                weekStart.setUTCDate(today.getUTCDate() - dayOfWeek);
                const weekEnd = new Date(weekStart);
                weekEnd.setUTCDate(weekStart.getUTCDate() + 6);
                return date >= weekStart && date <= weekEnd;
            }

            // Fetch data from the API and process it
            fetch('http://127.0.0.1:8000/api/v1/metering')
                .then(response => response.json())
                .then(jsonData => {
                    // Step 1: Process data to calculate start and end values for each day in the current week
                    jsonData.forEach(entry => {
                        const date = new Date(entry.created_at);
                        if (isInCurrentWeek(date)) {
                            const day = daysOfWeek[date.getUTCDay()];
                            // For Ep_sum and Eq_sum
                            if (dataByDay[day].start.Ep_sum === null) {
                                dataByDay[day].start.Ep_sum = entry.Ep_sum; // First value of Ep_sum for the day
                            }
                            if (dataByDay[day].start.Eq_sum === null) {
                                dataByDay[day].start.Eq_sum = entry.Eq_sum; // First value of Eq_sum for the day
                            }
                            dataByDay[day].end.Ep_sum = entry.Ep_sum; // Last value of Ep_sum for the day
                            dataByDay[day].end.Eq_sum = entry.Eq_sum; // Last value of Eq_sum for the day
                        }
                    });

                    // Step 2: Calculate differences for each day and format to 2 decimal places
                    daysOfWeek.forEach(day => {
                        const {
                            start,
                            end
                        } = dataByDay[day];
                        if (start.Ep_sum !== null && end.Ep_sum !== null) {
                            dataByDay[day].difference.Ep_sum = (end.Ep_sum - start.Ep_sum).toFixed(
                                2); // Calculate Ep_sum difference
                        }
                        if (start.Eq_sum !== null && end.Eq_sum !== null) {
                            dataByDay[day].difference.Eq_sum = (end.Eq_sum - start.Eq_sum).toFixed(
                                2); // Calculate Eq_sum difference
                        }
                    });

                    // Step 3: Prepare data for the chart
                    const activeEnergyByDay = daysOfWeek.map(day => parseFloat(dataByDay[day].difference.Ep_sum));
                    const reactiveEnergyByDay = daysOfWeek.map(day => parseFloat(dataByDay[day].difference.Eq_sum));

                    // Step 4: Configure and render the chart
                    const chartDom = document.getElementById('energy');
                    const myChart = echarts.init(chartDom);
                    const option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'shadow'
                            }
                        },
                        legend: {},
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: [{
                            type: 'category',
                            data: daysOfWeek
                        }],
                        yAxis: [{
                            type: 'value'
                        }],
                        series: [{
                                name: 'Active Energy',
                                type: 'bar',
                                stack: 'Ad',
                                emphasis: {
                                    focus: 'series'
                                },
                                data: activeEnergyByDay
                            },
                            {
                                name: 'Reactive Energy',
                                type: 'bar',
                                stack: 'Ad',
                                emphasis: {
                                    focus: 'series'
                                },
                                data: reactiveEnergyByDay
                            },
                        ]
                    };

                    myChart.setOption(option);
                })
                .catch(error => console.error('Error fetching data:', error));
        </script>




    </div>
@endsection
