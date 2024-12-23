@extends('base.0layout')

@section('title', 'Quick Pin')

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
    <div class="card">
        <div class="row mx-2 my-3">
            <div class="col-md-2 col-sm-2">
                <div class="me-3 my-1">
                </div>
            </div>
            <div class="col-md-10 col-sm-10">
                <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                    <div class="dt-buttons my-1">
                        <button class="dt-button add-new btn btn-primary mx-3" tabindex="0" aria-controls="DataTable_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNewQuickPin">
                            <span><i class="bx bx-plus me-0 me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">New Quick Pin</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offcanvas to new quick pin -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNewQuickPin" aria-labelledby="offcanvasNewQuickPinLabel">
            <div class="offcanvas-header">
            <h5 id="offcanvasNewQuickPinLabel" class="offcanvas-title">New Quick Pin</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
            <form method="post" action="{{ route('quickpin.create') }}" enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="NewQuickPinForm">
                @csrf <!-- CSRF protection -->
                @method('POST')
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-topic">Topic</label>
                    <input type="text" class="form-control" id="add-topic" placeholder="Topic" name="topic" aria-label="Topic">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-quick-description">Description</label>
                    <textarea type="text" id="add-quick-description" class="form-control" placeholder="Here is information" aria-label="here is information" name="description" rows="4"></textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-phone">Phone</label>
                    <input type="text" id="add-user-phone" class="form-control" placeholder="08xx xxxx xxxx" aria-label="john.doe@example.com" name="phone">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-address">Address</label>
                    <input type="text" id="add-user-address" class="form-control" placeholder="Jalan Swadarma 1" aria-label="john.doe@example.com" name="address">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-state">state</label>
                    <input type="text" id="add-user-state" class="form-control" placeholder="Jakarta Barat, DKI Jakarta, Indonesia" aria-label="john.doe@example.com" name="state">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add-user-picture">Picture</label>
                    <input class="form-control" type="file" id="formFile" name="image">                    
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                <input type="hidden">
            </form>
            </div>
        </div>

    </div>
    <div class="row g-6 mt-4">
        <div class="col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="card shadow-none bg-label-success">
            <div class="card-body">
                <h5 class="card-title text-success">Success card title</h5>
                <p class="card-text text-success">
                Some quick example text to build on the card title and make up.
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="card shadow-none bg-label-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">Warning card title</h5>
                <p class="card-text text-warning">
                Some quick example text to build on the card title and make up.
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="card shadow-none bg-label-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">Danger card title</h5>
                <p class="card-text text-danger">
                Some quick example text to build on the card title and make up.
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="card shadow-none bg-label-info">
            <div class="card-body">
                <h5 class="card-title text-info">Info card title</h5>
                <p class="card-text text-info">
                Some quick example text to build on the card title and make up.
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="card shadow-none bg-label-secondary">
            <div class="card-body">
                <h5 class="card-title text-secondary">Secondary card title</h5>
                <p class="card-text text-secondary">
                Some quick example text to build on the card title and make up.
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="card shadow-none bg-label-primary">
            <div class="card-body">
                <h5 class="card-title text-primary">Primary card title</h5>
                <p class="card-text text-primary">
                Some quick example text to build on the card title and make up.
                </p>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection