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

@section('content')
    <div class="flex-shrink-1 flex-grow-0 w-px-350 border-end container-p-x container-p-y">
        <div class="layout-example-sidebar layout-example-content-inner">
            <!-- Checkbox -->
            {{-- <script>
                $(document).ready(function() {
                    $('#jstree').jstree({
                        core: {
                            themes: {
                                name: 'default' // Set a valid theme name
                            },
                            data: [{
                                    text: 'AcuLink 810 Gateway',
                                    state: {
                                        opened: true
                                    },
                                    children: [{
                                            text: 'Acuvim Office',
                                            state: {
                                                opened: true
                                            },
                                            type: 'css',
                                            children: [{
                                                text: 'Acuvim Office',
                                                type: 'css'
                                            }],
                                        },
                                        {
                                            text: 'style.css',
                                            type: 'css'
                                        }
                                    ]
                                },
                                {
                                    text: 'img',
                                    state: {
                                        opened: true
                                    },
                                    children: [{
                                            text: 'bg.jpg',
                                            type: 'img'
                                        },
                                        {
                                            text: 'logo.png',
                                            type: 'img'
                                        },
                                        {
                                            text: 'avatar.png',
                                            type: 'img'
                                        }
                                    ]
                                },
                                {
                                    text: 'js',
                                    state: {
                                        opened: true
                                    },
                                    children: [{
                                            text: 'jquery.js',
                                            type: 'js'
                                        },
                                        {
                                            text: 'app.js',
                                            type: 'js'
                                        }
                                    ]
                                },
                                {
                                    text: 'index.html',
                                    type: 'html'
                                },
                                {
                                    text: 'page-one.html',
                                    type: 'html'
                                },
                                {
                                    text: 'page-two.html',
                                    type: 'html'
                                }
                            ]
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
                            }
                        }
                    });
                });
            </script> --}}

            <div class="col-md-12 col-12">
                <div class="card mb-md-0 mb-6">
                    <h5 class="card-header">Checkboxes</h5>
                    <div class="card-body">
                        <div id="tree"></div>
                        <button id="submitSelection" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // Load the JSON data from the DatalogController
                    $.getJSON('/monitoring/datalog/data', function(data) {
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

                $('#submitSelection').on('click', function() {
                    // Get all selected nodes
                    const selectedNodes = $('#tree').jstree('get_selected', true);

                    // Filter to get only leaf nodes (nodes without children)
                    const leafNodes = selectedNodes.filter(node => !node.children.length).map(node => node.id);

                    // Send the leaf nodes to Laravel
                    $.ajax({
                        url: '/submit-tree-selection',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            leafNodes
                        },
                        success: function(response) {
                            alert(response.message);
                        },
                        error: function(error) {
                            console.error(error);
                            alert('An error occurred.');
                        }
                    });
                });
            </script>
            <!-- /Checkbox -->
        </div>
    </div>

    <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">

        <style>
            .table-container {
                overflow: auto;
                /* Enables horizontal and vertical scrolling */
                max-height: 400px;
                /* Optional: Limit table height */
            }

            .table {
                width: 100%;
                border-collapse: collapse;
            }

            /* Sticky header */
            .table thead th {
                position: sticky;
                top: 0;
                /* Sticks header at the top when scrolling vertically */
                background-color: #f8f9fa;
                /* Matches the table-light background */
                z-index: 2;
                /* Ensures the header is above other rows */
                border-bottom: 2px solid #dee2e6;
            }

            /* Sticky first column */
            .table tbody td:first-child,
            .table thead th:first-child {
                position: sticky;
                left: 0;
                background-color: #f8f9fa;
                z-index: 1;
            }

            /* Sticky column 8 */
            .table tbody td:nth-child(8),
            .table thead th:nth-child(8) {
                position: sticky;
                left: 145px;
                background-color: #f8f9fa;
                z-index: 1;
                width: 200px;
                /* Adjust the width as needed */
                min-width: 200px;
                /* Ensure it doesn’t shrink */
                max-width: 300px;
                /* Optional: Set a max width */
            }

            .table thead th:first-child {
                z-index: 3;
            }

            .table thead th:nth-child(8) {
                z-index: 3;
            }
        </style>
        <div class="row">
            <div class="layout-demo-info">
                <div class="col-xl-12 col-sm-12">
                    <div class="card overflow-hidden mb-6" style="height: 700px; width:1350px;">
                        <h5 class="card-header">Horizontal Scrollbar</h5>
                        <div class="table-responsive text-nowrap" id="table-scroll-container">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>gateway_name</th>
                                        <th>gateway_model</th>
                                        <th>gateway_serial</th>
                                        <th>device_name</th>
                                        <th>device_model</th>
                                        <th>device_serial</th>
                                        <th>device_online</th>
                                        <th>Timestamp</th>
                                        <th>Freq_Hz</th>
                                        <th>V1</th>
                                        <th>V2</th>
                                        <th>V3</th>
                                        <th>Vnavg_V</th>
                                        <th>V12</th>
                                        <th>V23</th>
                                        <th>V31</th>
                                        <th>VIavg_V</th>
                                        <th>I1</th>
                                        <th>I2</th>
                                        <th>I3</th>
                                        <th>Iavg_A</th>
                                        <th>P1</th>
                                        <th>P2</th>
                                        <th>P3</th>
                                        <th>Psum_kW</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Qsum_kvar</th>
                                        <th>S1</th>
                                        <th>S2</th>
                                        <th>S3</th>
                                        <th>Ssum_kVA</th>
                                        <th>PF1</th>
                                        <th>PF2</th>
                                        <th>PF3</th>
                                        <th>PF</th>
                                        <th>Unbl_V</th>
                                        <th>Unbl_I</th>
                                        <th>LCavg</th>
                                        <th>DMD_P_kW</th>
                                        <th>DMD_Q_kvar</th>
                                        <th>DMD_S_kVA</th>
                                        <th>EP_IMP_kWh</th>
                                        <th>EP_EXP_kWh</th>
                                        <th>EQ_IMP_kvarh</th>
                                        <th>EQ_EXP_kvarh</th>
                                        <th>EP_TOTAL_kWh</th>
                                        <th>EP_NET_kWh</th>
                                        <th>EQ_TOTAL_kvarh</th>
                                        <th>EQ_NET_kvarh</th>
                                        <th>ES_kVAh</th>
                                        <th>THD_Va</th>
                                        <th>THD_Vb</th>
                                        <th>THD_Vc</th>
                                        <th>THD_Vavg</th>
                                        <th>THD_Ia</th>
                                        <th>THD_Ib</th>
                                        <th>THD_Ic</th>
                                        <th>THD_Iavg</th>
                                        <th>Ang_Vb</th>
                                        <th>Ang_Vc</th>
                                        <th>Ang_Ia</th>
                                        <th>Ang_Ib</th>
                                        <th>Ang_Ic</th>
                                        <th>DMD_I1_A</th>
                                        <th>DMD_I2_A</th>
                                        <th>DMD_I3_A</th>
                                        <th>EPa_IMP_kWh</th>
                                        <th>EPa_EXP_kWh</th>
                                        <th>EPb_IMP_kWh</th>
                                        <th>EPb_EXP_kWh</th>
                                        <th>EPc_IMP_kWh</th>
                                        <th>EPc_EXP_kWh</th>
                                        <th>EQa_IMP_kvarh</th>
                                        <th>EQa_EXP_kvarh</th>
                                        <th>EQb_IMP_kvarh</th>
                                        <th>EQb_EXP_kvarh</th>
                                        <th>EQc_IMP_kvarh</th>
                                        <th>EQc_EXP_kvarh</th>
                                        <th>ESa_kVAh</th>
                                        <th>ESb_kVAh</th>
                                        <th>ESc_kVAh</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($allData as $data)
                                        <tr>
                                            <td>{{ $data->gateway_name }}</td>
                                            <td>{{ $data->gateway_model }}</td>
                                            <td>{{ $data->gateway_serial }}</td>
                                            <td>{{ $data->device_name }}</td>
                                            <td>{{ $data->device_model }}</td>
                                            <td>{{ $data->device_serial }}</td>
                                            <td>{{ $data->device_online }}</td>
                                            <td>{{ \Carbon\Carbon::createFromTimestamp($data->Timestamp)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td>{{ $data->Freq_Hz }}</td>
                                            <td>{{ $data->V1 }}</td>
                                            <td>{{ $data->V2 }}</td>
                                            <td>{{ $data->V3 }}</td>
                                            <td>{{ $data->Vnavg_V }}</td>
                                            <td>{{ $data->V12 }}</td>
                                            <td>{{ $data->V23 }}</td>
                                            <td>{{ $data->V31 }}</td>
                                            <td>{{ $data->VIavg_V }}</td>
                                            <td>{{ $data->I1 }}</td>
                                            <td>{{ $data->I2 }}</td>
                                            <td>{{ $data->I3 }}</td>
                                            <td>{{ $data->Iavg_A }}</td>
                                            <td>{{ $data->P1 }}</td>
                                            <td>{{ $data->P2 }}</td>
                                            <td>{{ $data->P3 }}</td>
                                            <td>{{ $data->Psum_kW }}</td>
                                            <td>{{ $data->Q1 }}</td>
                                            <td>{{ $data->Q2 }}</td>
                                            <td>{{ $data->Q3 }}</td>
                                            <td>{{ $data->Qsum_kvar }}</td>
                                            <td>{{ $data->S1 }}</td>
                                            <td>{{ $data->S2 }}</td>
                                            <td>{{ $data->S3 }}</td>
                                            <td>{{ $data->Ssum_kVA }}</td>
                                            <td>{{ $data->PF1 }}</td>
                                            <td>{{ $data->PF2 }}</td>
                                            <td>{{ $data->PF3 }}</td>
                                            <td>{{ $data->PF }}</td>
                                            <td>{{ $data->Unbl_V }}</td>
                                            <td>{{ $data->Unbl_I }}</td>
                                            <td>{{ $data->LCavg }}</td>
                                            <td>{{ $data->DMD_P_kW }}</td>
                                            <td>{{ $data->DMD_Q_kvar }}</td>
                                            <td>{{ $data->DMD_S_kVA }}</td>
                                            <td>{{ $data->EP_IMP_kWh }}</td>
                                            <td>{{ $data->EP_EXP_kWh }}</td>
                                            <td>{{ $data->EQ_IMP_kvarh }}</td>
                                            <td>{{ $data->EQ_EXP_kvarh }}</td>
                                            <td>{{ $data->EP_TOTAL_kWh }}</td>
                                            <td>{{ $data->EP_NET_kWh }}</td>
                                            <td>{{ $data->EQ_TOTAL_kvarh }}</td>
                                            <td>{{ $data->EQ_NET_kvarh }}</td>
                                            <td>{{ $data->ES_kVAh }}</td>
                                            <td>{{ $data->THD_Va }}</td>
                                            <td>{{ $data->THD_Vb }}</td>
                                            <td>{{ $data->THD_Vc }}</td>
                                            <td>{{ $data->THD_Vavg }}</td>
                                            <td>{{ $data->THD_Ia }}</td>
                                            <td>{{ $data->THD_Ib }}</td>
                                            <td>{{ $data->THD_Ic }}</td>
                                            <td>{{ $data->THD_Iavg }}</td>
                                            <td>{{ $data->Ang_Vb }}</td>
                                            <td>{{ $data->Ang_Vc }}</td>
                                            <td>{{ $data->Ang_Ia }}</td>
                                            <td>{{ $data->Ang_Ib }}</td>
                                            <td>{{ $data->Ang_Ic }}</td>
                                            <td>{{ $data->DMD_I1_A }}</td>
                                            <td>{{ $data->DMD_I2_A }}</td>
                                            <td>{{ $data->DMD_I3_A }}</td>
                                            <td>{{ $data->EPa_IMP_kWh }}</td>
                                            <td>{{ $data->EPa_EXP_kWh }}</td>
                                            <td>{{ $data->EPb_IMP_kWh }}</td>
                                            <td>{{ $data->EPb_EXP_kWh }}</td>
                                            <td>{{ $data->EPc_IMP_kWh }}</td>
                                            <td>{{ $data->EPc_EXP_kWh }}</td>
                                            <td>{{ $data->EQa_IMP_kvarh }}</td>
                                            <td>{{ $data->EQa_EXP_kvarh }}</td>
                                            <td>{{ $data->EQb_IMP_kvarh }}</td>
                                            <td>{{ $data->EQb_EXP_kvarh }}</td>
                                            <td>{{ $data->EQc_IMP_kvarh }}</td>
                                            <td>{{ $data->EQc_EXP_kvarh }}</td>
                                            <td>{{ $data->ESa_kVAh }}</td>
                                            <td>{{ $data->ESb_kVAh }}</td>
                                            <td>{{ $data->ESc_kVAh }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
