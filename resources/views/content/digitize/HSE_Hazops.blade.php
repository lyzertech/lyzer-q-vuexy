@extends('base.0layout')

@section('title', 'Hazops')

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

        <div class="">
            <div class="dt-action-buttons text-end pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap"> 
                    <div class="btn-group">
                        <button class="btn buttons-collection dropdown-toggle btn-label-primary me-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="bx bx-export me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Export</span>
                            </span>
                        </button>
                    </div> 
                    <button class="btn btn-secondary create-new btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <span><i class="bx bx-plus me-sm-1"></i> 
                            <span class="d-none d-sm-inline-block">Add Hazops</span>
                        </span>
                    </button> 
                </div>
            </div>
        </div>

        <div class="modal fade" id="basicModal" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">HSE Hazops</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('HSE_Hazops.create') }}" enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewQuotForm">
                        @csrf <!-- CSRF protection -->
                        @method('POST')
                            <div class="card-body">
                                <div class="mb-3">
                                    {{-- <label for="node" class="form-label">Jenis Belanja</label> --}}
                                    <select class="form-select" id="node" aria-label="Default select example" name="node">
                                        <option selected="">Select Node</option>
                                        <option value="No/Not">No/Not: Complete negation of the design intention (e.g., no flow, no reaction).</option>
                                        <option value="More">More: Quantitative increase (e.g., more flow, more pressure).</option>
                                        <option value="Less">Less: Quantitative decrease (e.g., less flow, less temperature).</option>
                                        <option value="As Well As">As Well As: Qualitative increase (e.g., additional phase, impurity).</option>
                                        <option value="Part Of">Part Of: Qualitative decrease (e.g., missing components, incomplete reaction).</option>
                                        <option value="Reverse">Reverse: Logical opposite of the design intention (e.g., reverse flow, reverse reaction).</option>
                                        <option value="Other Than">Other Than: Complete substitution (e.g., wrong material, different reaction).</option>
                                    </select>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="deviation" name="deviation" placeholder="Identify potential deviations from the design intent" aria-describedby="deviationHelp">
                                    <label for="deviation">Deviation</label>
                                    <div id="deviationHelp" class="form-text">We'll never share your details with anyone else.</div>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cause" name="cause" placeholder="Event or condition that leads to the deviation from the intended operation" aria-describedby="causeHelp">
                                    <label for="cause">Cause</label>
                                    <div id="causeHelp" class="form-text">We'll never share your details with anyone else.</div>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="consequence" name="consequence" placeholder="Possible outcomes or effects if the deviation occurs" aria-describedby="consequenceHelp">
                                    <label for="consequence">Consequence</label>
                                    <div id="consequenceHelp" class="form-text">We'll never share your details with anyone else.</div>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="safeguards" name="safeguards" placeholder="Existing controls or measures that prevent the deviation from occurring or mitigate its consequences" aria-describedby="safeguardsHelp">
                                    <label for="safeguards">Safeguards</label>
                                    <div id="safeguardsHelp" class="form-text">We'll never share your details with anyone else.</div>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="actions" name="actions" placeholder="Recommendations for additional measures to address the identified deviation" aria-describedby="actionsHelp">
                                    <label for="actions">Actions</label>
                                    <div id="actionsHelp" class="form-text">We'll never share your details with anyone else.</div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                        <input type="hidden">
                    </form>
                </div>
              </div>
            </div>
        </div>

        <div class="card card-datatable table-responsive mt-3">
            <table class="table table-bordered" id="HSE_Hazops-table" data-page-length='7'>
                <thead>
                    <tr>
                        <th>Node</th>
                        <th>Deviation</th>
                        <th>Cause</th>
                        <th>Consequence</th>
                        <th>Safeguards</th>
                        <th>Actions</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        
        <script type="text/javascript">
            $(document).ready(function() {
                // Destroy existing DataTable before re-initializing
                if ($.fn.DataTable.isDataTable('#HSE_Hazops-table')) {
                    $('#HSE_Hazops-table').DataTable().destroy();
                }
        
                // Initialize DataTable
                $('#HSE_Hazops-table').DataTable({
                    serverSide: true,
                    ajax: '{{ route('HSE_Hazops.data') }}',
                    columns: [
                        { data: 'node', name: 'node' },
                        { data: 'deviation', name: 'deviation' },
                        { data: 'cause', name: 'cause' },
                        { data: 'consequence', name: 'consequence' },
                        { data: 'safeguards', name: 'safeguards' },
                        { data: 'actions', name: 'actions' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            });
        </script>        
    </div>
@endsection