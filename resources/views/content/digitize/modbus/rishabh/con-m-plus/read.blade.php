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
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Rish Con M+</h5>
                        <p class="card-subtitle">Modbus Reading Result</p>
                    </div>
                    <div>
                        <button type="button" id="btn-reading-measurement" class="btn btn-primary btn-md"
                            data-bs-toggle="modal" data-bs-target="#readingMeasurementModal">Reading measurement</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="border rounded p-5 mt-5">
                        <div class="row">

                            @if (session('result'))
                                @php $res = session('result'); @endphp
                                <div
                                    class="alert alert-{{ isset($res['status']) && $res['status'] === 'ok' ? 'success' : 'danger' }} shadow-sm">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    {{ isset($res['message']) ? $res['message'] : (is_string($res) ? $res : json_encode($res)) }}
                                </div>
                            @endif

                            @if (empty($results))
                                <div class="alert alert-danger shadow-sm">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    No data returned from python script.
                                </div>
                            @else
                                <div class="accordion" id="groupsAccordion">
                                    @foreach ($results as $group)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                                                <button class="accordion-button collapsed p-3" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}"
                                                    aria-expanded="false" aria-controls="collapse-{{ $loop->index }}">
                                                    <div class="d-flex flex-column">
                                                        <strong class="me-2">{{ $group['title'] }}</strong>
                                                        <small class="text-muted">Click to expand</small>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading-{{ $loop->index }}"
                                                data-bs-parent="#groupsAccordion">
                                                <div class="accordion-body">
                                                    <div class="col-12">
                                                        {{-- group content moved inside accordion body --}}
                                                        <div class="row">
                                                            @if (is_array($group['data']))
                                                                {{-- Group write form: select a parameter input below, edit inline and press Write --}}
                                                                @php
                                                                    $firstItem = reset($group['data']);
                                                                    $firstAddr = isset($firstItem['address'])
                                                                        ? (int) $firstItem['address']
                                                                        : null;
                                                                    $firstVal =
                                                                        isset($firstItem['value']) &&
                                                                        !is_array($firstItem['value'])
                                                                            ? (string) $firstItem['value']
                                                                            : '';
                                                                @endphp
                                                                <div class="col-12 mb-3">
                                                                    <form
                                                                        action="{{ url('modbus/write/' . urlencode('rish-con-m+')) }}"
                                                                        method="POST" class="modbus-group-write-form">
                                                                        @csrf
                                                                        <input type="hidden" name="address"
                                                                            class="modbus-group-address"
                                                                            value="{{ $firstAddr }}">
                                                                        <input type="hidden" name="value"
                                                                            class="modbus-group-value"
                                                                            value="{{ $firstVal }}">

                                                                        <div class="row g-2 align-items-end">
                                                                            <div class="col-md-10 mb-2">
                                                                                <div class="text-muted small">Click any
                                                                                    parameter input below to select it, edit
                                                                                    the value, then press
                                                                                    <strong>Write</strong>.
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="col-md-2 mb-2 d-flex align-items-end">
                                                                                <button
                                                                                    class="btn btn-primary w-100">Write</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                @foreach ($group['data'] as $key => $item)
                                                                    <div class="col-12 col-sm-4 mb-4">
                                                                        <div class="d-flex gap-2 align-items-center">
                                                                            <div class="badge rounded bg-label-primary p-1">
                                                                                <i class="ti ti-activity ti-sm"></i>
                                                                            </div>
                                                                            <h6 class="mb-0 fw-normal">{{ $key }}
                                                                            </h6>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <h4 class="my-2 modbus-value"
                                                                                    data-address="{{ $item['address'] }}">
                                                                                    {{ $item['value'] }}</h4>
                                                                            </div>

                                                                            <div class="col">
                                                                                <form
                                                                                    action="{{ url('modbus/write/' . urlencode('rish-con-m+')) }}"
                                                                                    method="POST" class="modbus-write-form"
                                                                                    data-address="{{ $item['address'] }}">
                                                                                    @csrf
                                                                                    <div class="row">

                                                                                        {{-- Hidden MODBUS Address --}}
                                                                                        <input hidden type="number"
                                                                                            name="address"
                                                                                            value="{{ $item['address'] }}"
                                                                                            class="form-control" required>

                                                                                        {{-- Write Value --}}
                                                                                        <div class="col-md-5 mb-3">
                                                                                            <label
                                                                                                class="form-label">Value</label>

                                                                                            @php
                                                                                                $systemTypeOptions = [
                                                                                                    1 => '1P2W',
                                                                                                    2 => '3P3W Unbal',
                                                                                                    3 => '3P4W Unbal',
                                                                                                    4 => 'U31 I1 Bal',
                                                                                                    5 => 'U23 I1 Bal',
                                                                                                    6 => 'U12 I1 Bal',
                                                                                                    7 => '3P3W Bal',
                                                                                                    8 => '3P4W Bal',
                                                                                                ];

                                                                                                $paramSelectOptions = [
                                                                                                    0 => 'Volts 1',
                                                                                                    1 => 'Volts 2',
                                                                                                    2 => 'Volts 3',
                                                                                                    3 => 'Current 1',
                                                                                                    4 => 'Current 2',
                                                                                                    5 => 'Current 3',
                                                                                                    6 => 'Watt 1',
                                                                                                    7 => 'Watt 2',
                                                                                                    8 => 'Watt 3',
                                                                                                    9 => 'VA 1',
                                                                                                    10 => 'VA 2',
                                                                                                    11 => 'VA 3',
                                                                                                    12 => 'VAr 1',
                                                                                                    13 => 'VAr 2',
                                                                                                    14 => 'VAr 3',
                                                                                                    15 => 'PF 1',
                                                                                                    16 => 'PF 2',
                                                                                                    17 => 'PF 3',
                                                                                                    18 => 'PA 1',
                                                                                                    19 => 'PA 2',
                                                                                                    20 => 'PA 3',
                                                                                                    21 => 'Volts Average',
                                                                                                    23 => 'Current Average',
                                                                                                    26 => 'Watts sum',
                                                                                                    28 => 'VA sum',
                                                                                                    30 => 'VAr sum',
                                                                                                    31 => 'PF Average',
                                                                                                    33 => 'PA Average',
                                                                                                    35 => 'Frequency',
                                                                                                    84 => 'Re-Active PF L1',
                                                                                                    85 => 'Re-Active PF L2',
                                                                                                    86 => 'Re-Active PF L3',
                                                                                                    87 => 'Avg Re-Active PF',
                                                                                                    89 => 'LF SgnQ(1-(P/S)) L1',
                                                                                                    90 => 'LF SgnQ(1-(P/S)) L2',
                                                                                                    91 => 'LF SgnQ(1-(P/S)) L3',
                                                                                                    92 => 'Avg LF SgnQ(1-(P/S))',
                                                                                                    100 => 'V1-2',
                                                                                                    101 => 'V2-3',
                                                                                                    102 => 'V3-1',
                                                                                                    127 => 'Distortion VAr L1',
                                                                                                    128 => 'Distortion VAr L2',
                                                                                                    129 => 'Distortion VAr L3',
                                                                                                    131 => 'SUM Distortion VAr',
                                                                                                    150 => 'Sys kW Import Demand',
                                                                                                    151 => 'Sys kW Export Demand',
                                                                                                    152 => 'Sys kVAr Import Demand',
                                                                                                    153 => 'Sys kVAr Export Demand',
                                                                                                    154 => 'Sys kVA Demand',
                                                                                                    156 => 'Sys Current Demand',
                                                                                                    158 => 'Sys kW Import Max Demand',
                                                                                                    159 => 'Sys kW Export Max Demand',
                                                                                                    160 => 'Sys kVAr Import Max Demand',
                                                                                                    161 => 'Sys kVAr Export Max Demand',
                                                                                                    162 => 'Sys kVA Max Demand',
                                                                                                    164 => 'Sys Current Max Demand',
                                                                                                    167 => 'kW Import Demand L1',
                                                                                                    168 => 'kW Import Demand L2',
                                                                                                    169 => 'kW Import Demand L3',
                                                                                                    170 => 'kW Export Demand L1',
                                                                                                    171 => 'kW Export Demand L2',
                                                                                                    172 => 'kW Export Demand L3',
                                                                                                    173 => 'kVAr Import Demand L1',
                                                                                                    174 => 'kVAr Import Demand L2',
                                                                                                    175 => 'kVAr Import Demand L3',
                                                                                                    176 => 'kVAr Export Demand L1',
                                                                                                    177 => 'kVAr Export Demand L2',
                                                                                                    178 => 'kVAr Export Demand L3',
                                                                                                    179 => 'kVA Demand L1',
                                                                                                    180 => 'kVA Demand L2',
                                                                                                    181 => 'kVA Demand L3',
                                                                                                    184 => 'Current Demand L1',
                                                                                                    185 => 'Current Demand L2',
                                                                                                    186 => 'Current Demand L3',
                                                                                                    190 => 'kW Import Max Demand L1',
                                                                                                    191 => 'kW Import Max Demand L2',
                                                                                                    192 => 'kW Import Max Demand L3',
                                                                                                    193 => 'kW Export Max Demand L1',
                                                                                                    194 => 'kW Export Max Demand L2',
                                                                                                    195 => 'kW Export Max Demand L3',
                                                                                                    196 => 'kVAr Import Max Demand L1',
                                                                                                    197 => 'kVAr Import Max Demand L2',
                                                                                                    198 => 'kVAr Import Max Demand L3',
                                                                                                    199 => 'kVAr Export Max Demand L1',
                                                                                                    200 => 'kVAr Export Max Demand L2',
                                                                                                    201 => 'kVAr Export Max Demand L3',
                                                                                                    202 => 'kVA Max Demand L1',
                                                                                                    203 => 'kVA Max Demand L2',
                                                                                                    204 => 'kVA Max Demand L3',
                                                                                                    208 => 'Current Max Demand L1',
                                                                                                    209 => 'Current Max Demand L2',
                                                                                                    210 => 'Current Max Demand L3',
                                                                                                ];
                                                                                            @endphp

                                                                                            @if (isset($item['address']) && (int) $item['address'] === 6002)
                                                                                                @php $currentValue = isset($item['value']) ? (string)$item['value'] : ''; @endphp
                                                                                                <select
                                                                                                    class="form-control modbus-param-input"
                                                                                                    data-address="{{ $item['address'] }}">
                                                                                                    @foreach ($systemTypeOptions as $val => $label)
                                                                                                        <option
                                                                                                            value="{{ $val }}"
                                                                                                            {{ $currentValue === (string) $val || $currentValue === (string) $label ? 'selected' : '' }}>
                                                                                                            {{ $label }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            @elseif(isset($item['address']) && in_array((int) $item['address'], [6250, 6268, 6286, 6304]))
                                                                                                @php $currentValue = isset($item['value']) ? (string)$item['value'] : ''; @endphp
                                                                                                <select
                                                                                                    class="form-control modbus-param-input"
                                                                                                    data-address="{{ $item['address'] }}"
                                                                                                    class="form-control"
                                                                                                    required>
                                                                                                    @foreach ($paramSelectOptions as $val => $label)
                                                                                                        <option
                                                                                                            value="{{ $val }}"
                                                                                                            {{ $currentValue === (string) $val || $currentValue === (string) $label ? 'selected' : '' }}>
                                                                                                            {{ $label }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            @else
                                                                                                @php
                                                                                                    $prefill = old(
                                                                                                        'value',
                                                                                                        isset(
                                                                                                            $item[
                                                                                                                'value'
                                                                                                            ],
                                                                                                        ) &&
                                                                                                        !is_array(
                                                                                                            $item[
                                                                                                                'value'
                                                                                                            ],
                                                                                                        )
                                                                                                            ? $item[
                                                                                                                'value'
                                                                                                            ]
                                                                                                            : '',
                                                                                                    );
                                                                                                    $inputType =
                                                                                                        isset(
                                                                                                            $item[
                                                                                                                'value'
                                                                                                            ],
                                                                                                        ) &&
                                                                                                        is_numeric(
                                                                                                            $item[
                                                                                                                'value'
                                                                                                            ],
                                                                                                        )
                                                                                                            ? 'number'
                                                                                                            : 'text';
                                                                                                @endphp
                                                                                                <input
                                                                                                    type="{{ $inputType }}"
                                                                                                    class="form-control modbus-param-input"
                                                                                                    data-address="{{ $item['address'] }}"
                                                                                                    value="{{ $prefill }}"
                                                                                                    step="any">
                                                                                            @endif
                                                                                        </div>


                                                                                        <div
                                                                                            class="col-md-5 mb-3 d-flex align-items-end">
                                                                                            <button
                                                                                                class="btn btn-primary w-100">Write</button>
                                                                                        </div>

                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>

                                                                        <div class="progress w-75" style="height:6px">
                                                                            <div class="progress-bar" role="progressbar"
                                                                                style="width: 100%" aria-valuenow="100"
                                                                                aria-valuemin="0" aria-valuemax="100">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="col-12">
                                                                    <div class="text-muted">No data for this section.</div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->


    </div>

    <!-- Reading measurement modal - Redesigned -->
    <style>
        /* Make the modal wider and allow more columns in the grid */
        #readingMeasurementModal .modal-dialog {
            max-width: 1200px;
            width: 90vw;
        }

        @media (min-width: 1200px) {
            #readingMeasurementModal .row.g-4 {
                display: flex;
                flex-wrap: nowrap;
                gap: 1.5rem;
            }

            /* #readingMeasurementModal .col-xl-3 {
                                                                                                                                                                                        flex: 0 0 16.6667%;
                                                                                                                                                                                        max-width: 16.6667%;
                                                                                                                                                                                    } */
        }
    </style>
    <div class="modal fade" id="readingMeasurementModal" tabindex="-1" aria-labelledby="readingMeasurementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
                    <h4 class="modal-title d-flex align-items-center gap-2" id="readingMeasurementModalLabel">
                        <i class="ti ti-gauge text-white"></i>
                        <span class="text-white">Reading Measurement</span>
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body px-0 pb-4 pt-3 bg-light">
                    <div class="container-fluid">
                        <div id="reading-measurement-content">
                            <!-- Loading state -->
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted mt-3">Loading measurement data...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white rounded-bottom-4 px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.border.rounded.p-5') || document;
            // Configuration: addresses and counts for each card to refresh after writes
            const MODBUS_CARDS = [{
                    address: 6002,
                    count: 40
                },
                {
                    address: 6248,
                    count: 18
                },
                {
                    address: 6266,
                    count: 18
                },
                {
                    address: 6284,
                    count: 18
                },
                {
                    address: 6302,
                    count: 18
                }
            ];
            // Snapshot initial values for inline inputs so we can detect changes later
            document.querySelectorAll('.modbus-param-input').forEach(function(el) {
                const v = (el.tagName === 'SELECT') ? (el.options[el.selectedIndex] ? el.options[el
                    .selectedIndex].value : '') : el.value;
                el.dataset.original = v !== undefined && v !== null ? String(v) : '';
            });

            container.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form || !form.classList) return;
                if (!(form.classList.contains('modbus-write-form') || form.classList.contains(
                        'modbus-group-write-form'))) return;
                e.preventDefault();

                const btn = form.querySelector('button[type="submit"]') || form.querySelector('button');
                const addrInput = form.querySelector('.modbus-group-address') || form.querySelector(
                    '[name="address"]');
                const addr = addrInput ? addrInput.value : (form.dataset.address || null);
                const valueField = form.querySelector('.modbus-group-value') || form.querySelector(
                    '[name="value"]');


                const originalBtnHtml = btn ? btn.innerHTML : null;
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                }

                const fd = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: fd,
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }).then(function(resp) {
                    const ct = resp.headers.get('content-type') || '';
                    if (ct.indexOf('application/json') !== -1) return resp.json();
                    return resp.text().then(function(txt) {
                        try {
                            return JSON.parse(txt);
                        } catch (err) {
                            return {
                                ok: true
                            };
                        }
                    });
                }).then(function(data) {
                    const ok = !!(data && (data.status === 'ok' || data.success === true || data
                        .ok === true));
                    const msg = (data && data.message) ? data.message : (ok ? 'Write successful' :
                        'Write completed');
                    let displayValue = null;
                    if (data && data.value !== undefined) displayValue = data.value;
                    else if (valueField && valueField.tagName === 'SELECT') displayValue =
                        valueField.options[valueField.selectedIndex].text;
                    else displayValue = fd.get('value');

                    const displayEl = document.querySelector('.modbus-value[data-address="' + addr +
                        '"]');
                    if (displayEl) displayEl.textContent = displayValue;

                    // Update per-parameter inline input/select if present
                    const inputEl = document.querySelector('.modbus-param-input[data-address="' +
                        addr + '"]');
                    if (inputEl) {
                        const valToSet = (data && data.value !== undefined) ? ('' + data.value) : fd
                            .get('value');
                        if (inputEl.tagName === 'SELECT') {
                            for (let i = 0; i < inputEl.options.length; i++) {
                                if (String(inputEl.options[i].value) === String(valToSet) || inputEl
                                    .options[i].text === displayValue) {
                                    inputEl.selectedIndex = i;
                                    break;
                                }
                            }
                        } else {
                            inputEl.value = fd.get('value');
                        }
                    }

                    showAlert(msg, ok ? 'success' : 'danger');
                    // Refresh all groups to load latest values from device
                    fetchAllGroups();
                }).catch(function(err) {
                    showAlert('Write failed: ' + (err && err.message ? err.message :
                        'Unknown error'), 'danger');
                }).finally(function() {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;
                    }
                });
            });

            // New: capture-phase submit handler for group Write that batches changed inputs and stops the default handler
            container.addEventListener('submit', async function(e) {
                const form = e.target;
                if (!form || !form.classList || !form.classList.contains('modbus-group-write-form'))
                    return;
                e.preventDefault();
                e.stopImmediatePropagation();

                const btn = form.querySelector('button[type="submit"]') || form.querySelector('button');
                const originalBtnHtml = btn ? btn.innerHTML : null;
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                }

                const groupBody = form.closest('.accordion-body');
                const inputs = groupBody ? Array.from(groupBody.querySelectorAll(
                    '.modbus-param-input')) : [];

                inputs.forEach(function(el) {
                    if (el.dataset.original === undefined) {
                        const v = (el.tagName === 'SELECT') ? (el.options[el.selectedIndex] ? el
                            .options[el.selectedIndex].value : '') : el.value;
                        el.dataset.original = v !== undefined && v !== null ? String(v) : '';
                    }
                });

                const changes = inputs.map(function(el) {
                    const cur = (el.tagName === 'SELECT') ? (el.options[el.selectedIndex] ? el
                        .options[el.selectedIndex].value : '') : el.value;
                    if (String(cur) !== String(el.dataset.original)) return {
                        el: el,
                        address: el.dataset.address,
                        value: String(cur)
                    };
                    return null;
                }).filter(Boolean);

                if (changes.length === 0) {
                    showAlert('No changes to save', 'warning');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;
                    }
                    return;
                }

                const token = form.querySelector('input[name="_token"]') ? form.querySelector(
                    'input[name="_token"]').value : null;
                let success = 0,
                    fail = 0;

                for (let c of changes) {
                    const fd = new FormData();
                    if (token) fd.append('_token', token);
                    fd.append('address', c.address);
                    fd.append('value', c.value);

                    try {
                        const resp = await fetch(form.action, {
                            method: 'POST',
                            body: fd,
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const ct = resp.headers.get('content-type') || '';
                        let data;
                        if (ct.indexOf('application/json') !== -1) data = await resp.json();
                        else {
                            const txt = await resp.text();
                            try {
                                data = JSON.parse(txt);
                            } catch (err) {
                                data = {
                                    ok: true
                                };
                            }
                        }

                        const ok = !!(data && (data.status === 'ok' || data.success === true || data
                            .ok === true));
                        if (ok) {
                            success++;
                            const displayEl = document.querySelector('.modbus-value[data-address="' + c
                                .address + '"]');
                            const displayText = (data && data.value !== undefined) ? data.value : ((c.el
                                    .tagName === 'SELECT') ? c.el.options[c.el.selectedIndex].text :
                                c.value);
                            if (displayEl) displayEl.textContent = displayText;
                            if (c.el.tagName !== 'SELECT') c.el.value = c.value;
                            c.el.dataset.original = String(c.value);
                        } else {
                            fail++;
                        }
                    } catch (err) {
                        fail++;
                    }
                }

                showAlert('Saved ' + success + ' updates' + (fail ? (', ' + fail + ' failed') : ''),
                    fail ? 'danger' : 'success');
                // Refresh all groups to load latest values from device
                fetchAllGroups();
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnHtml;
                }
            }, true);
            document.querySelectorAll('.modbus-write-form button').forEach(function(b) {
                b.remove();
            });

            // When inline parameter inputs receive focus, mark active and update group's hidden fields
            container.addEventListener('focusin', function(e) {
                const el = e.target;
                if (!el || !el.classList) return;
                if (!el.classList.contains('modbus-param-input')) return;
                const groupBody = el.closest('.accordion-body');
                if (!groupBody) return;
                const form = groupBody.querySelector('.modbus-group-write-form');
                if (!form) return;
                form.querySelector('.modbus-group-address').value = el.dataset.address;
                const valueVal = (el.tagName === 'SELECT') ? el.options[el.selectedIndex].value : el.value;
                form.querySelector('.modbus-group-value').value = valueVal;
                groupBody.querySelectorAll('.modbus-param-input').forEach(function(x) {
                    x.classList.remove('active-param');
                });
                el.classList.add('active-param');
            });

            container.addEventListener('input', function(e) {
                const el = e.target;
                if (!el || !el.classList) return;
                if (!el.classList.contains('modbus-param-input')) return;
                const groupBody = el.closest('.accordion-body');
                if (!groupBody) return;
                const form = groupBody.querySelector('.modbus-group-write-form');
                if (!form) return;
                const valueVal = (el.tagName === 'SELECT') ? el.options[el.selectedIndex].value : el.value;
                form.querySelector('.modbus-group-value').value = valueVal;
            });

            // Fetch fresh data for each configured card and update displayed values/inputs
            async function fetchAllGroups() {
                for (let c of MODBUS_CARDS) {
                    try {
                        const resp = await fetch('/modbus/read/data/' + encodeURIComponent(c.address) + '/' +
                            encodeURIComponent(c.count), {
                                method: 'GET',
                                credentials: 'same-origin',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            });
                        if (!resp.ok) continue;
                        const data = await resp.json();
                        if (!data || typeof data !== 'object') continue;
                        for (let key in data) {
                            if (!data.hasOwnProperty(key)) continue;
                            const itm = data[key];
                            const addr = itm.address;
                            const val = itm.value;
                            const displayEl = document.querySelector('.modbus-value[data-address="' + addr +
                                '"]');
                            if (displayEl) displayEl.textContent = (val === null || val === undefined) ? '' :
                                String(val);
                            const inputEl = document.querySelector('.modbus-param-input[data-address="' + addr +
                                '"]');
                            if (inputEl) {
                                if (inputEl.tagName === 'SELECT') {
                                    let set = false;
                                    for (let i = 0; i < inputEl.options.length; i++) {
                                        if (String(inputEl.options[i].value) === String(val) || inputEl.options[
                                                i].text === String(val)) {
                                            inputEl.selectedIndex = i;
                                            set = true;
                                            break;
                                        }
                                    }
                                    if (!set) {
                                        for (let i = 0; i < inputEl.options.length; i++) {
                                            if (inputEl.options[i].text === String(val)) {
                                                inputEl.selectedIndex = i;
                                                break;
                                            }
                                        }
                                    }
                                    inputEl.dataset.original = inputEl.options[inputEl.selectedIndex] ? String(
                                        inputEl.options[inputEl.selectedIndex].value) : '';
                                } else {
                                    inputEl.value = (val === null || val === undefined) ? '' : String(val);
                                    inputEl.dataset.original = inputEl.value;
                                }
                            }
                        }
                    } catch (err) {
                        console.error('Failed to refresh card', c, err);
                    }
                }
                // Notify user briefly
                showAlert('Values refreshed from device', 'success');
            }

            function showAlert(message, type) {
                const parent = document.getElementById('modbus-alerts') || document.querySelector(
                    '.border.rounded.p-5');
                if (!parent) return;
                const el = document.createElement('div');
                el.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger') + ' shadow-sm';
                el.innerHTML = '<i class="ti ti-alert-triangle me-2"></i>' + message;
                parent.prepend(el);
                setTimeout(function() {
                    el.remove();
                }, 4000);
            }

            // Small helper to escape strings we inject into the DOM
            function escapeHtml(s) {
                return String(s === null || s === undefined ? '' : s)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Populate Reading measurement modal with grouped card layout
            const READING_LIST = {
                0: {
                    name: "Voltage L1",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                2: {
                    name: "Voltage L2",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                4: {
                    name: "Voltage L3",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                200: {
                    name: "Voltage L12",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                202: {
                    name: "Voltage L23",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                204: {
                    name: "Voltage L31",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                70: {
                    name: "Frequency",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "Hz"
                },
                42: {
                    name: "Voltage System",
                    category: "Voltage",
                    icon: "ti-bolt",
                    color: "primary",
                    unit: "V"
                },
                6: {
                    name: "Current L1",
                    category: "Current",
                    icon: "ti-activity",
                    color: "info",
                    unit: "A"
                },
                8: {
                    name: "Current L2",
                    category: "Current",
                    icon: "ti-activity",
                    color: "info",
                    unit: "A"
                },
                10: {
                    name: "Current L3",
                    category: "Current",
                    icon: "ti-activity",
                    color: "info",
                    unit: "A"
                },
                46: {
                    name: "Current System",
                    category: "Current",
                    icon: "ti-activity",
                    color: "info",
                    unit: "A"
                },
                12: {
                    name: "Watt L1",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "warning",
                    unit: "W"
                },
                14: {
                    name: "Watt L2",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "warning",
                    unit: "W"
                },
                16: {
                    name: "Watt L3",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "warning",
                    unit: "W"
                },
                52: {
                    name: "Watt System",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "warning",
                    unit: "W"
                },
                18: {
                    name: "VA L1",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "success",
                    unit: "VA"
                },
                20: {
                    name: "VA L2",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "success",
                    unit: "VA"
                },
                22: {
                    name: "VA L3",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "success",
                    unit: "VA"
                },
                56: {
                    name: "VA System",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "success",
                    unit: "VA"
                },
                24: {
                    name: "VAr L1",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "danger",
                    unit: "VAr"
                },
                26: {
                    name: "VAr L2",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "danger",
                    unit: "VAr"
                },
                28: {
                    name: "VAr L3",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "danger",
                    unit: "VAr"
                },
                60: {
                    name: "VAr System",
                    category: "Power",
                    icon: "ti-bolt",
                    color: "danger",
                    unit: "VAr"
                },
                30: {
                    name: "PF L1",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: ""
                },
                32: {
                    name: "PF L2",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: ""
                },
                34: {
                    name: "PF L3",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: ""
                },
                62: {
                    name: "PF System",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: ""
                },
                36: {
                    name: "PA L1",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: "°"
                },
                38: {
                    name: "PA L2",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: "°"
                },
                40: {
                    name: "PA L3",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: "°"
                },
                66: {
                    name: "PA System",
                    category: "PF and Angle",
                    icon: "ti-angle",
                    color: "secondary",
                    unit: "°"
                }
            };

            // const READING_LIST = {
            //     0: {
            //         name: "Voltage L1",
            //         category: "Voltage LN",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     2: {
            //         name: "Voltage L2",
            //         category: "Voltage LN",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     4: {
            //         name: "Voltage L3",
            //         category: "Voltage LN",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     200: {
            //         name: "Voltage L12",
            //         category: "Voltage LL",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     202: {
            //         name: "Voltage L23",
            //         category: "Voltage LL",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     204: {
            //         name: "Voltage L31",
            //         category: "Voltage LL",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     70: {
            //         name: "Frequency",
            //         category: "Voltage LL",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "Hz"
            //     },
            //     42: {
            //         name: "Voltage System",
            //         category: "Voltage LN",
            //         icon: "ti-bolt",
            //         color: "primary",
            //         unit: "V"
            //     },
            //     6: {
            //         name: "Current L1",
            //         category: "Current",
            //         icon: "ti-activity",
            //         color: "info",
            //         unit: "A"
            //     },
            //     8: {
            //         name: "Current L2",
            //         category: "Current",
            //         icon: "ti-activity",
            //         color: "info",
            //         unit: "A"
            //     },
            //     10: {
            //         name: "Current L3",
            //         category: "Current",
            //         icon: "ti-activity",
            //         color: "info",
            //         unit: "A"
            //     },
            //     46: {
            //         name: "Current System",
            //         category: "Current",
            //         icon: "ti-activity",
            //         color: "info",
            //         unit: "A"
            //     },
            //     12: {
            //         name: "Watt L1",
            //         category: "Active Power",
            //         icon: "ti-bolt",
            //         color: "warning",
            //         unit: "W"
            //     },
            //     14: {
            //         name: "Watt L2",
            //         category: "Active Power",
            //         icon: "ti-bolt",
            //         color: "warning",
            //         unit: "W"
            //     },
            //     16: {
            //         name: "Watt L3",
            //         category: "Active Power",
            //         icon: "ti-bolt",
            //         color: "warning",
            //         unit: "W"
            //     },
            //     52: {
            //         name: "Watt System",
            //         category: "Active Power",
            //         icon: "ti-bolt",
            //         color: "warning",
            //         unit: "W"
            //     },
            //     18: {
            //         name: "VA L1",
            //         category: "Apparent Power",
            //         icon: "ti-bolt",
            //         color: "success",
            //         unit: "VA"
            //     },
            //     20: {
            //         name: "VA L2",
            //         category: "Apparent Power",
            //         icon: "ti-bolt",
            //         color: "success",
            //         unit: "VA"
            //     },
            //     22: {
            //         name: "VA L3",
            //         category: "Apparent Power",
            //         icon: "ti-bolt",
            //         color: "success",
            //         unit: "VA"
            //     },
            //     56: {
            //         name: "VA System",
            //         category: "Apparent Power",
            //         icon: "ti-bolt",
            //         color: "success",
            //         unit: "VA"
            //     },
            //     24: {
            //         name: "VAr L1",
            //         category: "Reactive Power",
            //         icon: "ti-bolt",
            //         color: "danger",
            //         unit: "VAr"
            //     },
            //     26: {
            //         name: "VAr L2",
            //         category: "Reactive Power",
            //         icon: "ti-bolt",
            //         color: "danger",
            //         unit: "VAr"
            //     },
            //     28: {
            //         name: "VAr L3",
            //         category: "Reactive Power",
            //         icon: "ti-bolt",
            //         color: "danger",
            //         unit: "VAr"
            //     },
            //     60: {
            //         name: "VAr System",
            //         category: "Reactive Power",
            //         icon: "ti-bolt",
            //         color: "danger",
            //         unit: "VAr"
            //     },
            //     30: {
            //         name: "PF L1",
            //         category: "Power Factor",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: ""
            //     },
            //     32: {
            //         name: "PF L2",
            //         category: "Power Factor",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: ""
            //     },
            //     34: {
            //         name: "PF L3",
            //         category: "Power Factor",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: ""
            //     },
            //     62: {
            //         name: "PF System",
            //         category: "Power Factor",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: ""
            //     },
            //     36: {
            //         name: "PA L1",
            //         category: "Phase Angle",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: "°"
            //     },
            //     38: {
            //         name: "PA L2",
            //         category: "Phase Angle",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: "°"
            //     },
            //     40: {
            //         name: "PA L3",
            //         category: "Phase Angle",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: "°"
            //     },
            //     66: {
            //         name: "PA System",
            //         category: "Phase Angle",
            //         icon: "ti-angle",
            //         color: "secondary",
            //         unit: "°"
            //     }
            // };

            const readingModal = document.getElementById('readingMeasurementModal');
            if (readingModal) {
                readingModal.addEventListener('show.bs.modal', function() {
                    const contentDiv = document.getElementById('reading-measurement-content');
                    if (!contentDiv) return;

                    // Group measurements by category
                    const categories = {};
                    Object.keys(READING_LIST).map(k => parseInt(k, 10)).sort((a, b) => a - b).forEach(
                        function(addr) {
                            const item = READING_LIST[addr];
                            if (!item || !item.name) return;
                            const cat = item.category || 'Other';
                            if (!categories[cat]) categories[cat] = [];
                            categories[cat].push({
                                address: addr,
                                ...item
                            });
                        });

                    // Build HTML structure with grouped cards
                    let html = '';
                    // Arrange categories: first row: Voltage, Current, Power Factor, Phase Angle; second row: Power, Reactive Power, Apparent Power
                    const categoryOrder = [
                        'Voltage', 'Current', 'Power', 'PF and Angle'
                        // 'Active Power', 'Reactive Power', 'Apparent Power',
                        // 'System'
                    ];

                    // const categoryOrder = [
                    //     'Voltage LN', 'Voltage LL', 'Current', 'Power Factor',
                    //     'Active Power', 'Reactive Power', 'Apparent Power',
                    //     'System', 'Phase Angle'
                    // ];

                    html += '<div class="row g-2">';
                    categoryOrder.forEach(function(cat) {

                        if (!categories[cat] || categories[cat].length === 0) return;
                        let items = categories[cat];
                        const firstItem = items[0];
                        const colorClass = `bg-label-${firstItem.color}`;
                        const iconClass = firstItem.icon || 'ti-gauge';

                        // Custom order for Power, PF and Angle: L1, L2, L3, System for Watt, VAr, VA, PF, PA
                        let orderedItems = items;
                        if (cat === 'Power' || cat === 'PF and Angle') {
                            const orderSuffix = ['L1', 'L2', 'L3', 'System'];
                            // For Power: Watt, VAr, VA; For PF and Angle: PF, PA
                            const typeOrder = cat === 'Power' ? ['Watt', 'VAr', 'VA'] : ['PF',
                                'PA'
                            ];
                            orderedItems = [];
                            typeOrder.forEach(type => {
                                orderSuffix.forEach(suffix => {
                                    const idx = items.findIndex(i => i.name
                                        .startsWith(type) && i.name.endsWith(
                                            suffix));
                                    if (idx !== -1) {
                                        orderedItems.push(items[idx]);
                                    }
                                });
                            });
                            // Add any remaining items (if any)
                            items.forEach(i => {
                                if (!orderedItems.includes(i)) orderedItems.push(i);
                            });
                        }

                        html += `
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-0">
                                <div class="card h-100 border-0 shadow rounded-4">
                                    <div class="card-header bg-white border-0 pb-2 pt-3 px-3 text-center">
                                        <h6 class="mb-0 d-flex flex-column align-items-center gap-1" style="font-size:1.1rem;">
                                            <span class="d-flex align-items-center justify-content-center" style="font-size:1.5rem;">
                                                <i class="ti ${iconClass} text-${firstItem.color}"></i>
                                            </span>
                                            <span class="fw-bold">${escapeHtml(cat)}</span>
                                        </h6>
                                    </div>
                                    <div class="card-body pt-2 pb-3 px-3">
                                        <div class="d-flex flex-column gap-0">
                        `;
                        orderedItems.forEach(function(item) {
                            html += `
                                            <div class="d-flex align-items-center gap-2 py-1">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 fw-semibold" style="font-size:1rem;">${escapeHtml(item.name)}</h6>
                                                    <small class="text-muted" style="font-size:0.85rem;">${item.address}</small>
                                                </div>
                                                <span class="fw-bold reading-value" data-address="${item.address}" style="font-size:1.25rem; min-width: 56px; display: flex; align-items: center;">
                                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                    <span class="text-muted">...</span>
                                                </span>
                                            </div>
                            `;
                        });
                        html += `
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';

                    contentDiv.innerHTML = html;

                    // Fetch live values for addresses 0..40 and 40..69, then merge and populate the value column
                    Promise.all([
                        fetch('/modbus/read/data/0/40', {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        }).then(function(resp) {
                            if (!resp.ok) throw new Error('HTTP ' + resp.status);
                            return resp.json();
                        }),
                        fetch('/modbus/read/data/40/40', {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        }).then(function(resp) {
                            if (!resp.ok) throw new Error('HTTP ' + resp.status);
                            return resp.json();
                        }),
                        fetch('/modbus/read/data/200/30', {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        }).then(function(resp) {
                            if (!resp.ok) throw new Error('HTTP ' + resp.status);
                            return resp.json();
                        })
                    ]).then(function(results) {
                        // results[0] = 0..39, results[1] = 40..69
                        const addrMap = {};
                        [results[0], results[1], results[2]].forEach(function(data) {
                            if (Array.isArray(data)) {
                                data.forEach(function(it) {
                                    const addr = (it && it.address !== undefined) ?
                                        String(it.address) : null;
                                    const val = (it && it.value !== undefined && it
                                            .value !== null) ? String(it.value) :
                                        '--';
                                    if (addr !== null) addrMap[addr] = val;
                                });
                            } else if (data && typeof data === 'object') {
                                for (let k in data) {
                                    if (!data.hasOwnProperty(k)) continue;
                                    const it = data[k];
                                    let addr = null;
                                    if (it && it.address !== undefined) addr = String(it
                                        .address);
                                    else if (!isNaN(Number(k))) addr = String(Number(k));
                                    const val = (it && it.value !== undefined && it
                                        .value !== null) ? String(it.value) : '--';
                                    if (addr !== null) addrMap[addr] = val;
                                }
                            }
                        });

                        // Update value displays
                        const valueElements = contentDiv.querySelectorAll('.reading-value');
                        valueElements.forEach(function(el) {
                            const addr = el.getAttribute('data-address');
                            const item = READING_LIST[parseInt(addr, 10)];
                            let val = (addr && addrMap[addr] !== undefined) ? addrMap[
                                addr] : '--';
                            let displayUnit = item.unit || '';

                            if (val === '--' || val === 'ERR') {
                                el.innerHTML = `<span class="text-muted">${val}</span>`;
                            } else {
                                // Format numeric values and adjust unit for large values
                                let numVal = parseFloat(val);
                                if (!isNaN(numVal)) {
                                    // Only adjust for W, VA, VAr
                                    if (["V", "A", "W", "VA", "VAr"].includes(
                                            displayUnit)) {
                                        if (Math.abs(numVal) >= 1000) {
                                            numVal = numVal / 1000;
                                            displayUnit = 'k' + displayUnit;
                                        } else if (Math.abs(numVal) >= 1000000) {
                                            numVal = numVal / 1000000;
                                            displayUnit = 'M' + displayUnit;
                                        }
                                    }
                                    const formattedVal = numVal.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 4
                                    });
                                    el.innerHTML =
                                        `<span class="fw-bold">${formattedVal}</span>` + (
                                            displayUnit ?
                                            `<span class="text-muted ms-1" style="font-size:1rem;">${escapeHtml(displayUnit)}</span>` :
                                            '');
                                } else {
                                    el.innerHTML =
                                        `<span class="fw-bold">${escapeHtml(val)}</span>` +
                                        (displayUnit ?
                                            `<span class="text-muted ms-1" style="font-size:1rem;">${escapeHtml(displayUnit)}</span>` :
                                            '');
                                }
                            }
                        });
                    }).catch(function(err) {
                        console.debug('Reading measurement live fetch failed', err);
                        // mark failures as ERR
                        const valueElements = contentDiv.querySelectorAll('.reading-value');
                        valueElements.forEach(function(el) {
                            el.innerHTML = '<span class="text-danger">ERR</span>';
                        });
                    });
                });
            }
        });
    </script>

@endsection
