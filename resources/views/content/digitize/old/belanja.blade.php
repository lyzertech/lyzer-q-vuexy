@extends('base.0layout')

@section('title', 'Belanja')

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
                        <span class="d-none d-sm-inline-block">Tambah Belanja</span>
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
                    <th>Jenis Belanja</th>
                    <th>Keterangan Barang</th>
                    <th>Total Belanja</th>
                    <th>Created At</th>
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
              <h5 class="modal-title" id="exampleModalLabel1">Belanja</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('Belanja.create') }}" enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewQuotForm">
                    @csrf <!-- CSRF protection -->
                    @method('POST')
                    <div class="card mb-4">
                        {{-- <h5 class="card-header">Belanja</h5> --}}
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="jenisBelanja" class="form-label">Jenis Belanja</label>
                                <select class="form-select" id="jenisBelanja" aria-label="Default select example" name="jenisBelanja">
                                    <option selected="">Pilih jenis belanja</option>
                                    <option value="1">Harian</option>
                                    <option value="4">Mingguan</option>
                                    <option value="2">Bulanan</option>
                                    <option value="3">Barang Mewah</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="komponenInput" name="komponen" placeholder="Beras, Telor, Kentang" aria-describedby="komponenInputHelp">
                                    <label for="komponenInput">Komponen yang dibeli</label>
                                    {{-- <div id="komponenInputHelp" class="form-text">We'll never share your details with anyone else.</div> --}}
                                </div>
                                {{-- <label for="keteranganBarang" class="form-label">Komponen yang dibeli</label> --}}
                                {{-- <div class="row gy-3">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-2 form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="berasCheckbox" name="komponen[]" value="Beras">
                                                <label class="form-check-label" for="berasCheckbox">Beras</label>
                                            </div>
                                            <div class="col-2 form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="sayurCheckbox" name="komponen[]" value="Sayur">
                                                <label class="form-check-label" for="sayurCheckbox">Sayur</label>
                                            </div>
                                            <div class="col-2 form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="gulaCheckbox" name="komponen[]" value="Gula">
                                                <label class="form-check-label" for="gulaCheckbox">Gula</label>
                                            </div>
                                            <div class="col-2 form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="minyakCheckbox" name="komponen[]" value="Minyak">
                                                <label class="form-check-label" for="minyakCheckbox">Minyak</label>
                                            </div>
                                            <div class="col-2 form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="airCheckbox" name="komponen[]" value="Air">
                                                <label class="form-check-label" for="airCheckbox">Air</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="mb-3 row">
                                <label for="totalBelanja" class="col-md-2 col-form-label">Total Belanja</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" value="" placeholder="Rp. 1.000.000" id="totalBelanja" name="totalBelanja">
                                </div>
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
                ajax: '{{ route('Belanja.data') }}',
                columns: [
                    { data: 'id_product', name: 'id_product' },
                    {
                        data: 'jenisBelanja',
                        name: 'jenisBelanja',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return 'Harian';
                            } else if (data == 2) {
                                return 'Bulanan';
                            } else if (data == 3) {
                                return 'Tahunan';
                            } else if (data == 4) {
                                return 'Mingguan';
                            } else {
                                return 'Unknown'; // Handle unexpected values gracefully
                            }
                        }
                    },
                    { data: 'keteranganBarang', name: 'keteranganBarang' },
                    { data: 'totalBelanja', name: 'totalBelanja' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[4, 'desc']] // Order by the created_at column (index 4) in descending order
            });
        });

    </script>
    
    

    

</div>
   
@endsection