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

@php
    use Illuminate\Support\Str;
@endphp

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
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Email:</span>
                                <span>{{ $customer->email }}</span>
                            </li>
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Sales Incharge:</span>
                                <span>{{ $customer->sales }}</span>
                            </li>
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Area:</span>
                                <span>{{ $customer->area }}</span>
                            </li>
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Address:</span>
                                <span>{{ $customer->address }}</span>
                            </li>
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Status:</span>
                                <span
                                    class="{{ $customer->status == 1 ? 'badge bg-label-success' : 'badge bg-label-danger' }}">
                                    {{ $customer->status == 1 ? 'Active' : 'Not Active' }}
                                </span>
                            </li>
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Phone Number:</span>
                                <span>{{ $customer->phonenumber }}</span>
                            </li>
                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Mobile Phone:</span>
                                <span>{{ $customer->mobilephone }}</span>
                            </li>
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

        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <form method="post"
                        action="{{ route('insight#crm-customer-edit', ['id_customer' => $customer->id_customer]) }}"
                        enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                        id="addNewUserForm">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mb-4" src="{{ asset('assets/img/avatars/1.png') }}"
                                    height="120" width="120" alt="User avatar" />
                                <div class="user-info text-center">
                                    <input required type="text" class="form-control" value="{{ $customer->name }}"
                                        name="name">
                                    <input required type="text" class="form-control" value="{{ $customer->position }}"
                                        name="position">
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-4 border-bottom mb-4">Details</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-6">
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Email:</span>
                                    <input required type="text" class="form-control" value="{{ $customer->email }}"
                                        name="email">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Sales Incharge:</span>
                                    <input required type="text" class="form-control" value="{{ $customer->sales }}"
                                        name="sales">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Area:</span>
                                    <input required type="text" class="form-control" value="{{ $customer->area }}"
                                        name="area">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Address:</span>
                                    <input required type="text" class="form-control" value="{{ $customer->address }}"
                                        name="address">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Status:</span>
                                    <input required type="text" class="form-control" value="{{ $customer->status }}"
                                        name="status">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Phone Number:</span>
                                    <input required type="text" class="form-control"
                                        value="{{ $customer->phonenumber }}" name="phonenumber">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Mobile Phone:</span>
                                    <input required type="text" class="form-control"
                                        value="{{ $customer->mobilephone }}" name="mobilephone">
                                </li>
                            </ul>


                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-label-secondary mx-2"
                                    onclick="window.location.href = '../../';">
                                    Back
                                </button>
                                <button type="submit" class="btn btn-primary me-4">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->


        <!-- User Sidebar -->
        <div class="col-xl-3 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div
                style="width: 53.98mm; height: 85.6mm; background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiyXliSoM5uoTDpYB0EY-DketOzPDrNhFR48SA4a8PRZcRwGp3Hdk_BQdIifr6-ADYHTV9CnO2RPTWeasnRtNUEKNBkXkyyjoQBwvJlC82NdhVsyr_TbV9dGwi8PAOBdoydH93OgM_Czngk/s1474/id-card-elegan.jpg') no-repeat center/cover; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 12px; padding: 8px; border: 1px solid #d1d5db; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Profile"
                    style="width: 30mm; height: 30mm; margin: 0 auto; border-radius: 50%; border: 2px solid #9ca3af;">
                <h2 style="color: #ffffff; font-size: 0.875rem; font-weight: bold; margin-top: 4px;">John Doe</h2>
                <p style="color: #ffffff; margin: 1px 0; font-size: 0.75rem;">Software Engineer</p>
                <div
                    style="margin-top: 4px; border-top: 1px solid #d1d5db; padding-top: 4px; font-size: 0.7rem; color: #ffffff;">
                    <p><strong>ID:</strong> 123456789</p>
                    <p><strong>Company:</strong> TechCorp</p>
                    <p><strong>Valid Until:</strong> Dec 2025</p>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->

    </div>


@endsection
