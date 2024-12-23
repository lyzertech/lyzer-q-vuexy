@extends('base.0layout')

@section('title', 'Labs Label')

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

    <style>
        #printableArea {}

        @media print {

            /* Adjust the font size in the print preview */
            #printableArea {
                font-size: 6px;
                /* Change to your desired font size */
            }

            /* Optional: Hide other content during print preview */
            body * {
                visibility: hidden;
            }

            #printableArea,
            #printableArea * {
                visibility: visible;
            }

            #printableArea {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            #printableArea {
                padding: 0;
                /* Remove padding */
                border: none;
                /* Remove border */
                margin: 0;
                /* Remove margin if needed */
            }
        }

        .letter-paper {
            width: 8.5in;
            /* Letter size width */
            min-height: 10in;
            /* Letter size height */
            margin: auto;
            /* padding: 1in; */
            border: 1px solid #ccc;
            background-color: #fff;
            position: relative;
            font-size: 9px;
            /* Change to your desired font size */
        }

        img {
            width: 150%;
            height: 80%;
            /* Scale image to 50% */
        }

        .bord2 {
            border: 0.5pt solid;
            /* 0.5pt width, dashed style, light gray color */
        }

        .bord {
            border: 0.5pt dashed lightgray;
            /* 0.5pt width, dashed style, light gray color */
        }
    </style>

    <button onclick="printArea()">Print Specific Area</button>

    <script>
        function printArea() {
            window.print();
        }
    </script>

    <div class="flex-grow-1 container-p-y container-fluid" id="printableArea">
        <div class="row letter-paper">
            <div class="col-12">
                <div class="card-widget-separator-wrapper">
                    <div class="card-body p-2">
                        @php
                            $chunks = $Labs_Label->chunk(5);
                        @endphp
                        @foreach ($chunks as $chunk)
                            <div class="row">
                                @foreach ($chunk as $Label)
                                    <div class="col-sm col-lg p-1 bord">
                                        <div class="p-1 bord2">
                                            <div class="row">
                                                <div class="d-flex">
                                                    <div class="col-10">
                                                        <div class="row">
                                                            <div class="d-flex">
                                                                <div class="col-5">
                                                                    <p class="mb-0 small-font">Type</p>
                                                                    <p class="mb-0 small-font">Scale</p>
                                                                    <p class="mb-0 small-font">
                                                                        {{ in_array($Label->type, ['DE96', 'DE72']) ? 'Input' : $Label->type }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-7">
                                                                    <p class="mb-0 small-font">: {{ $Label->type }}</p>
                                                                    <p class="mb-0 small-font">: {{ $Label->scale }}</p>
                                                                    <p class="mb-0 small-font">: {{ $Label->input }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="badge d-flex justify-content-between p-0">
                                                        <img src="{{ asset('img/logo/aii.png') }}" alt="">
                                                    </span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="d-flex">
                                                    <div class="col">
                                                        <p class="mb-0 small-font d-flex justify-content-center">
                                                            {{ in_array($Label->type, ['DE96', 'DE72']) ? '50/60Hz' : $Label->type }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="d-flex">
                                                    <div class="col-9">
                                                        <p class="mb-0 small-font d-flex justify-content-start">
                                                            {{ $Label->PO }} Line 00001</p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mb-0 small-font d-flex justify-content-end">
                                                            {{ substr(date('Y'), 2) }}0{{ $Label->id_label }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Adjust column sizing if chunk count is less than 5 --}}
                                @if ($chunk->count() < 5)
                                    @php
                                        $colSize = 12 / $chunk->count(); // Dynamically adjust width
                                    @endphp
                                    @for ($i = 0; $i < 5 - $chunk->count(); $i++)
                                        <div class="col-sm col-lg p-1 border" style="visibility: hidden;">
                                            <!-- Empty placeholder to maintain spacing in row with fewer items -->
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
