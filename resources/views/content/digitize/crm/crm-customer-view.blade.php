@extends('layouts/layoutMaster')

@section('title', 'CRM Customer View')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-user-view.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/modal-edit-user.js', 'resources/assets/js/app-user-view.js', 'resources/assets/js/app-user-view-account.js', 'resources/assets/js/pages-profile.js'])
@endsection

@section('content')

    @php
        use Illuminate\Support\Str;
    @endphp

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-6 col-lg-5 order-1 order-md-0">
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
                                <h5>{{ $customer->company }}</h5>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">

                            <li class="d-flex">
                                <span class="h6" style="min-width: 150px;">Category Customer:</span>
                                <span class="">
                                    {{ $customer->status }}
                                </span>
                            </li>
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
                                onclick="window.location.href = '../';">
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
        <div class="col-xl-6 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <form method="post"
                        action="{{ route('crm-customer-edit', ['id_customer' => $customer->id_customer]) }}"
                        enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                        id="addNewUserForm">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mb-4" src="{{ asset('assets/img/avatars/1.png') }}"
                                    height="120" width="120" alt="User avatar" />
                                <div class="user-info text-center col-lg-8">
                                    <input required type="text" class="form-control" value="{{ $customer->name }}"
                                        name="name">
                                    <input required type="text" class="form-control" value="{{ $customer->position }}"
                                        name="position">
                                    <input required type="text" class="form-control" value="{{ $customer->company }}"
                                        name="company">
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-4 border-bottom mb-4">Details</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-6">
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Category Customer:</span>
                                    <select class="form-control" id="status-select" name="status">
                                        <option value="{{ $customer->status }}">{{ $customer->status }}</option>
                                        <option value="End-User">End-User</option>
                                        <option value="Panel Maker">Panel Maker</option>
                                        <option value="System Integrator">System Integrator</option>
                                        <option value="EPC">EPC</option>
                                        <option value="Supplier/Trader">Supplier/Trader</option>
                                        <option value="Consultant">Consultant</option>
                                        <option value="Contractor">Contractor</option>
                                        <option value="Data Center">Data Center</option>
                                    </select>
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Email:</span>
                                    <input required type="text" class="form-control" value="{{ $customer->email }}"
                                        name="email">
                                </li>
                                <li class="d-flex">
                                    <span class="h6" style="min-width: 150px;">Sales Incharge:</span>
                                    <select id="add-user-sales" class="form-select" name="sales">
                                        <option value="{{ $customer->sales }}">{{ $customer->sales }}</option>
                                        @foreach ($sales_list as $sales)
                                            <option value="{{ $sales->name }}">{{ $sales->name }}</option>
                                        @endforeach
                                    </select>
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
                                {{-- <button type="button" class="btn btn-label-secondary mx-2"
                                    onclick="window.location.href = '../../';">
                                    Back
                                </button> --}}
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
    </div>
@endsection
