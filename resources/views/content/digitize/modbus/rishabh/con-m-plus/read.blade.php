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
                        <div class="row">

                            @if (!$results)
                                <div class="alert alert-danger shadow-sm">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    No data returned from python script.
                                </div>
                            @else
                                @foreach ($results as $group)
                                    <div class="col-12">
                                        <h3 class="mt-4">{{ $group['title'] }}</h3>
                                        <div class="row">
                                            @foreach ($group['data'] as $key => $item)
                                                <div class="col-12 col-sm-4 mb-4">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <div class="badge rounded bg-label-primary p-1">
                                                            <i class="ti ti-activity ti-sm"></i>
                                                        </div>
                                                        <h6 class="mb-0 fw-normal">{{ $key }}</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <h4 class="my-2">{{ $item['value'] }}</h4>
                                                        </div>

                                                        <div class="col">
                                                            <form action="{{ url('modbus/write/rish-con-m+') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="row">

                                                                    {{-- Hidden MODBUS Address --}}
                                                                    <input hidden type="number" name="address"
                                                                        value="{{ $item['address'] }}" class="form-control"
                                                                        required>

                                                                    {{-- Write Value --}}
                                                                    <div class="col-md-5 mb-3">
                                                                        <label class="form-label">Value (Float)</label>
                                                                        <input type="text" name="value"
                                                                            class="form-control" required>
                                                                    </div>

                                                                    {{-- Submit Button --}}
                                                                    <div class="col-md-5 mb-3 d-flex align-items-end">
                                                                        <button class="btn btn-primary w-100">Write</button>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="progress w-75" style="height:6px">
                                                        <div class="progress-bar" role="progressbar" style="width: 100%"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <hr>
                                    </div>
                                @endforeach

                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->


    </div>

@endsection
