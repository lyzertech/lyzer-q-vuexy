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
    <div class="d-flex align-items-stretch flex-grow-1 p-0 container-fluid">

        <div class="flex-shrink-1 flex-grow-0 w-px-350 border-end container-p-x container-p-y">
            <div class="layout-example-sidebar layout-example-content-inner">
                Sidebar
            </div>
        </div>

        <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
            <!-- Layout Demo -->
            <div class="layout-demo-wrapper">
                <div class="layout-demo-placeholder">
                    <img src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/assets/img/layouts/layout-content-navbar-and-sidebar-light.png"
                        class="img-fluid" alt="Layout content navbar + sidebar"
                        data-app-light-img="layouts/layout-content-navbar-and-sidebar-light.png"
                        data-app-dark-img="layouts/layout-content-navbar-and-sidebar-dark.png">
                </div>
                <div class="layout-demo-info">
                    <h4>Layout content navbar + sidebar</h4>
                    <p>Container layout sets a <code>max-width</code> at each responsive breakpoint.</p>
                </div>
            </div>
            <!--/ Layout Demo -->
        </div>

    </div>
@endsection
