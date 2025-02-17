@extends('layouts/layoutMaster')

@section('title', 'Project Insight CRM')

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

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-4" src="{{ asset('assets/img/avatars/1.png') }}" height="120"
                                width="120" alt="User avatar" />
                            <div class="user-info text-center">
                                <h5>{{ $customer->name }}</h5>
                                <span class="badge bg-label-secondary">{{ $customer->position }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                        <div class="d-flex align-items-center me-5 gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class='ti ti-checkbox ti-lg'></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">1.23k</h5>
                                <span>Task Done</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class='ti ti-briefcase ti-lg'></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">568</h5>
                                <span>Project Done</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="h6">Email:</span>
                                <span>{{ $customer->email }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">Status:</span>
                                <span
                                    class="{{ $customer->status == 1 ? 'badge bg-label-success' : 'badge bg-label-danger' }}">
                                    {{ $customer->status == 1 ? 'Active' : 'Not Active' }}
                                </span>
                            </li>
                            {{-- <li class="mb-2">
                            <span class="h6">Role:</span>
                            <span>Author</span>
                        </li> --}}
                            {{-- <li class="mb-2">
                            <span class="h6">Tax id:</span>
                            <span>Tax-8965</span>
                        </li> --}}
                            <li class="mb-2">
                                <span class="h6">Contact:</span>
                                <span>{{ $customer->mobilephone }}</span>
                            </li>
                            {{-- <li class="mb-2">
                            <span class="h6">Languages:</span>
                            <span>French</span>
                        </li> --}}
                            {{-- <li class="mb-2">
                            <span class="h6">Country:</span>
                            <span>England</span>
                        </li> --}}
                        </ul>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-label-secondary mx-2"
                                onclick="window.location.href = '../../';">
                                Back
                            </button>
                            {{-- <a href="javascript:;" class="btn btn-primary me-4" data-bs-target="#editUser"
                            data-bs-toggle="modal">Edit</a> --}}
                            {{-- <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspend</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->
    </div>


@endsection
