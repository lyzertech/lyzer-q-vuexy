@extends('base.0layout')

@section('title', 'Users')

@section('link')

@endsection

{{-- @section('zone-link')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="sneat/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="sneat/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="sneat/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="sneat/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="sneat/assets/vendor/libs/moment/moment.js"></script>
    <script src="sneat/assets/vendor/libs/datatable-bs5/datatable-bootstrap5.js"></script>
    <script src="sneat/assets/vendor/libs/select2/select2.js"></script>
    <script src="sneat/assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js"></script>
    <script src="sneat/assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="sneat/assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="sneat/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="sneat/assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <!-- Page JS -->
    <script src="sneat/assets/js/app-user-list.js"></script>
@endsection --}}

@section('content')
    <div class="flex-grow-1 container-p-y container-fluid">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="javascript:history.back()" class="badge bg-label-secondary">
                            &lt; Back
                        </a>
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded my-4" src="/sneat/assets/img/avatars/1.png" height="110"
                                    width="110" alt="User avatar">
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{ $CRMCustomer->name }}</h4>
                                    <span class="badge bg-label-secondary">{{ $CRMCustomer->company }}</span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                            <div class="d-flex align-items-start me-4 mt-3 gap-3">
                                <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-check bx-sm"></i></span>
                                <div>
                                    <h5 class="mb-0">1.23k</h5>
                                    <span>Tasks Done</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3 gap-3">
                                <span class="badge bg-label-primary p-2 rounded"><i
                                        class="bx bx-customize bx-sm"></i></span>
                                <div>
                                    <h5 class="mb-0">568</h5>
                                    <span>Projects Done</span>
                                </div>
                            </div>
                        </div> --}}
                        <h5 class="pb-2 border-bottom mb-4">Details</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Username:</span>
                                    <span>{{ $CRMCustomer->name }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Email:</span>
                                    <span>{{ $CRMCustomer->email }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Status:</span>
                                    @if ($CRMCustomer->status == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @elseif($CRMCustomer->status == 2)
                                        <span class="badge bg-label-danger">Not Active</span>
                                    @else
                                        <span class="badge bg-label-secondary">Unknown Status</span>
                                    @endif
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Contact:</span>
                                    <span>{{ $CRMCustomer->mobilephone }}, {{ $CRMCustomer->phonenumber }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Area:</span>
                                    <span>{{ $CRMCustomer->area }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Address:</span>
                                    <span>{{ $CRMCustomer->address }}, {{ $CRMCustomer->state }}</span>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center pt-3">
                                <a href="{{ route('users.edit', $CRMCustomer->id_customer) }}"
                                    class="btn btn-primary me-3">Edit</a>
                                <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->
        </div>
    </div>
@endsection
