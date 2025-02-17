@extends('layouts/layoutMaster')

@section('title', 'Project Insight')

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

    {{-- Navbal pills --}}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-2 gap-lg-0">
                    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ route('insight#crm') }}">
                            <i class="ti ti-user-check ti-sm me-1_5"></i> CRM</a>
                    </li>
                    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="">
                            <i class="ti ti-user-check ti-sm me-1_5"></i> Organization</a>
                    </li>
                    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="">
                            <i class="ti ti-users ti-sm me-1_5"></i> Facility</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="">
                            <i class="ti ti-layout-grid ti-sm me-1_5"></i> Devices</a>
                    </li>
                    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="">
                            <i class="ti ti-link ti-sm me-1_5"></i> Alert</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


@endsection
