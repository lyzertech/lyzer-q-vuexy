@extends('base.0layout')

@section('title', 'CRM')

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
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.js"></script>
    <!-- Optional: Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection

@section('content')
    <div class="flex-grow-1 container-p-y container-fluid">

        <div class="row mb-6">
            <div class="col-md-12 order-3 order-lg-12">
                <div class="card text-center">
                    {{-- tab-list --}}
                    <div class="card-header py-4">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item px-2" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-customer" aria-controls="navs-pills-customer"
                                    aria-selected="true">Customer</button>
                            </li>
                            <li class="nav-item px-2" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-visit" aria-controls="navs-pills-visit"
                                    aria-selected="true">Visit Report</button>
                            </li>
                            {{-- <li class="nav-item px-2" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-quot" aria-controls="navs-pills-quot" aria-selected="false"
                                    tabindex="-1">Quotation</button>
                            </li> --}}
                            <li class="nav-item px-2" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-po" aria-controls="navs-pills-po" aria-selected="false"
                                    tabindex="-1">PO</button>
                            </li>
                        </ul>
                    </div>

                    {{-- tab-content --}}
                    <div class="tab-content pt-0">
                        {{-- Customer --}}
                        <div class="tab-pane fade active show" id="navs-pills-customer" role="tabpanel">
                            <div class="">
                                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <div class="btn-group">
                                            <button class="btn buttons-collection dropdown-toggle btn-label-primary me-2"
                                                tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                aria-haspopup="dialog" aria-expanded="false">
                                                <span><i class="bx bx-export me-sm-1"></i>
                                                    <span class="d-none d-sm-inline-block">Export</span>
                                                </span>
                                            </button>
                                        </div>
                                        <button class="dt-button add-new btn btn-primary mx-3" tabindex="0"
                                            aria-controls="DataTable_Table_0" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasAddCustomer">
                                            <span><i class="bx bx-plus me-0 me-sm-1"></i>
                                                <span class="d-none d-sm-inline-block">Add New Customer</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive text-start">
                                <div class="card card-datatable table-responsive mt-3">
                                    <table class="table table-bordered" id="customer-table" data-page-length='7'>
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Area</th>
                                                <th>Phone Number</th>
                                                <th>Mobile Phone</th>
                                                <th>Company</th>
                                                <th>Status</th>
                                                {{-- <th>Created At</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Visit --}}
                        <div class="tab-pane fade" id="navs-pills-visit" role="tabpanel">
                            <div class="">
                                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <div class="btn-group">
                                            <button class="btn buttons-collection dropdown-toggle btn-label-primary me-2"
                                                tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                aria-haspopup="dialog" aria-expanded="false">
                                                <span><i class="bx bx-export me-sm-1"></i>
                                                    <span class="d-none d-sm-inline-block">Export</span>
                                                </span>
                                            </button>
                                        </div>
                                        <button type="button" class="dt-button add-new btn btn-primary mx-3"
                                            data-bs-toggle="modal" data-bs-target="#ModalAddVisit">
                                            <span><i class="bx bx-plus me-0 me-sm-1"></i>
                                                <span class="d-none d-sm-inline-block">Add New Visit</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive text-start">
                                <div class="card card-datatable table-responsive mt-3">
                                    <table class="table table-bordered" id="visit-table" data-page-length='7'>
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Location</th>
                                                <th>Visit Date</th>
                                                <th>Visit Time</th>
                                                <th>Purpose</th>
                                                <th>Follow Up Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Quotation --}}
                        <div class="tab-pane fade" id="navs-pills-quot" role="tabpanel">
                            <div class="table-responsive text-start">
                                <div class="card">
                                    <div class="card-datatable table-responsive">
                                        <div class="row mx-2 my-3">
                                            <div
                                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                                <div id="DataTable_Table_0_filter" class="dataTable_filter">
                                                    <label>
                                                        <input type="search" id="searchQuot" class="form-control"
                                                            placeholder="Search.." aria-controls="DataTable_Table_0">
                                                    </label>
                                                </div>
                                                <div class="dt-buttons my-1">
                                                    <button class="dt-button add-new btn btn-primary mx-3" tabindex="0"
                                                        aria-controls="DataTable_Table_0" type="button"
                                                        data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasAddQuotation">
                                                        <span><i class="bx bx-plus me-0 me-sm-1"></i>
                                                            <span class="d-none d-sm-inline-block">Add New Quotation</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dataTables_scrollBody"
                                            style="position: relative; overflow: auto; width: 100%; max-height: 322px;">
                                            <table class="invoice-list-table table" id="quotation">
                                                <thead>
                                                    <tr>
                                                        <th>Quotation Number</th>
                                                        <th>Project</th>
                                                        <th>Customer</th>
                                                        <th>Amount</th>
                                                        <th>Sales</th>
                                                        <th>Status</th>
                                                        <th class="cell-fit">Paid By</th>
                                                        <th class="cell-fit">Actions</th>
                                                    </tr>
                                                </thead>
                                                <script>
                                                    document.getElementById('searchQuot').addEventListener('input', function() {
                                                        // Get user input
                                                        const searchText = this.value.toLowerCase();

                                                        // Get all menu items
                                                        const menuItems = document.querySelectorAll('#quotation tr');

                                                        // Loop through each menu item and hide/show based on user input
                                                        menuItems.forEach(function(item) {
                                                            const itemName = item.textContent.toLowerCase();
                                                            if (itemName.includes(searchText)) {
                                                                item.style.display = 'block';
                                                            } else {
                                                                item.style.display = 'none';
                                                            }
                                                        });
                                                    });
                                                </script>
                                                @foreach ($quotation_list as $q_list)
                                                    <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="d-flex justify-content-start align-items-center">
                                                                    <div class="d-flex flex-column">
                                                                        <a href="pages-profile-user.html"
                                                                            class="text-body text-truncate fw-medium">{{ $q_list->quotNumber }}</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $q_list->project }}</td>
                                                            <td>{{ $q_list->customer }}</td>
                                                            <td>Rp.{{ number_format($q_list->amount, 2, '.', ',') }}</td>
                                                            <td>{{ $q_list->sales }}</td>
                                                            <td><span class="badge bg-label-success"> {{ $q_list->status }}
                                                                </span></td>
                                                            <td><img src="../../assets/img/icons/payments/master-light.png"
                                                                    class="img-fluid" width="222 alt="masterCard"
                                                                    data-app-light-img="icons/payments/master-light.png"
                                                                    data-app-dark-img="icons/payments/master-dark.png">
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="dropdown"><a href="javascript:;"
                                                                            class="btn dropdown-toggle hide-arrow text-body p-0"
                                                                            data-bs-toggle="dropdown"><i
                                                                                class="bx bx-dots-vertical-rounded"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <a href="javascript:void(0);"
                                                                                class="dropdown-item">Edit</a>
                                                                            <a href="javascript:;"
                                                                                class="dropdown-item">Duplicate</a>
                                                                            <div class="dropdown-divider"></div>
                                                                            <a href="javascript:;"
                                                                                class="dropdown-item delete-record text-danger">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PO --}}
                        <div class="tab-pane fade" id="navs-pills-po" role="tabpanel">
                            <div class="">
                                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <div class="btn-group">
                                            <button class="btn buttons-collection dropdown-toggle btn-label-primary me-2"
                                                tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                aria-haspopup="dialog" aria-expanded="false">
                                                <span><i class="bx bx-export me-sm-1"></i>
                                                    <span class="d-none d-sm-inline-block">Export</span>
                                                </span>
                                            </button>
                                        </div>
                                        <button type="button" class="dt-button add-new btn btn-primary mx-3"
                                            data-bs-toggle="modal" data-bs-target="#ModalAddPO">
                                            <span><i class="bx bx-plus me-0 me-sm-1"></i>
                                                <span class="d-none d-sm-inline-block">Add New PO</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive text-start">
                                <div class="card card-datatable table-responsive mt-3">
                                    <table class="table table-bordered" id="po-table" data-page-length='7'>
                                        <thead>
                                            <tr>
                                                <th>Company</th>
                                                <th>File PO</th>
                                                <th>Status</th>
                                                <th>Sales</th>
                                                <th>Delivery Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Team Member --}}
            <div class="col-md-6 col-lg-4 mb-md-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Team Members</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="teamMemberList" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList" style="">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Project</th>
                                    <th>Task (%)</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($task as $result)
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="avatar me-2">
                                                    {{-- <img src="/storage/{{ $s->image }}" alt="Avatar" class="rounded-circle"> --}}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-truncate">{{ $result->name }}</h6><small
                                                        class="text-truncate text-muted">Sales</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-label-primary rounded-pill text-uppercase">Zipcar</span>
                                        </td>
                                        <td><small class="fw-medium">{{ $result->task }}/{{ $totaltask }}
                                                ({{ number_format(($result->task / $totaltask) * 100, 2) }}%)
                                            </small></td>
                                        <td>
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-primary shadow-none" role="progressbar"
                                                    style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100">25%</div>
                                                <div class="progress-bar bg-success shadow-none" role="progressbar"
                                                    style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                                    aria-valuemax="100">30%</div>
                                                <div class="progress-bar bg-danger shadow-none" role="progressbar"
                                                    style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                                    aria-valuemax="100">45%</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Offcanvas to add new customer -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCustomer"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Customer</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form method="post" action="{{ route('Customers.create') }}" enctype="multipart/form-data"
                    class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm">
                    @csrf <!-- CSRF protection -->
                    @method('POST')
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-fullname">Full Name</label>
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe"
                            name="name" aria-label="John Doe">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" id="add-user-email" class="form-control"
                            placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label" for="add-user-picture">Picture</label>
                        <input class="form-control" type="file" id="formFile" name="image">
                    </div> --}}
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-area">Area</label>
                        <input type="text" class="form-control" id="add-user-area" placeholder="Jakarta"
                            name="area" aria-label="Jakarta">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-address">Address</label>
                        <input type="text" class="form-control" id="add-user-address" placeholder="Blok N15-16"
                            name="address" aria-label="Blok N15-16">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-phonenumber">Phone Number</label>
                        <input type="text" class="form-control" id="add-user-phonenumber"
                            placeholder="+62888 8888 8888" name="phonenumber" aria-label="Jakarta">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-mobilephone">Mobile Phone</label>
                        <input type="text" class="form-control" id="add-user-mobilephone"
                            placeholder="+62888 8888 8888" name="mobilephone" aria-label="Jakarta">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-company">Company</label>
                        <input type="text" class="form-control" id="add-user-company" placeholder="PT. LyZer"
                            name="company" aria-label="LyZer Tech">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-position">Position</label>
                        <input type="text" class="form-control" id="add-user-position" placeholder="PT. LyZer"
                            name="position" aria-label="LyZer Tech">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    <input type="hidden">
                </form>
            </div>
        </div>

        <!-- Modal to add new visit -->
        <div class="modal-onboarding modal fade animate_animated" id="ModalAddVisit" tabindex="-1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div id="modalCarouselControls" class="carousel slide pb-6 mb-2" data-bs-interval="false">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="0"
                                class="active"></button>
                            <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <form method="post" action="{{ route('Visit.create') }}" enctype="multipart/form-data">
                                @csrf <!-- CSRF protection -->
                                <div class="modal-content text-center">
                                    <div class="modal-body p-0">
                                        <!-- Carousel Item 1 -->
                                        <div class="carousel-item active">
                                            <div class="onboarding-media">
                                                <div class="mx-2">
                                                    <img src="../../assets/img/illustrations/girl-with-laptop-light.png"
                                                        alt="girl-with-laptop-light" width="222" class="img-fluid"
                                                        data-app-dark-img="illustrations/girl-with-laptop-dark.png"
                                                        data-app-light-img="illustrations/girl-with-laptop-light.png">
                                                </div>
                                            </div>
                                            <div class="onboarding-content">
                                                <h4 class="onboarding-title text-body">Visit Information</h4>
                                                <div class="row g-6">
                                                    <!-- Customer Name -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="customer-company">Customer
                                                                Company</label>
                                                            <select id="customer-company" class="form-select"
                                                                name="customer_name">
                                                                <option value="">Select Company</option>
                                                                @foreach ($customer->sortBy('company') as $cust)
                                                                    <option value="{{ $cust->company }}">
                                                                        {{ $cust->company }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Contact Person -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="customer-name">Contact
                                                                Person</label>
                                                            <select id="customer-name" class="form-select"
                                                                name="contact_person">
                                                                <option value="">Select Name</option>
                                                                @foreach ($customer->sortBy('company') as $cust)
                                                                    <option value="{{ $cust->name }}"
                                                                        data-company="{{ $cust->company }}">
                                                                        {{ $cust->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-6">
                                                    <!-- Location -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="location">Location</label>
                                                            <input type="text" id="location" class="form-control"
                                                                placeholder="Meruya Utara" name="location">
                                                        </div>
                                                    </div>

                                                    <!-- Purpose -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="purpose">Purpose</label>
                                                            <input type="text" id="purpose" class="form-control"
                                                                placeholder="Present Transducer & Annunciator"
                                                                name="purpose">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-6">
                                                    <!-- Visit Date -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="visit_date">Visit Date</label>
                                                            <input class="form-control" type="date" id="visit_date"
                                                                name="visit_date">
                                                        </div>
                                                    </div>

                                                    <!-- Visit Time -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="visit_time">Visit Time</label>
                                                            <select class="form-control" id="visit_time"
                                                                name="visit_time">
                                                                <!-- Options will be dynamically generated -->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        // Generate time options dynamically
                                                        function generateTimeOptions(start, end, interval) {
                                                            const select = document.getElementById('visit_time');
                                                            const startTime = start.split(':').map(Number); // Convert "07:00" to [7, 0]
                                                            const endTime = end.split(':').map(Number); // Convert "18:00" to [18, 0]
                                                            let [hour, minute] = startTime;

                                                            while (hour < endTime[0] || (hour === endTime[0] && minute <= endTime[1])) {
                                                                const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                                                                const option = document.createElement('option');
                                                                option.value = time;
                                                                option.textContent = time;
                                                                select.appendChild(option);

                                                                // Increment by the interval
                                                                minute += interval;
                                                                if (minute >= 60) {
                                                                    minute = 0;
                                                                    hour++;
                                                                }
                                                            }
                                                        }

                                                        // Generate options from 07:00 to 18:00 with 30-minute intervals
                                                        generateTimeOptions('07:00', '18:00', 30);
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Carousel Item 2 -->
                                        <div class="carousel-item">
                                            <div class="onboarding-media">
                                                <div class="mx-2">
                                                    <img src="../../assets/img/illustrations/boy-with-laptop-light.png"
                                                        alt="boy-with-laptop-light" width="219" class="img-fluid"
                                                        data-app-dark-img="illustrations/boy-with-laptop-dark.png"
                                                        data-app-light-img="illustrations/boy-with-laptop-light.png">
                                                </div>
                                            </div>
                                            <div class="onboarding-content">
                                                <h4 class="onboarding-title text-body">Example Request Information</h4>
                                                <div class="row g-6">
                                                    <!-- Notes -->
                                                    <div class="col-sm-12">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="notes">Notes</label>
                                                            <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-6">
                                                    <!-- Customer Feedback -->
                                                    <div class="col-sm-12">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="customer_feedback">Customer
                                                                Feedback</label>
                                                            <textarea class="form-control" id="customer_feedback" rows="3" name="customer_feedback"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Carousel Item 3 -->
                                        <div class="carousel-item">
                                            <div class="onboarding-media">
                                                <div class="mx-2">
                                                    <img src="../../assets/img/illustrations/girl-verify-password-light.png"
                                                        alt="girl-verify-password-light" width="239" class="img-fluid"
                                                        data-app-dark-img="illustrations/girl-verify-password-dark.png"
                                                        data-app-light-img="illustrations/girl-verify-password-light.png">
                                                </div>
                                            </div>
                                            <div class="onboarding-content">
                                                <h4 class="onboarding-title text-body">Next Steps</h4>
                                                <div class="row g-6">
                                                    <!-- Next Steps -->
                                                    <div class="col-sm-12">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="next_steps">Next Steps</label>
                                                            <textarea class="form-control" id="next_steps" rows="4" name="next_steps"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-6">
                                                    <!-- Follow Up Date -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="follow_up_date">Follow Up
                                                                Date</label>
                                                            <input class="form-control" type="date"
                                                                id="follow_up_date" name="follow_up_date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <a class="carousel-control-prev" href="#modalCarouselControls" role="button"
                            data-bs-slide="prev">
                            <i class="bx bx-chevrons-left lh-1"></i><span>Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#modalCarouselControls" role="button"
                            data-bs-slide="next">
                            <span>Next</span><i class="bx bx-chevrons-right lh-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offcanvas to add new quotation -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddQuotation"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Quotation</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form method="post" action="{{ route('quot.create') }}" enctype="multipart/form-data"
                    class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewQuotForm">
                    @csrf <!-- CSRF protection -->
                    @method('POST')
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-project">Project</label>
                        <input type="text" class="form-control" id="add-user-project" placeholder="PLN Jawa Bali"
                            name="project" aria-label="John Doe">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-customer">Customer</label>
                        <select id="add-user-customer" class="form-select" name="customer">
                            <option>Default select</option>
                            @foreach ($customer->sortBy('company') as $cust)
                                <option value="{{ $cust->company }}">{{ $cust->company }}</option>
                            @endforeach
                        </select>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-sales">Sales</label>
                        <select id="add-user-sales" class="form-select" name="sales">
                            <option>Default select</option>
                            @foreach ($sales_quot->sortBy('name') as $sales_q)
                                <option value="{{ $sales_q->name }}">{{ $sales_q->name }}</option>
                            @endforeach
                        </select>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select id="status" class="form-select" name="status">
                            <option value="Quot">Quot</option>
                            <option value="Issue">Issue</option>
                            <option value="Technical">Technical</option>
                            <option value="Pending">Pending</option>
                            <option value="Loss">Loss</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="paidby">PaidBy</label>
                        <select id="paidby" class="form-select" name="paidby">
                            <option value="CBD">CBD</option>
                            <option value="DP 50%, 100% CBD">DP 50%, 100% CBD</option>
                            <option value="PreOrder">PreOrder</option>
                        </select>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-brand">Brand</label>
                        <select id="add-user-brand" class="form-select" name="brand">
                            <option>Default select</option>
                            @foreach ($product->sortBy('brand') as $brand_q)
                                <option value="{{ $brand_q->brand }}">{{ $brand_q->brand }}</option>
                            @endforeach
                        </select>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-type">Type</label>
                        <select id="add-user-type" class="form-select" name="type">
                            <option>Default select</option>
                            @foreach ($product->sortBy('type') as $type_q)
                                <option value="{{ $type_q->type }}">{{ $type_q->type }} Rp.{{ $type_q->price }}</option>
                            @endforeach
                        </select>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="add-user-qty">Quantity</label>
                        <input type="number" class="form-control" id="add-user-qty" placeholder="quantity"
                            name="qty" aria-label="qty">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    <input type="hidden">
                </form>
            </div>
        </div>

        <!-- Modal to add new po -->
        <div class="modal-onboarding modal fade animate_animated" id="ModalAddPO" tabindex="-1" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body onboarding-horizontal p-0">
                        <div class="onboarding-media">
                            <img src="sneat/assets/img/illustrations/boy-verify-email-light.png"
                                alt="boy-verify-email-light" width="273" class="img-fluid"
                                data-app-dark-img="illustrations/boy-verify-email-dark.png"
                                data-app-light-img="illustrations/boy-verify-email-light.png">
                        </div>
                        <div class="onboarding-content mb-0">
                            <h4 class="onboarding-title text-body">Example Request Information</h4>
                            <div class="onboarding-info">In this example you can see a form where you can request some
                                additional
                                information from the customer when they land on the app page.</div>
                            <form method="post" action="{{ route('Po.create') }}" enctype="multipart/form-data">
                                @csrf <!-- CSRF protection -->
                                <div class="row g-6">
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="po_number" class="form-label">PO Number</label>
                                            <input class="form-control" placeholder="Enter PO Number..." type="text"
                                                value="" tabindex="0" id="po_number" name="po_number">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="company" class="form-label">Company</label>
                                            <select class="form-select" tabindex="0" id="company" name="company">
                                                <option value="">Select Company</option>
                                                @foreach ($customer->sortBy('company') as $cust)
                                                    <option value="{{ $cust->company }}">
                                                        {{ $cust->company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-6">
                                    <div class="col-sm-12">
                                        <div class="mb-4">
                                            <label for="file_po" class="form-label">File PO</label>
                                            <input class="form-control" type="file" id="file_po" name="file_po">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-6">
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="add-user-sales">Sales</label>
                                            <select id="add-user-sales" class="form-select" name="sales">
                                                <option>Default select</option>
                                                @foreach ($sales_quot->sortBy('name') as $sales_q)
                                                    <option value="{{ $sales_q->name }}">{{ $sales_q->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="delivery_date" class="form-label">Delivery Date</label>
                                            <input class="form-control" placeholder="Enter PO Number..." type="date"
                                                value="" tabindex="0" id="delivery_date" name="delivery_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- customer-table --}}
        <script type="text/javascript">
            $(document).ready(function() {
                // Destroy existing DataTable before re-initializing
                if ($.fn.DataTable.isDataTable('#customer-table')) {
                    $('#customer-table').DataTable().destroy();
                }

                // Initialize DataTable
                $('#customer-table').DataTable({
                    serverSide: true,
                    ajax: '{{ route('Customers.data') }}',
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'area',
                            name: 'area'
                        },
                        {
                            data: 'phonenumber',
                            name: 'phonenumber'
                        },
                        {
                            data: 'mobilephone',
                            name: 'mobilephone'
                        },
                        {
                            data: 'company',
                            name: 'company'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                return (data === 1 || data === "1") ? 'Active' : 'Inactive';
                            }
                        },
                        // { data: 'created_at', name: 'created_at', width: '100px' },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>

        {{-- visit-table --}}
        <script type="text/javascript">
            $(document).ready(function() {
                // Destroy existing DataTable before re-initializing
                if ($.fn.DataTable.isDataTable('#visit-table')) {
                    $('#visit-table').DataTable().destroy();
                }

                // Initialize DataTable
                $('#visit-table').DataTable({
                    serverSide: true,
                    ajax: '{{ route('Visit.data') }}',
                    columns: [{
                            data: 'customer_name',
                            name: 'customer_name'
                        },
                        {
                            data: 'location',
                            name: 'location'
                        },
                        {
                            data: 'visit_date',
                            name: 'visit_date'
                        },
                        {
                            data: 'visit_time',
                            name: 'visit_time'
                        },
                        {
                            data: 'purpose',
                            name: 'purpose'
                        },
                        {
                            data: 'follow_up_date',
                            name: 'follow_up_date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        // { data: 'created_at', name: 'created_at', width: '100px' },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>

        {{-- visit-customer-filter --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const companySelect = document.getElementById('customer-company');
                const nameSelect = document.getElementById('customer-name');

                // Store all options in a variable
                const allOptions = Array.from(nameSelect.querySelectorAll('option[data-company]'));

                companySelect.addEventListener('change', function() {
                    const selectedCompany = this.value;

                    // Clear the existing options
                    nameSelect.innerHTML = '<option value="">Select Name</option>';

                    // Add filtered options based on the selected company
                    allOptions.forEach(option => {
                        if (option.getAttribute('data-company') === selectedCompany ||
                            selectedCompany === "") {
                            nameSelect.appendChild(option);
                        }
                    });
                });
            });
        </script>

        {{-- po-table --}}
        <script type="text/javascript">
            $(document).ready(function() {
                // Destroy existing DataTable before re-initializing
                if ($.fn.DataTable.isDataTable('#po-table')) {
                    $('#po-table').DataTable().destroy();
                }

                // Initialize DataTable
                $('#po-table').DataTable({
                    serverSide: true,
                    ajax: '{{ route('Po.data') }}',
                    columns: [{
                            data: 'company',
                            name: 'company'
                        },
                        {
                            data: 'file_po',
                            name: 'file_po'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'sales',
                            name: 'sales'
                        },
                        {
                            data: 'delivery_date',
                            name: 'delivery_date'
                        },
                        // { data: 'created_at', name: 'created_at', width: '100px' },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    </div>
@endsection
