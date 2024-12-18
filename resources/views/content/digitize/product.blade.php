@extends('base.0layout')

@section('title', 'Product')

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
        <div class="row mt-4">
            <div class="col-md-8 col-lg-12 mb-0">
                <div class="card">
                    <div class="card-datatable table-responsive">
                        <div class="row mx-2 my-3">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                <div class="dt-buttons my-1">
                                    <button class="dt-button add-new btn btn-primary mx-3" tabindex="0"
                                        aria-controls="DataTable_Table_0" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasAddProduct">
                                        <span><i class="bx bx-plus me-0 me-sm-1"></i>
                                            <span class="d-none d-sm-inline-block">Add New Product</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card card-datatable table-responsive mt-3">
                            <table class="table table-bordered" id="product-table" data-page-length='7'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Brand</th>
                                        <th>Name</th>
                                        <th>Function</th>
                                        <th>Mode</th>
                                        <th>Input</th>
                                        <th>Display</th>
                                        <th>Output</th>
                                        <th>Webbase</th>
                                        <th>Comm</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="cell-fit">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                // Destroy existing DataTable before re-initializing
                                if ($.fn.DataTable.isDataTable('#product-table')) {
                                    $('#product-table').DataTable().destroy();
                                }

                                // Initialize DataTable
                                $('#product-table').DataTable({
                                    serverSide: true,
                                    ajax: '{{ route('Product.data') }}',
                                    dataSrc: function(json) {
                                        console.log(json); // Debugging response data
                                        return json.data;
                                    },
                                    columns: [
                                        {
                                            data: 'id_product',
                                            name: 'id_product'
                                        },
                                        {
                                            data: 'brand',
                                            name: 'brand'
                                        },
                                        {
                                            data: 'name',
                                            name: 'name'
                                        },
                                        {
                                            data: 'function',
                                            name: 'function'
                                        },
                                        {
                                            data: 'mode',
                                            name: 'mode'
                                        },
                                        {
                                            data: 'input',
                                            name: 'input'
                                        },
                                        {
                                            data: 'display',
                                            name: 'display'
                                        },
                                        {
                                            data: 'output',
                                            name: 'output'
                                        },
                                        {
                                            data: 'webbase',
                                            name: 'webbase'
                                        },
                                        {
                                            data: 'comm',
                                            name: 'comm'
                                        },
                                        {
                                            data: 'image',
                                            name: 'image'
                                        },
                                        {
                                            data: 'price',
                                            name: 'price'
                                        },
                                        {
                                            data: 'status',
                                            name: 'status'
                                        },
                                        {
                                            data: 'action',
                                            name: 'action',
                                            orderable: false,
                                            searchable: false
                                        }
                                    ],
                                    order: [
                                        [1, 'desc']
                                    ] // Order by the created_at column (index 4) in descending order
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offcanvas to add new product -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddProduct"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Product</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form method="post" action="{{ route('users.create') }}" enctype="multipart/form-data"
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
                        <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                            aria-label="john.doe@example.com" name="email">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-picture">Picture</label>
                        <input class="form-control" type="file" id="formFile" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user-role">User Role</label>
                        <select id="user-role" class="form-select" name="role_id">
                            <option value="1">Sales</option>
                            <option value="2">Purchasing</option>
                            <option value="3">IT</option>
                            <option value="4">Labs</option>
                            <option value="5">Courier</option>
                            <option value="6">Warehouse</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    <input type="hidden">
                </form>
            </div>
        </div>
    </div>
@endsection
