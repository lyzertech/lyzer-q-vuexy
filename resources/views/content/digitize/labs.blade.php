@extends('base.0layout')

@section('title', 'Labs')

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

      <div class="row">
        <div class="col-12 col-xl-12 mb-4">
          <div class="dt-action-buttons text-end pt-3 pt-md-0">
              <div class="dt-buttons btn-group flex-wrap">
                  <div class="btn-group">
                      <button class="btn buttons-collection dropdown-toggle btn-label-primary me-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false">
                          <span><i class="bx bx-export me-sm-1"></i>
                              <span class="d-none d-sm-inline-block">Export</span>
                          </span>
                      </button>
                  </div>
                  <button class="btn btn-secondary create-new btn-primary" data-bs-toggle="modal" data-bs-target="#newLabelModal">
                      <span><i class="bx bx-plus me-sm-1"></i>
                          <span class="d-none d-sm-inline-block">Add Labels</span>
                      </span>
                  </button>
              </div>
          </div>
        </div>

        <div class="modal fade" id="newLabelModal" tabindex="-1" aria-modal="true" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Labels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form method="post" action="{{ route('Labs_Label.create') }}" enctype="multipart/form-data" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewQuotForm">
                      @csrf <!-- CSRF protection -->
                      @method('POST')
                          <div class="card-body">
                              <div class="mb-3">
                                  {{-- <label for="node" class="form-label">Jenis Belanja</label> --}}
                                  <select class="form-select" id="brand" aria-label="Default select example" name="brand">
                                      <option selected="">Select Brand</option>
                                      <option value="Rishabh">Rishabh</option>
                                      <option value="Accuenergy">Accuenergy</option>
                                      <option value="Camille Bauer">Camille Bauer</option>
                                  </select>
                              </div>
                              <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="customer" name="customer" placeholder="PT. LyZer Tech" aria-label="DE96" aria-describedby="customerHelp">
                                <label for="customer">Customer</label>
                              </div>
                              <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="PO" name="PO" placeholder="2303 12341234" aria-describedby="POHelp">
                                  <label for="PO">PO Number</label>
                                  {{-- <div id="POHelp" class="form-text">We'll never share your details with anyone else.</div> --}}
                              </div>
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
                                  {{-- <span class="input-group-text btn btn-outline-danger" onclick="removeTypeQty(this)">
                                    <i class="fa-solid fa-trash"></i>
                                  </span> --}}
                                </div>
                                <div id="typeHelp" class="form-text mx-4" onclick="addTypeQty()">Add More</div>
                              </div>
                          </div>
                          <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <input type="hidden">
                          </div>
                  </form>
              </div>
            </div>
          </div>
        </div>

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
      </div>

      <div class="card card-datatable table-responsive mt-3">
          <table class="table table-bordered" id="label-table" data-page-length='7'>
              <thead>
                  <tr>
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

      <script type="text/javascript">
          $(document).ready(function() {
              // Destroy existing DataTable before re-initializing
              if ($.fn.DataTable.isDataTable('#label-table')) {
                  $('#label-table').DataTable().destroy();
              }

              // Initialize DataTable
              $('#label-table').DataTable({
                  serverSide: true,
                  ajax: '{{ route('Labs_Label.data') }}',
                  columns: [
                      { data: 'id_label', name: 'id_label' },
                      { data: 'brand', name: 'brand' },
                      { data: 'customer', name: 'customer' },
                      { data: 'PO', name: 'PO' },
                      { data: 'created_at', name: 'created_at' },
                      { data: 'action', name: 'action', orderable: false, searchable: false }
                  ],
                  order: [[4, 'desc']] // Order by the created_at column (index 4) in descending order
              });
          });
      </script>

      <div class="col-12 col-xl-12 mb-4">
          <div class="card h-100">
              <div class="card-header py-3">
                  <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-browser" aria-controls="navs-pills-browser" aria-selected="true">Sulist</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-os" aria-controls="navs-pills-os" aria-selected="false" tabindex="-1">Paiman</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-country" aria-controls="navs-pills-country" aria-selected="false" tabindex="-1">Maman</button>
                    </li>
                  </ul>
              </div>
              <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="card-title m-0 me-2">Topic you are interested in</h5>
                  <div class="dropdown">
                  <button class="btn p-0" type="button" id="topic" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topic">
                      <a class="dropdown-item" href="javascript:void(0);">Highest Views</a>
                      <a class="dropdown-item" href="javascript:void(0);">See All</a>
                  </div>
                  </div>
              </div>
              <div class="card-body row g-3">
                  <div class="col-md-6" style="position: relative;">
                  <div id="TAT"></div>
                  <div id="chart"></div>
                  <script>
                      document.addEventListener('DOMContentLoaded', function () {
                          const customTexts = [
                              'Routine Test < 48 hours',
                              'Comprehensive Test < 96 hours'
                          ]; // Custom text labels

                          const totalSales = 400; // Total sales value (for example)

                          const options = {
                              chart: {
                                  type: 'bar',
                                  height: 200
                              },
                              plotOptions: {
                                  bar: {
                                      horizontal: true,
                                      distributed: true,
                                      dataLabels: {
                                          position: 'center' // Set the position of the data labels
                                      }
                                  }
                              },
                              dataLabels: {
                                  enabled: true,
                                  style: {
                                      colors: ['#fff']
                                  },
                                  formatter: function (val, opt) {
                                      // const percentage = (val / totalSales) * 100;
                                      // return percentage.toFixed(2) + '%'; // Return the percentage as the label
                                      return val + ' hours'; // Return the value followed by 'hours'
                                  }
                              },
                              series: [{
                                  name: 'Turnaround Time (TAT)',
                                  data: [10, 60]
                              }],
                              xaxis: {
                                  categories: [
                                    'Routine Test',
                                    'Comprehensive Test'
                                  ],
                                  min: 0,
                                  max: 96,
                                  tickAmount: 6
                              },
                              fill: {
                                  colors: ['#F44336', '#E91E63']
                              },
                              legend: {
                                  show: true,
                                  markers: {
                                      fillColors: ['#F44336', '#E91E63']
                                  }
                              }
                          };

                          const chart = new ApexCharts(document.querySelector("#TAT"), options);
                          chart.render();
                      });
                  </script>
                  <script>
                      document.addEventListener('DOMContentLoaded', function () {
                          const customTexts = [
                            'Turnaround Time (TAT)',
                            'First-Pass Yield (FPY)',
                            'Defect Detection Rate',
                            'Equipment Utilization Rate',
                            'Compliance Rate',
                            'Customer Satisfaction',
                            'Cost Efficiency',
                            'Error Rate',
                            'Staff Training and Development'
                          ]; // Custom text labels

                          const totalSales = 400; // Total sales value (for example)

                          const options = {
                              chart: {
                                  type: 'bar',
                                  height: 450
                              },
                              plotOptions: {
                                  bar: {
                                      horizontal: true,
                                      distributed: true,
                                      dataLabels: {
                                          position: 'center' // Set the position of the data labels
                                      }
                                  }
                              },
                              dataLabels: {
                                  enabled: true,
                                  style: {
                                      colors: ['#fff']
                                  },
                                  formatter: function (val, opt) {
                                      // const percentage = (val / totalSales) * 100;
                                      // return percentage.toFixed(2) + '%'; // Return the percentage as the label
                                      return customTexts[opt.dataPointIndex]; // Return custom text from customTexts array
                                  }
                              },
                              series: [{
                                  name: 'Sales',
                                  data: [30, 95, 98, 80, 100, 90, 5, 0.5, 40]
                              }],
                              xaxis: {
                                  categories: [
                                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'
                                  ]
                              },
                              fill: {
                                  colors: ['#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#00BCC4']
                              },
                              legend: {
                                  show: true,
                                  markers: {
                                      fillColors: ['#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#00BCC4']
                                  }
                              }
                          };

                          const chart = new ApexCharts(document.querySelector("#chart"), options);
                          chart.render();
                      });
                  </script>


                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 724px; height: 313px;"></div></div><div class="contract-trigger"></div></div></div>
                  <div class="col-md-6 d-flex justify-content-around align-items-center">
                  <div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-primary me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Turnaround Time (TAT)</p>
                          <h5>Target: < 48 hours for routine tests, < 96 hours for comprehensive tests.</h5>
                          <small>Measurement: Time logs from LIMS.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-success me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">First-Pass Yield (FPY)</p>
                          <h5>Target: ≥ 95%</h5>
                          <small>Measurement: Number of devices passing initial tests divided by total devices tested.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-danger me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Defect Detection Rate</p>
                          <h5>Target: ≥ 98%</h5>
                          <small>Measurement: Number of defects found divided by total devices tested.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-info me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Equipment Utilization Rate</p>
                          <h5>Target: ≥ 80%</h5>
                          <small>Measurement: Equipment usage logs.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-secondary me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Compliance Rate</p>
                          <h5>Target: 100%</h5>
                          <small>Measurement: Audit reports and compliance checklists.</small>
                      </div>
                      </div>
                  </div>

                  <div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-warning me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Customer Satisfaction</p>
                          <h5>Target: ≥ 90% positive feedback.</h5>
                          <small>Measurement: Internal feedback surveys and review forms.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-warning me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Cost Efficiency</p>
                          <h5>Target: Reduction by 5% annually.</h5>
                          <small>Measurement: Financial reports comparing year-over-year costs.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-warning me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Error Rate</p>
                          <h5>Target: ≤ 0.5%</h5>
                          <small>Measurement: Error logs and incident reports.</small>
                      </div>
                      </div>
                      <div class="d-flex align-items-baseline">
                      <span class="text-warning me-2"><i class="bx bxs-circle"></i></span>
                      <div>
                          <p class="mb-2">Staff Training and Development</p>
                          <h5>Target: ≥ 40 hours per staff member.</h5>
                          <small>Measurement: Training logs and certificates.</small>
                      </div>
                      </div>
                  </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-6 order-3 order-lg-4 mb-4 mb-lg-0">
          <div class="card text-center">
            <div class="card-header py-3">
              <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-browser" aria-controls="navs-pills-browser" aria-selected="true">Browser</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-os" aria-controls="navs-pills-os" aria-selected="false" tabindex="-1">Operating System</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-country" aria-controls="navs-pills-country" aria-selected="false" tabindex="-1">Country</button>
                </li>
              </ul>
            </div>
            <div class="tab-content pt-0">
              <div class="tab-pane fade active show" id="navs-pills-browser" role="tabpanel">
                <div class="table-responsive text-start">
                  <table class="table table-borderless text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Browser</th>
                        <th>Visits</th>
                        <th class="w-50">Data In Percentage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/chrome.png" alt="Chrome" height="24" class="me-2">
                            <span>Chrome</span>
                          </div>
                        </td>
                        <td>8.92k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 84.75%" aria-valuenow="84.75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">84.75%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/safari.png" alt="Safari" height="24" class="me-2">
                            <span>Safari</span>
                          </div>
                        </td>
                        <td>7.29k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 72.43%" aria-valuenow="72.43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">72.43%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/firefox.png" alt="Firefox" height="24" class="me-2">
                            <span>Firefox</span>
                          </div>
                        </td>
                        <td>6.11k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 67.37%" aria-valuenow="67.37" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">67.37%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/edge.png" alt="Edge" height="24" class="me-2">
                            <span>Edge</span>
                          </div>
                        </td>
                        <td>5.08k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 60.12%" aria-valuenow="60.12" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">60.12%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/opera.png" alt="Opera" height="24" class="me-2">
                            <span>Opera</span>
                          </div>
                        </td>
                        <td>3.93k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 51.94%" aria-valuenow="51.94" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">51.94%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/brave.png" alt="Brave" height="24" class="me-2">
                            <span>Brave</span>
                          </div>
                        </td>
                        <td>3.19k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 39.94%" aria-valuenow="39.94" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">39.94%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/vivaldi.png" alt="Vivaldi" height="24" class="me-2">
                            <span>Vivaldi</span>
                          </div>
                        </td>
                        <td>1.29k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 28.43%" aria-valuenow="28.43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">18.43%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/uc.png" alt="UC Browser" height="24" class="me-2">
                            <span>UC Browser</span>
                          </div>
                        </td>
                        <td>328</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 20.14%" aria-valuenow="20.14" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">20.14%</small>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="navs-pills-os" role="tabpanel">
                <div class="table-responsive text-start">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>System</th>
                        <th>Visits</th>
                        <th class="w-50">Data In Percentage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/windows.png" alt="Windows" height="24" class="me-2">
                            <span>Windows</span>
                          </div>
                        </td>
                        <td>875.24k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 71.50%" aria-valuenow="71.50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">71.50%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/mac.png" alt="Mac" height="24" class="me-2">
                            <span>Mac</span>
                          </div>
                        </td>
                        <td>89.68k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 66.67%" aria-valuenow="66.67" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">66.67%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/ubuntu.png" alt="Ubuntu" height="24" class="me-2">
                            <span>Ubuntu</span>
                          </div>
                        </td>
                        <td>37.68k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 62.82%" aria-valuenow="62.82" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">62.82%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/chrome.png" alt="Chrome" height="24" class="me-2">
                            <span>Chrome</span>
                          </div>
                        </td>
                        <td>35.34k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 56.25%" aria-valuenow="56.25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">56.25%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/cent.png" alt="Cent" height="24" class="me-2">
                            <span>Cent</span>
                          </div>
                        </td>
                        <td>32.25k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 42.76%" aria-valuenow="42.76" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">42.76%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/linux.png" alt="Linux" height="24" class="me-2">
                            <span>Linux</span>
                          </div>
                        </td>
                        <td>22.15k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 37.77%" aria-valuenow="37.77" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">37.77%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/fedora.png" alt="Fedora" height="24" class="me-2">
                            <span>Fedora</span>
                          </div>
                        </td>
                        <td>1.13k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 29.16%" aria-valuenow="29.16" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">29.16%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="../../assets/img/icons/brands/vivaldi-os.png" alt="Vivaldi" height="24" class="me-2">
                            <span>Vivaldi</span>
                          </div>
                        </td>
                        <td>1.09k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 26.26%" aria-valuenow="26.26" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">26.26%</small>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="navs-pills-country" role="tabpanel">
                <div class="table-responsive text-start">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Country</th>
                        <th>Visits</th>
                        <th class="w-50">Data In Percentage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-us rounded-circle fs-3 me-2"></i>
                            <span>USA</span>
                          </div>
                        </td>
                        <td>87.24k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 89.12%" aria-valuenow="89.12" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">89.12%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-br rounded-circle fs-3 me-2"></i>
                            <span>Brazil</span>
                          </div>
                        </td>
                        <td>62.68k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 78.23%" aria-valuenow="78.23" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">78.23%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-in rounded-circle fs-3 me-2"></i>
                            <span>India</span>
                          </div>
                        </td>
                        <td>52.58k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 69.82%" aria-valuenow="69.82" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">69.82%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-au rounded-circle fs-3 me-2"></i>
                            <span>Australia</span>
                          </div>
                        </td>
                        <td>44.13k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 59.90%" aria-valuenow="59.90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">59.90%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-de rounded-circle fs-3 me-2"></i>
                            <span>Germany</span>
                          </div>
                        </td>
                        <td>32.21k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 57.11%" aria-valuenow="57.11" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">57.11%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-fr rounded-circle fs-3 me-2"></i>
                            <span>France</span>
                          </div>
                        </td>
                        <td>37.87k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 41.23%" aria-valuenow="41.23" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">41.23%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-pt rounded-circle fs-3 me-2"></i>
                            <span>Portugal</span>
                          </div>
                        </td>
                        <td>20.29k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 37.11%" aria-valuenow="37.11" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">37.11%</small>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <i class="fis fi fi-cn rounded-circle fs-3 me-2"></i>
                            <span>China</span>
                          </div>
                        </td>
                        <td>12.21k</td>
                        <td>
                          <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="progress w-100" style="height:10px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 17.61%" aria-valuenow="17.61" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-medium">17.61%</small>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
@endsection
