@extends('base.0layout')

@section('title', 'PO')

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
        <div class="row">
            <div class="col-md-6 order-3 order-lg-6">
                <div class="card">
                    <h5 class="card-header">Basic</h5>
                    <div class="card-body">
                        <ul class="timeline mb-0">
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <h6 class="mb-0">12 Invoices have been paid</h6>
                                        <small class="text-muted">12 min ago</small>
                                    </div>
                                    <p class="mb-2">
                                        Invoices have been paid to the company
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="badge bg-lighter rounded d-flex align-items-center">
                                            <img src="{{ asset('sneat/assets/img/icons/misc/pdf.png') }}" alt="img"
                                                width="15" class="me-2">
                                            <span class="h6 mb-0 text-body">invoices.pdf</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-success"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <h6 class="mb-0">Client Meeting</h6>
                                        <small class="text-muted">45 min ago</small>
                                    </div>
                                    <p class="mb-2">
                                        Project meeting with john @10:15am
                                    </p>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                                        <div class="d-flex flex-wrap align-items-center mb-50">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ asset('sneat/assets/img/avatars/1.png') }}" alt="Avatar"
                                                    class="rounded-circle">
                                            </div>
                                            <div>
                                                <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                                <small>CEO of ThemeSelection</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-info"></span>
                                {{-- <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <h6 class="mb-0">Received a PO for {{ $CRMPo->company }}</h6>
                                        <small class="text-muted">2 Day Ago</small>
                                    </div>
                                    <p class="mb-2">
                                        6 team members in a project
                                    </p>
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <ul
                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar pull-up"
                                                        aria-label="Vinnie Mostowy" data-bs-original-title="Vinnie Mostowy">
                                                        <img class="rounded-circle" src="{{ asset('sneat/assets/img/avatars/5.png') }}"
                                                            alt="Avatar">
                                                    </li>
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar pull-up" aria-label="Allen Rieske"
                                                        data-bs-original-title="Allen Rieske">
                                                        <img class="rounded-circle" src="{{ asset('sneat/assets/img/avatars/5.png') }}"
                                                            alt="Avatar">
                                                    </li>
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar pull-up"
                                                        aria-label="Julee Rossignol" data-bs-original-title="Julee Rossignol">
                                                        <img class="rounded-circle" src="{{ asset('sneat/assets/img/avatars/5.png') }}"
                                                            alt="Avatar">
                                                    </li>
                                                    <li class="avatar">
                                                        <span class="avatar-initial rounded-circle pull-up"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            data-bs-original-title="3 more">+3</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <h6 class="mb-0">Received a PO from {{ $CRMPo->company }}</h6>
                                        {{-- <small class="text-muted">{{ $lastUpdated->diffForHumans() }}</small> --}}
                                    </div>
                                    <p class="mb-2">
                                        PO Number : {{ $CRMPo->po_number }}
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="badge bg-lighter rounded d-flex align-items-center">
                                            <img src="{{ asset('sneat/assets/img/icons/misc/pdf.png') }}" alt="img"
                                                width="15" class="me-2">
                                            <span class="h6 mb-0 text-body mx-4">{{ $CRMPo->file_po }}</span>
                                            <a href="{{ route('po.direct_download', ['filename' => $CRMPo->file_po]) }}"
                                                class="btn btn-primary">
                                                Download File
                                            </a>
                                        </div>
                                    </div>
                                    @if ($CRMPo->status == 1)
                                        <form method="POST" action="{{ route('Po.update', $CRMPo->id_po) }}"
                                            enctype="multipart/form-data">
                                            @csrf <!-- CSRF protection -->
                                            @method('PUT')

                                            <div class="row g-6">
                                                <div class="col-sm-12">
                                                    <label for="file_po" class="form-label">File PO</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="file_po"
                                                            name="file_po" required>
                                                        <button class="btn btn-outline-primary"
                                                            type="submit">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <!-- Optionally display a message if the form is hidden -->
                                        <p class="text-muted">The File PO has already been signed on your end.</p>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
