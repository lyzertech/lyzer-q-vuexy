@extends('base.0layout')

@section('title', 'HSE')

@section('link')

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
    <div class="flex-grow-1 container-p-y container-fluid">

        <div class="row">    
            @php
                $cards = [
                    [
                        'title' => 'Dashboard',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Overview',
                                'description' => 'Provides a high-level summary of HSE performance, including key metrics and trends',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Notifications',
                                'description' => 'Alerts for pending actions, upcoming audits, training sessions, and incident reports',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Quick Access',
                                'description' => 'Shortcuts to frequently used features such as incident reporting, risk assessment, and document management',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Incident Management',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Incident Reporting',
                                'description' => 'Forms to report incidents, near misses, and unsafe conditions with fields for date, time, location, description, and severity',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Investigation and Analysis',
                                'description' => 'Tools for root cause analysis, incident classification, and corrective action tracking',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Incident Logs',
                                'description' => 'A searchable database of all reported incidents with filtering and sorting capabilities',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Risk Assessment',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'HAZOPs (Hazard and Operability Studies)',
                                'description' => 'Modules to identify and document workplace hazards',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Risk Matrix',
                                'description' => 'Tools to assess risk levels based on likelihood and severity',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Control Measures',
                                'description' => 'Forms to document and track implementation of risk control measures',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Periodic Reviews',
                                'description' => 'Schedule and track regular risk assessment reviews',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Training and Competency Management',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Training Records',
                                'description' => 'Database to manage employee training records, certifications, and competency levels',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Training Schedule',
                                'description' => 'Calendar and reminders for upcoming training sessions and re-certifications',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'E-Learning',
                                'description' => 'Integration with e-learning modules and quizzes to deliver online training',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Audit and Inspection',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Audit Planning',
                                'description' => 'Tools to schedule and assign internal and external audits and inspections',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Checklists',
                                'description' => 'Customizable checklists for various types of audits and inspections',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Audit Reports',
                                'description' => 'Forms to document findings, non-conformities, and corrective actions',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Follow-Up',
                                'description' => 'Track the status of corrective actions and improvements',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Document Management',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Policy and Procedure Repository',
                                'description' => 'Centralized storage for HSE policies, procedures, and guidelines',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Version Control',
                                'description' => 'Track document versions, revisions, and approval workflows',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Access Control',
                                'description' => 'Define user permissions for viewing, editing, and approving documents',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Compliance Management',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Regulation Tracking',
                                'description' => 'Database of relevant regulations, standards, and compliance requirements',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Compliance Calendar',
                                'description' => 'Schedule for compliance deadlines, audits, and regulatory updates',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Self-Assessment',
                                'description' => 'Tools for periodic self-assessment against compliance requirements',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Environmental Management',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Aspect and Impact Register',
                                'description' => 'Identify and document environmental aspects and impacts',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Environmental Objectives',
                                'description' => 'Set and track environmental objectives and targets',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Monitoring and Measurement',
                                'description' => 'Tools for tracking environmental performance metrics such as emissions, waste, and resource usage',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Health Surveillance',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Medical Records',
                                'description' => 'Manage employee health records, medical exams, and fitness assessments',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Health Programs',
                                'description' => 'Schedule and track workplace health programs and initiatives',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Incident Tracking',
                                'description' => 'Link health incidents to workplace activities and track health outcomes',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ],
                    [
                        'title' => 'Reporting and Analytics',
                        'items' => [
                            [
                                'icon' => 'bx bx-trending-up',
                                'url' => 'HSE_Hazops',
                                'title' => 'Custom Reports',
                                'description' => 'Generate custom reports on incidents, audits, training, and other HSE activities',
                                'amount' => '$1,619',
                                'percentage' => '18.6%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Data Visualization',
                                'description' => 'Charts and graphs to visualize HSE performance data',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ],
                            [
                                'icon' => 'bx bx-credit-card',
                                'url' => 'HSE_Hazops',
                                'title' => 'Export Options',
                                'description' => 'Export reports and data to various formats (PDF, Excel, etc.)',
                                'amount' => '$430',
                                'percentage' => '52.8%'
                            ]
                        ]
                    ]
                ];
            @endphp

            @foreach($cards as $card)
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">{{ $card['title'] }}</h5>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0" style="position: relative;">
                            <ul class="p-0 m-0">
                                @foreach($card['items'] as $item)
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="{{ $item['icon'] }}"></i></span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">
                                                    <a href="{{ url($item['url']) }}">{{ $item['title'] }}</a>
                                                </h6>
                                                <small class="text-muted">{{ $item['description'] }}</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-medium">{{ $item['amount'] }}</small>
                                                <i class="bx bx-chevron-up text-success ms-1"></i>
                                                <small class="text-muted">{{ $item['percentage'] }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>  
    </div>
@endsection