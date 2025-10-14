@extends('layouts/blankLayout')

@php
    use Illuminate\Support\Str;
@endphp

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
                min-height: 1in;
                /* Letter size height */
                margin: auto;
                /* padding: 1in; */
                border: 1px solid #ffffff;
                background-color: #fff;
                position: relative;
                font-size: 10px;
                /* Change to your desired font size */
                font-family: "Swis721 Cn BT", sans-serif;
            }

            .kardus {
                font-size: 14px;
                font-family: "Consolas", monospace;
            }

            img {
                width: 150%;
                height: 80%;
                /* Scale image to 50% */
            }

            .bord2 {
                border: 0.5pt solid rgb(0, 0, 0);
                /* 0.5pt width, dashed style, light gray color */
            }

            .bord {
                border: 0.5pt dashed rgb(0, 0, 0);
            }
        </style>

        <button onclick="printArea()">Print Specific Area</button>

        <script>
            function printArea() {
                document.title =
                    "{{ '25' . $labs_label->first()->id_label . '_' . $labs_label->first()->customer . '_' . $labs_label->first()->PO . '_' . $labs_label->first()->type ?? 'DefaultFileName' }}";
                window.print();
            }
        </script>

        <div class="flex-grow-1 container-p-y container-fluid" id="printableArea">
            <div class="row letter-paper">
                <div class="col-12">
                    <div class="card-widget-separator-wrapper">
                        <div class="card-body px-2 pt-2">
                            @php
                                $chunks = $labs_label->chunk(5);
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
                                                                        <p class="mb-0 small-font">TYPE:</p>
                                                                        <p class="mb-0 small-font">SCALE:</p>
                                                                        <p class="mb-0 small-font">
                                                                            {{ Str::startsWith($Label->type, 'DS')
                                                                                ? 'INPUT: '
                                                                                : (Str::is('*/*A', $Label->input)
                                                                                    ? 'CT RATIO: '
                                                                                    : (Str::contains($Label->scale, 'kV') || Str::is('*/*V', $Label->input)
                                                                                        ? 'VT RATIO: '
                                                                                        : 'INPUT: ')) }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <p class="mb-0 small-font">{{ $Label->type }}</p>
                                                                        <p class="mb-0 small-font">{{ $Label->scale }}</p>
                                                                        <p class="mb-0 small-font">
                                                                            {{-- AC {{ $Label->input }} --}}
                                                                            {{
                                                                                Str::startsWith($Label->type, ['DE', 'RDVP', 'RDFP'])
                                                                                  ? 'AC ' . $Label->input
                                                                                  : (
                                                                                      Str::contains($Label->type, 'DS')
                                                                                          ? 'DC ' . $Label->input
                                                                                          : (
                                                                                              $Label->scale === 'LED DISPLAY'
                                                                                                  ? $Label->input
                                                                                                  : 'INPUT: '
                                                                                          )
                                                                                  )
                                                                            }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="badge d-flex justify-content-end p-0">
                                                            <img src="{{ asset('img/logo/aii.png') }}" alt="">
                                                        </span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="d-flex">
                                                        <div class="col">
                                                            <p class="mb-0 small-font d-flex justify-content-center pb-1">
                                                                {!! in_array($Label->type, ['DE96', 'DE72', 'DE48']) ? '50/60Hz' : '<br>' !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="d-flex">
                                                        <div class="col-9">
                                                            <p class="mb-0 small-font d-flex justify-content-start">
                                                                {{ in_array($Label->PO, ['2303']) ? 'Line 00001' : $Label->PO }}
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="mb-0 small-font d-flex justify-content-end">
                                                                {{ substr(date('Y'), 2) }}{{ $Label->id_label }}</p>
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

                    <div class="row">
                        <div class="col-12">
                            <div class="card-widget-separator-wrapper">
                                <div class="kardus card-body px-2 pb-2">

                                    @php
                                        $chunks = $labs_label->chunk(10); // Split the labels into chunks of 10
                                    @endphp

                                    @foreach ($chunks as $chunk)
                                        <div class="row">
                                            @foreach ($chunk as $input)
                                                <div class="col bord p-0 text-center">
                                                    {{-- {{ $input->input }} --}}
                                                    @if (Str::contains($input->input, ['A']))
                                                        {{ $input->input }}
                                                    @elseif (Str::contains($input->input, 'mV'))
                                                        {{ $input->scale }}
                                                    @elseif (Str::contains($input->input, ['kV', 'V']))
                                                        {{ $input->input }}
                                                    @else
                                                        {{ $input->scale }}
                                                    @endif
                                                </div>
                                            @endforeach

                                            @for ($i = $chunk->count(); $i < 10; $i++)
                                                <div class="col p-0 border" style="visibility: hidden;">
                                                    <div class="row"></div>
                                                </div>
                                            @endfor
                                        </div>
                                    @endforeach

                                    @if ($labs_label->first()?->customer === 'Schneider Indonesia')
                                        @php
                                            $chunks = $labs_label->chunk(6); // Split the labels into chunks of 6
                                        @endphp

                                        @foreach ($chunks as $chunk)
                                            <div class="row">
                                                @foreach ($chunk as $input)
                                                    <div class="col bord px-2">
                                                        PO {{ $input->PO }}
                                                    </div>
                                                @endforeach

                                                @for ($i = $chunk->count(); $i < 6; $i++)
                                                    <div class="col px-2 border" style="visibility: hidden;">
                                                        <div class="row"></div>
                                                    </div>
                                                @endfor
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
