@extends('base.0layout')

@section('title', 'Motor')

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
                    {{-- <button class="btn buttons-collection dropdown-toggle btn-label-primary me-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false">
                        <span><i class="bx bx-export me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Export</span>
                        </span>
                    </button> --}}
                </div>
                <button class="btn btn-secondary create-new btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                    <span><i class="bx bx-plus me-sm-1"></i>
                        <span class="d-none d-sm-inline-block">Add Service</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="card card-datatable table-responsive mt-3">
        <table class="table table-bordered" id="users-table" data-page-length='7'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Motor</th>
                    <th>User</th>
                    <th>Type Service</th>
                    <th>Total Cost</th>
                    <th>Service Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="row g-4 mb-4 mt-2">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                <div class="content-left">
                    <span>Bulan Sekarang</span>
                    <div class="d-flex align-items-end mt-2">
                    <h4 class="mb-0 me-2">Rp. {{ number_format($totalBelanja, 2, '.', ',') }}</h4>
                    <small class="text-success">(+{{ $session }}%)</small>
                    </div>
                    <p class="mb-0">Total Belanja</p>
                </div>
                <div class="avatar">
                    <span class="avatar-initial rounded bg-label-primary">
                    <i class="bx bx-user bx-sm"></i>
                    </span>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                <div class="content-left">
                    <span>Paid Users</span>
                    <div class="d-flex align-items-end mt-2">
                    <h4 class="mb-0 me-2">4,567</h4>
                    <small class="text-success">(+18%)</small>
                    </div>
                    <p class="mb-0">Last week analytics </p>
                </div>
                <div class="avatar">
                    <span class="avatar-initial rounded bg-label-danger">
                    <i class="bx bx-user-check bx-sm"></i>
                    </span>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                <div class="content-left">
                    <span>Active Users</span>
                    <div class="d-flex align-items-end mt-2">
                    <h4 class="mb-0 me-2">19,860</h4>
                    <small class="text-danger">(-14%)</small>
                    </div>
                    <p class="mb-0">Last week analytics</p>
                </div>
                <div class="avatar">
                    <span class="avatar-initial rounded bg-label-success">
                    <i class="bx bx-group bx-sm"></i>
                    </span>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                <div class="content-left">
                    <span>Pending Users</span>
                    <div class="d-flex align-items-end mt-2">
                    <h4 class="mb-0 me-2">237</h4>
                    <small class="text-success">(+42%)</small>
                    </div>
                    <p class="mb-0">Last week analytics</p>
                </div>
                <div class="avatar">
                    <span class="avatar-initial rounded bg-label-warning">
                    <i class="bx bx-user-voice bx-sm"></i>
                    </span>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="basicModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Services</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('Motor.create') }}" enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewQuotForm">
                    @csrf <!-- CSRF protection -->
                    @method('POST')
                    <div class="card mb-4">
                        {{-- <h5 class="card-header">Motor</h5> --}}
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="typeService" class="form-label">Type Service</label>
                                <div class="col-4">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="services[]" value="Oil Engine" id="oli mesin">
                                      <label class="form-check-label" for="oli mesin">
                                        Oil Engine
                                      </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="services[]" value="Throttle Body" id="TB">
                                      <label class="form-check-label" for="TB">
                                        Throttle Body
                                      </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="services[]" value="CVT" id="cvt">
                                      <label class="form-check-label" for="cvt">
                                        CVT
                                      </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="Oil Gear" id="oli gardan">
                                        <label class="form-check-label" for="oli gardan">
                                          Oil Gear
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="komponenInput" name="komponenBeli" placeholder="Roller, V-Belt, Oil" aria-describedby="komponenInputHelp">
                                    <label for="komponenInput">Purchased Components</label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="totalBelanja" class="col-md-2 col-form-label">Total Cost</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" value="" placeholder="Rp. 1.000.000" id="totalBelanja" name="totalBelanja">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-user-picture">Picture</label>
                                <input class="form-control" type="file" id="formFile" name="image">
                            </div>
                            <div class="mb-3 row">
                                <label for="serviceDate" class="col-md-2 col-form-label">Service Date</label>
                                <div class="col-md-10">
                                  <input class="form-control" type="date" id="serviceDate" name="serviceDate">
                                </div>
                                <script>
                                    document.getElementById('serviceDate').value = new Date().toISOString().split('T')[0];
                                </script>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="close" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    <input type="hidden">
                </form>
            </div>
          </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Destroy existing DataTable before re-initializing
            if ($.fn.DataTable.isDataTable('#users-table')) {
                $('#users-table').DataTable().destroy();
            }

            // Initialize DataTable
            $('#users-table').DataTable({
                serverSide: true,
                ajax: '{{ route('Motor.data') }}',
                columns: [
                    { data: 'id_motor', name: 'id_motor' },
                    { data: 'namaMotor', name: 'namaMotor' },
                    { data: 'id_user', name: 'id_user' },
                    { data: 'typeService', name: 'typeService' },
                    { data: 'totalBelanja', name: 'totalBelanja' },
                    { data: 'serviceDate', name: 'serviceDate' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']] // Order by the created_at column (index 4) in descending order
            });
        });

    </script>





</div>

@endsection
