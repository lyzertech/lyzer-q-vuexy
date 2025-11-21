@extends('layouts/layoutMaster')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

@section('content')

    <div class="row g-6">

        <!-- Earning Reports -->
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Rish Con M+</h5>
                        <p class="card-subtitle">Modbus Reading Result</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="border rounded p-5 mt-5">
                        <div class="row gap-4 gap-sm-0">

                            @if (!$data)
                                <div class="alert alert-danger shadow-sm">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    No data returned from python script.
                                </div>
                            @else
                                <div class="card p-4 shadow-sm border-0 rounded-4">
                                    <div class="row g-4">

                                        @foreach ($data as $key => $item)
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="badge rounded bg-label-primary p-1"><i
                                                            class="ti ti-currency-dollar ti-sm"></i></div>
                                                    <h6 class="mb-0 fw-normal">{{ $key }}</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h4 class="my-2">{{ $item['value'] }}</h4>
                                                    </div>
                                                    <div class="col">
                                                        <form action="{{ url('modbus/write') }}" method="POST">
                                                            @csrf

                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Register Address</label>
                                                                    <input hidden type="number" name="address"
                                                                        value="{{ $item['address'] }}" class="form-control"
                                                                        required>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Value (Float)</label>
                                                                    <input type="text" name="value"
                                                                        class="form-control" required>
                                                                </div>

                                                                <div class="col-md-4 mb-3 d-flex align-items-end">
                                                                    <button class="btn btn-primary w-100">Write to
                                                                        Modbus</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="progress w-75" style="height:4px">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%"
                                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->


    </div>

@endsection
