@extends('layouts/layoutMaster')

@section('title', 'Account')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/tables-datatables-basic.js'])
@endsection

@section('content')
    <div class="row">

        <!-- Transactions -->
        <div class="col-lg-3 order-2 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transactions</h5>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../../assets/img/icons/unicons/paypal.png" alt="User" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Paypal</small>
                                    <h6 class="fw-normal mb-0">Send money</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">+82.6</h6> <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Wallet</small>
                                    <h6 class="fw-normal mb-0">Mac'D</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">+270.69</h6> <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../../assets/img/icons/unicons/chart.png" alt="User" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Transfer</small>
                                    <h6 class="fw-normal mb-0">Refund</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">+637.91</h6> <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../../assets/img/icons/unicons/cc-primary.png" alt="User" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Credit Card</small>
                                    <h6 class="fw-normal mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">-838.71</h6> <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Wallet</small>
                                    <h6 class="fw-normal mb-0">Starbucks</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">+203.33</h6> <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Mastercard</small>
                                    <h6 class="fw-normal mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">-92.45</h6> <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->

        <!-- Bank Account -->
        <div class="col-lg-4 order-2 mb-6">
            <div class="card card-action mb-6">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Bank Account</h5>
                    <div class="card-action-element">
                        {{-- <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                data-bs-target="#addNewCCModal"><i class="bx bx-plus bx-xs me-1_5"></i>Add Card</button> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="added-cards">
                        <div class="cardMaster border p-6 rounded mb-4">
                            <div class="d-flex justify-content-between flex-sm-row flex-column">
                                <div class="card-information">
                                    <img class="mb-2" src="img\logo\bank\Permata_Bank_(2024).svg.png" alt="Master Card"
                                        height="40">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2">0041-2050-4075</h6>
                                        {{-- <span class="badge bg-label-primary me-1">Popular</span> --}}
                                    </div>
                                    <span class="card-number">Ade Maman Suherman</span>
                                </div>
                                <div class="d-flex flex-column text-start text-lg-end">
                                    {{-- <div class="d-flex order-sm-0 order-1">
                                            <button class="btn btn-sm btn-label-primary me-4" data-bs-toggle="modal"
                                                data-bs-target="#editCCModal">Edit</button>
                                            <button class="btn btn-sm btn-label-danger">Delete</button>
                                        </div> --}}
                                    <h6 class="mt-sm-4 mt-2 order-sm-1 order-0 text-sm-end mb-2"> IDR 831,400.00</h6>
                                </div>
                            </div>
                        </div>
                        <div class="cardMaster border p-6 rounded mb-4">
                            <div class="d-flex justify-content-between flex-sm-row flex-column">
                                <div class="card-information">
                                    <img class="mb-2" src="img\logo\bank\1280px-Bank_Central_Asia.svg.png"
                                        alt="Master Card" height="40">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2">7745262392</h6>
                                        {{-- <span class="badge bg-label-primary me-1">Popular</span> --}}
                                    </div>
                                    <span class="card-number">Ade Maman Suherman</span>
                                </div>
                                <div class="d-flex flex-column text-start text-lg-end">
                                    {{-- <div class="d-flex order-sm-0 order-1">
                                            <button class="btn btn-sm btn-label-primary me-4" data-bs-toggle="modal"
                                                data-bs-target="#editCCModal">Edit</button>
                                            <button class="btn btn-sm btn-label-danger">Delete</button>
                                        </div> --}}
                                    <h6 class="mt-sm-4 mt-2 order-sm-1 order-0 text-sm-end mb-2"> IDR 272,407.00</h6>
                                </div>
                            </div>
                        </div>
                        <div class="cardMaster border p-6 rounded mb-4">
                            <div class="d-flex justify-content-between flex-sm-row flex-column">
                                <div class="card-information">
                                    <img class="mb-2" src="img\logo\bank\Blu_by_BCA_Digital.png" alt="Master Card"
                                        height="40">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2">0022-2214-0424</h6>
                                        {{-- <span class="badge bg-label-primary me-1">Popular</span> --}}
                                    </div>
                                    <span class="card-number">Ade Maman Suherman</span>
                                </div>
                                <div class="d-flex flex-column text-start text-lg-end">
                                    {{-- <div class="d-flex order-sm-0 order-1">
                                            <button class="btn btn-sm btn-label-primary me-4" data-bs-toggle="modal"
                                                data-bs-target="#editCCModal">Edit</button>
                                            <button class="btn btn-sm btn-label-danger">Delete</button>
                                        </div> --}}
                                    <h6 class="mt-sm-4 mt-2 order-sm-1 order-0 text-sm-end mb-2"> IDR 0.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Bank Account -->

    </div>
@endsection
