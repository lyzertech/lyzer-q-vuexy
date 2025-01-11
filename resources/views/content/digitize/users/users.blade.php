@extends('layouts/layoutMaster')

@section('title', 'Users')

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

    {{-- Datatables --}}
    <!-- Optional: jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.js"></script>
    <!-- Optional: Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    {{-- Export --}}


    <div class="row g-6">


    </div>

    <!-- DataTable with Buttons -->
    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Users List</h5>
                    </div>

                    <div class="dt-action-buttons text-end pt-6 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-label-primary dropdown-toggle me-4 waves-effect waves-light border-none"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="ti ti-file-export ti-xs me-sm-1"></i>
                                        <span class="d-none d-sm-inline-block">Export</span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportPrint">
                                            <i class="ti ti-printer me-1"></i>Print
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportCsv">
                                            <i class="ti ti-file-text me-1"></i>Csv
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportExcel">
                                            <i class="ti ti-file-spreadsheet me-1"></i>Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportPdf">
                                            <i class="ti ti-file-description me-1"></i>Pdf
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportCopy">
                                            <i class="ti ti-copy me-1"></i>Copy
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <button class="btn btn-secondary create-new btn-primary waves-effect waves-light" type="button"
                                {{-- data-bs-toggle="modal" data-bs-target="#AddNewLabel" aria-controls="AddNewLabel" --}}>
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New User</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to add new user -->
    <div class="modal fade" id="AddNewLabel" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Labels</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('labs-label-create') }}" enctype="multipart/form-data"
                        class="AddNewLabel pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="AddNewLabel">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                        <div class="card-body">
                            <div class="mb-3">
                                {{-- <label for="node" class="form-label">Jenis Belanja</label> --}}
                                <select class="form-select" id="brand" aria-label="Default select example"
                                    name="brand">
                                    <option selected="">Select Brand</option>
                                    <option value="Rishabh">Rishabh</option>
                                    <option value="Accuenergy">Accuenergy</option>
                                    <option value="Camille Bauer">Camille Bauer</option>
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="customer" name="customer"
                                    placeholder="PT. LyZer Tech" aria-label="DE96" aria-describedby="customerHelp">
                                <label for="customer">Customer</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="PO" name="PO"
                                    placeholder="2303 12341234" aria-describedby="POHelp">
                                <label for="PO">PO Number</label>
                                {{-- <div id="POHelp" class="form-text">We'll never share your details with anyone else.</div> --}}
                            </div>
                            <div class="row g-1" id="dynamicTypeQty">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="type" name="type[]"
                                            placeholder="DE96" aria-label="DE96" aria-describedby="typeHelp">
                                        <label for="type">Type</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="scale" name="scale[]"
                                            placeholder="10" aria-label="DE96" aria-describedby="scaleHelp">
                                        <label for="scale">Scale</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="input" name="input[]"
                                            placeholder="10" aria-label="DE96" aria-describedby="inputHelp">
                                        <label for="input">Input</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="qty" name="qty[]"
                                            placeholder="10" aria-label="DE96" aria-describedby="qtyHelp">
                                        <label for="qty">Quantity</label>
                                    </div>
                                </div>
                                <div class="col-1 d-flex justify-content-center mx-1">
                                    {{-- <span class="input-group-text btn btn-outline-danger" onclick="removeTypeQty(this)">
                                <i class="fa-solid fa-trash"></i>
                              </span> --}}
                                </div>
                                <div id="typeHelp" class="form-text mx-4" onclick="addTypeQty()">Add More</div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <input type="hidden">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- users-table -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#users-table')) {
                $('#users-table').DataTable().destroy();
            }

            // Initialize DataTable with buttons for export
            $('#users-table').DataTable({
                serverSide: true,
                ajax: '{{ route('users-data') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id',
                        render: function(data, type, row) {
                            // Map role_id to their corresponding role names
                            const roles = {
                                1: 'IT Dev.',
                                2: 'President Director',
                                4: 'Sales'
                            };
                            // Return the role name or a default value
                            return roles[data] || 'Unknown Role';
                        }
                    },
                    {
                        data: 'email',
                        name: 'email'
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
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                // dom: 'Bfrtip',  // Define placement for buttons
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible' // Print only visible columns
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'label Table',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // Fit the table to the page width
                            var table = doc.content[1].table;

                            // Set the table widths to fit the page
                            table.widths = Array(table.body[0].length).fill(
                                '*'); // This ensures that columns take equal width

                            // Optional: Adjust the margins and font size for better fit
                            doc.pageMargins = [10, 10, 10, 15]; // Set small margins
                            doc.styles.tableHeader.fontSize = 10; // Reduce font size in header
                            doc.styles.tableBodyOdd.fontSize = 8; // Reduce font size in body
                            doc.styles.tableBodyEven.fontSize = 8; // Reduce font size in body

                            // Ensure that the table fits well in the page
                            table.layout =
                                'lightHorizontalLines'; // This adds light lines between rows
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible' // Copy only visible columns
                        }
                    }
                ]
            });

            // Optional: Bind the dropdown buttons to DataTable buttons (if you want more control)
            $('#exportPrint').click(function() {
                $('#users-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#users-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#users-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#users-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#users-table').DataTable().button('.buttons-copy').trigger();
            });
        });
    </script>

    {{-- new div label --}}
    <script>
        function addTypeQty() {
            const div = document.createElement('div');
            div.innerHTML = `
                        <div class="row g-1" id="dynamicTypeQty">
                          <div class="col">
                            <div class="form-floating">
                              <input type="text" class="form-control" id="type" name="type[]" placeholder="DE96" aria-label="DE96" aria-describedby="typeHelp">
                              <label for="type">Type</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating">
                              <input type="text" class="form-control" id="scale" name="scale[]" placeholder="10" aria-label="DE96" aria-describedby="scaleHelp">
                              <label for="scale">Scale</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating">
                              <input type="text" class="form-control" id="input" name="input[]" placeholder="10" aria-label="DE96" aria-describedby="inputHelp">
                              <label for="input">Input</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating">
                              <input type="text" class="form-control" id="qty" name="qty[]" placeholder="10" aria-label="DE96" aria-describedby="qtyHelp">
                              <label for="qty">Quantity</label>
                            </div>
                          </div>
                          <div class="col-1 d-flex justify-content-center mx-1">
                            <span class="input-group-text btn btn-outline-danger" onclick="removeTypeQty(this)">
                              <i class="fa-solid fa-trash"></i>
                            </span>
                          </div>
                          <div id="typeHelp" class="form-text mx-4" onclick="addTypeQty()">Add More</div>
                        </div>
                      `;
            document.getElementById('dynamicTypeQty').appendChild(div);
        }

        function removeTypeQty(btn) {
            // btn.parent.parentNode.remove();
            btn.closest('.row').remove();
        }
    </script>


@endsection
