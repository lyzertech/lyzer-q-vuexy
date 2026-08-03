@extends('layouts/layoutMaster')

@section('title', 'Labs Label')

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
                        <h5 class="card-title mb-0">Label Generator</h5>
                    </div>

                    <div class="dt-action-buttons text-end pt-6 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="btn-group">
                                <button id="btn1m" class="btn btn-primary mx-2">Latest 1 Month</button>
                                <button id="btn3m" class="btn btn-primary mx-2">Latest 3 Months</button>
                                <button id="btnYear" class="btn btn-primary mx-2">This Year</button>
                                <button id="btnAll" class="btn btn-primary mx-2">All</button>

                                <button type="button" id="btnViewSelected" class="btn btn-success mx-2" style="display:none;">
                                    <i class="ti ti-eye me-1"></i>View Selected (<span id="selectedCount">0</span>)
                                </button>

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
                                data-bs-toggle="modal" data-bs-target="#AddNewLabel" aria-controls="AddNewLabel">
                                <span><i class="ti ti-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Add New Label</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-start">
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered" id="label-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>SN</th>
                                    <th>Brand</th>
                                    <th>Customer</th>
                                    <th>PO</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to add new label -->
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
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="PO" name="PO"
                                            placeholder="2303 12341234" aria-describedby="POHelp">
                                        <label for="PO">PO Number</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="SN" name="SN"
                                            placeholder="1111" aria-describedby="SN">
                                        <label for="SN">SN</label>
                                    </div>
                                </div>
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


    <!-- label-table -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#label-table')) {
                $('#label-table').DataTable().destroy();
            }

            // Initialize DataTable with buttons for export
            var table = $('#label-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '{{ route('labs-label-data') }}',
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="form-check-input row-checkbox" data-created-at="' + row.created_at + '">';
                        }
                    },
                    {
                        data: 'id_label',
                        name: 'id_label'
                    },
                    {
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'PO',
                        name: 'PO'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
                ], // Mengurutkan berdasarkan id_label (kolom kedua setelah checkbox) secara descending
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

            // Show Latest 1 Month
            $('#btn1m').on('click', function() {
                $('#label-table').DataTable().ajax.url("{{ route('labs-label-data') }}?filter=1m").load();
            });

            // Show Latest 3 Months
            $('#btn3m').on('click', function() {
                $('#label-table').DataTable().ajax.url("{{ route('labs-label-data') }}?filter=3m").load();
            });

            // Show This Year
            $('#btnYear').on('click', function() {
                $('#label-table').DataTable().ajax.url("{{ route('labs-label-data') }}?filter=year").load();
            });

            // Show All
            $('#btnAll').on('click', function() {
                $('#label-table').DataTable().ajax.url("{{ route('labs-label-data') }}?all=1").load();
            });

            // Optional: Bind the dropdown buttons to DataTable buttons (if you want more control)
            $('#exportPrint').click(function() {
                $('#label-table').DataTable().button('.buttons-print').trigger();
            });
            $('#exportCsv').click(function() {
                $('#label-table').DataTable().button('.buttons-csv').trigger();
            });
            $('#exportExcel').click(function() {
                $('#label-table').DataTable().button('.buttons-excel').trigger();
            });
            $('#exportPdf').click(function() {
                $('#label-table').DataTable().button('.buttons-pdf').trigger();
            });
            $('#exportCopy').click(function() {
                $('#label-table').DataTable().button('.buttons-copy').trigger();
            });

            // Handle "Select All" checkbox
            $('#selectAll').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked);
                updateSelectedCount();
            });

            // Handle individual row checkbox
            $(document).on('change', '.row-checkbox', function() {
                updateSelectedCount();

                // Update "Select All" state
                var totalCheckboxes = $('.row-checkbox').length;
                var checkedCheckboxes = $('.row-checkbox:checked').length;
                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            // Update selected count and button visibility
            function updateSelectedCount() {
                var selectedDates = [];
                $('.row-checkbox:checked').each(function() {
                    var date = $(this).data('created-at');
                    if (!selectedDates.includes(date)) {
                        selectedDates.push(date);
                    }
                });

                var count = selectedDates.length;
                $('#selectedCount').text(count);

                if (count > 0) {
                    $('#btnViewSelected').show();
                } else {
                    $('#btnViewSelected').hide();
                }
            }

            // Handle "View Selected" button click
            $('#btnViewSelected').on('click', function() {
                var selectedDates = [];
                $('.row-checkbox:checked').each(function() {
                    var date = $(this).data('created-at');
                    if (!selectedDates.includes(date)) {
                        selectedDates.push(date);
                    }
                });

                if (selectedDates.length > 0) {
                    // Redirect to view page with multiple dates
                    var url = '{{ route("labs-label-view", ":dates") }}';
                    url = url.replace(':dates', selectedDates.join('|'));
                    window.open(url, '_blank');
                }
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
