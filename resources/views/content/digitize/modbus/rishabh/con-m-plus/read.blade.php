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
                                                                                                <select name="value"
                                                                                                    class="form-control"
                                                                                                    required>
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
                                                                                                <select name="value"
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
                                                                                                    name="value"
                                                                                                    class="form-control"
                                                                                                    required step="any">
                                                                                            @endif
                                                                                        </div>

                                                                                        {{-- Submit Button --}}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.border.rounded.p-5') || document;

            container.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form || !form.classList || !form.classList.contains('modbus-write-form')) return;
                e.preventDefault();

                const btn = form.querySelector('button[type="submit"]') || form.querySelector('button');
                const addr = form.dataset.address;
                const valueField = form.querySelector('[name="value"]');
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

                    showAlert(msg, ok ? 'success' : 'danger');
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
        });
    </script>

@endsection
