@extends('layouts/layoutMaster')

@section('title', 'Accuenergy AcuDC240 - Modbus Dashboard')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

@section('content')

    <div class="row g-6">

        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Accuenergy <span class="badge bg-label-primary">AcuDC240</span></h5>
                        <p class="card-subtitle">Modbus RTU — COM4 / 9600 / Unit 1</p>
                    </div>
                    <div>
                        <button type="button" id="btn-reading-measurement" class="btn btn-primary btn-md"
                            data-bs-toggle="modal" data-bs-target="#readingMeasurementModal">Reading Measurement</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="border rounded p-5 mt-5" id="modbus-alerts-wrapper">

                        <div id="modbus-alerts"></div>

                        @if (session('result'))
                            @php $res = session('result'); @endphp
                            <div class="alert alert-{{ isset($res['status']) && $res['status'] === 'ok' ? 'success' : 'danger' }} shadow-sm">
                                <i class="ti ti-alert-triangle me-2"></i>
                                {{ isset($res['message']) ? $res['message'] : (is_string($res) ? $res : json_encode($res)) }}
                            </div>
                        @endif

                        @if (empty($results))
                            <div class="alert alert-danger shadow-sm">
                                <i class="ti ti-alert-triangle me-2"></i>
                                No data returned from Python script.
                            </div>
                        @else
                            <div class="accordion" id="groupsAccordion">
                                @foreach ($results as $group)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                                            <button class="accordion-button p-3" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $loop->index }}"
                                                aria-expanded="true"
                                                aria-controls="collapse-{{ $loop->index }}">
                                                <div class="d-flex flex-column">
                                                    <strong class="me-2">{{ $group['title'] }}</strong>
                                                    <small class="text-muted">Click to expand</small>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $loop->index }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="heading-{{ $loop->index }}"
                                            data-bs-parent="#groupsAccordion">
                                            <div class="accordion-body">
                                                <div class="col-12">
                                                    <div class="row">
                                                        @if (is_array($group['data']))
                                                            @php
                                                                $firstItem = reset($group['data']);
                                                                $firstAddr = isset($firstItem['address'])
                                                                    ? (int) $firstItem['address']
                                                                    : null;
                                                                $firstVal  = isset($firstItem['value']) && !is_array($firstItem['value'])
                                                                    ? (string) $firstItem['value']
                                                                    : '';
                                                            @endphp

                                                            {{-- Group write form --}}
                                                            <div class="col-12 mb-3">
                                                                <form action="{{ url('modbus/acudc240/write') }}"
                                                                    method="POST" class="modbus-group-write-form">
                                                                    @csrf
                                                                    <input type="hidden" name="address"
                                                                        class="modbus-group-address"
                                                                        value="{{ $firstAddr }}">
                                                                    <input type="hidden" name="value"
                                                                        class="modbus-group-value"
                                                                        value="{{ $firstVal }}">
                                                                    <div class="row g-2 align-items-end">
                                                                        <div class="col-md-8 mb-2">
                                                                            <div class="text-muted small">
                                                                                Click any input below to select it,
                                                                                edit the value, then press <strong>Write</strong>.
                                                                                Or press <strong>Sync Time</strong> to set the device clock to PC time.
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 mb-2 d-flex align-items-end">
                                                                            <button type="button" id="btn-sync-time" class="btn btn-warning w-100">
                                                                                <i class="ti ti-clock-bolt me-1"></i> Sync Time
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-md-2 mb-2 d-flex align-items-end">
                                                                            <button class="btn btn-primary w-100">Write</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            @foreach ($group['data'] as $key => $item)
                                                                @if ($key === '__error')
                                                                    <div class="col-12">
                                                                        <div class="alert alert-danger shadow-sm">
                                                                            <i class="ti ti-alert-triangle me-2"></i>
                                                                            <strong>Error:</strong>
                                                                            {{ isset($item['message']) ? $item['message'] : json_encode($item) }}
                                                                            @if (isset($item['raw']))
                                                                                <pre class="mt-2 mb-0 text-danger small">{{ $item['raw'] }}</pre>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-12 col-sm-4 mb-4">
                                                                        <div class="d-flex gap-2 align-items-center">
                                                                            <div class="badge rounded bg-label-primary p-1">
                                                                                <i class="ti ti-activity ti-sm"></i>
                                                                            </div>
                                                                            <h6 class="mb-0 fw-normal">{{ $key }}</h6>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <h4 class="my-2 modbus-value"
                                                                                    data-address="{{ $item['address'] }}">
                                                                                    {{ $item['value'] }}
                                                                                </h4>
                                                                            </div>
                                                                            <div class="col">
                                                                                <form action="{{ url('modbus/acudc240/write') }}"
                                                                                    method="POST"
                                                                                    class="modbus-write-form"
                                                                                    data-address="{{ $item['address'] }}">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <input hidden type="number"
                                                                                            name="address"
                                                                                            value="{{ $item['address'] }}"
                                                                                            class="form-control" required>
                                                                                        <div class="col-md-7 mb-3">
                                                                                            <label class="form-label">Value</label>
                                                                                            @php
                                                                                                $prefill = old('value', isset($item['value']) && !is_array($item['value']) ? $item['value'] : '');
                                                                                                $inputType = isset($item['value']) && is_numeric($item['value']) ? 'number' : 'text';
                                                                                            @endphp
                                                                                            <input
                                                                                                type="{{ $inputType }}"
                                                                                                class="form-control modbus-param-input"
                                                                                                data-address="{{ $item['address'] }}"
                                                                                                value="{{ $prefill }}"
                                                                                                step="any">
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
                                                                @endif
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

    {{-- Reading Measurement Modal --}}
    <style>
        #readingMeasurementModal .modal-dialog {
            max-width: 1200px;
            width: 90vw;
        }
    </style>

    <div class="modal fade" id="readingMeasurementModal" tabindex="-1"
        aria-labelledby="readingMeasurementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
                    <h4 class="modal-title d-flex align-items-center gap-2" id="readingMeasurementModalLabel">
                        <i class="ti ti-gauge text-white"></i>
                        <span class="text-white">Reading Measurement — Accuenergy</span>
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body px-0 pb-4 pt-3 bg-light">
                    <div class="container-fluid">
                        <div id="reading-measurement-content">
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
                    <button type="button" class="btn btn-outline-primary px-4" id="btn-refresh-modal">
                        <i class="ti ti-refresh me-1"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const container = document.querySelector('.border.rounded.p-5') || document;

            // ---------------------------------------------------------------
            // Modbus cards config — used for AJAX live refresh
            // address 644 is a 16-bit integer = 1 register
            // ---------------------------------------------------------------
            const MODBUS_CARDS = [
                { address: 644, count: 6 }  // 644–649: Year, Month, Day, Hour, Minute, Second
            ];

            // AJAX read endpoint (same pattern as Rishabh)
            const READ_URL = '/modbus/acudc240/read/data/';

            // ---------------------------------------------------------------
            // Register definition for the Reading Measurement modal
            // ---------------------------------------------------------------
            const READING_LIST = {
                644: { name: "Year",   category: "Date & Time", icon: "ti-calendar",      color: "primary", unit: "" },
                645: { name: "Month",  category: "Date & Time", icon: "ti-calendar",      color: "primary", unit: "" },
                646: { name: "Day",    category: "Date & Time", icon: "ti-calendar",      color: "info",    unit: "" },
                647: { name: "Hour",   category: "Date & Time", icon: "ti-clock",         color: "success", unit: "" },
                648: { name: "Minute", category: "Date & Time", icon: "ti-clock",         color: "success", unit: "" },
                649: { name: "Second", category: "Date & Time", icon: "ti-clock",         color: "warning", unit: "" },
            };

            // --- Snapshot initial values ---
            document.querySelectorAll('.modbus-param-input').forEach(function (el) {
                const v = (el.tagName === 'SELECT')
                    ? (el.options[el.selectedIndex] ? el.options[el.selectedIndex].value : '')
                    : el.value;
                el.dataset.original = v != null ? String(v) : '';
            });

            // ---------------------------------------------------------------
            // Per-row write (modbus-write-form) — AJAX fetch
            // ---------------------------------------------------------------
            container.addEventListener('submit', function (e) {
                const form = e.target;
                if (!form || !form.classList) return;
                if (!(form.classList.contains('modbus-write-form') || form.classList.contains('modbus-group-write-form'))) return;
                e.preventDefault();

                const btn = form.querySelector('button[type="submit"]') || form.querySelector('button');
                const addrInput = form.querySelector('.modbus-group-address') || form.querySelector('[name="address"]');
                const addr = addrInput ? addrInput.value : (form.dataset.address || null);
                const valueField = form.querySelector('.modbus-group-value') || form.querySelector('[name="value"]');
                const originalBtnHtml = btn ? btn.innerHTML : null;

                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                }

                const fd = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: fd,
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                }).then(function (resp) {
                    const ct = resp.headers.get('content-type') || '';
                    if (ct.indexOf('application/json') !== -1) return resp.json();
                    return resp.text().then(function (txt) {
                        try { return JSON.parse(txt); } catch (e) { return { ok: true }; }
                    });
                }).then(function (data) {
                    const ok = !!(data && (data.status === 'ok' || data.success === true || data.ok === true));
                    const msg = (data && data.message) ? data.message : (ok ? 'Write successful' : 'Write completed');
                    let displayValue = null;
                    if (data && data.value !== undefined) displayValue = data.value;
                    else if (valueField && valueField.tagName === 'SELECT') displayValue = valueField.options[valueField.selectedIndex].text;
                    else displayValue = fd.get('value');

                    const displayEl = document.querySelector('.modbus-value[data-address="' + addr + '"]');
                    if (displayEl) displayEl.textContent = displayValue;

                    const inputEl = document.querySelector('.modbus-param-input[data-address="' + addr + '"]');
                    if (inputEl) {
                        if (inputEl.tagName !== 'SELECT') inputEl.value = fd.get('value');
                    }

                    showAlert(msg, ok ? 'success' : 'danger');
                    fetchAllGroups();
                }).catch(function (err) {
                    showAlert('Write failed: ' + (err && err.message ? err.message : 'Unknown error'), 'danger');
                }).finally(function () {
                    if (btn) { btn.disabled = false; btn.innerHTML = originalBtnHtml; }
                });
            });

            // ---------------------------------------------------------------
            // Group write (modbus-group-write-form) — batches changed inputs
            // ---------------------------------------------------------------
            container.addEventListener('submit', async function (e) {
                const form = e.target;
                if (!form || !form.classList || !form.classList.contains('modbus-group-write-form')) return;
                e.preventDefault();
                e.stopImmediatePropagation();

                const btn = form.querySelector('button[type="submit"]') || form.querySelector('button');
                const originalBtnHtml = btn ? btn.innerHTML : null;
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                }

                const groupBody = form.closest('.accordion-body');
                const inputs = groupBody ? Array.from(groupBody.querySelectorAll('.modbus-param-input')) : [];

                inputs.forEach(function (el) {
                    if (el.dataset.original === undefined) {
                        const v = (el.tagName === 'SELECT') ? (el.options[el.selectedIndex] ? el.options[el.selectedIndex].value : '') : el.value;
                        el.dataset.original = v != null ? String(v) : '';
                    }
                });

                const changes = inputs.map(function (el) {
                    const cur = (el.tagName === 'SELECT') ? (el.options[el.selectedIndex] ? el.options[el.selectedIndex].value : '') : el.value;
                    if (String(cur) !== String(el.dataset.original)) return { el, address: el.dataset.address, value: String(cur) };
                    return null;
                }).filter(Boolean);

                if (changes.length === 0) {
                    showAlert('No changes to save', 'warning');
                    if (btn) { btn.disabled = false; btn.innerHTML = originalBtnHtml; }
                    return;
                }

                const token = form.querySelector('input[name="_token"]') ? form.querySelector('input[name="_token"]').value : null;
                let success = 0, fail = 0;

                for (let c of changes) {
                    const fd = new FormData();
                    if (token) fd.append('_token', token);
                    fd.append('address', c.address);
                    fd.append('value', c.value);
                    try {
                        const resp = await fetch(form.action, {
                            method: 'POST', body: fd, credentials: 'same-origin',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        const ct = resp.headers.get('content-type') || '';
                        let data;
                        if (ct.indexOf('application/json') !== -1) data = await resp.json();
                        else { const txt = await resp.text(); try { data = JSON.parse(txt); } catch { data = { ok: true }; } }
                        const ok = !!(data && (data.status === 'ok' || data.success === true || data.ok === true));
                        if (ok) {
                            success++;
                            const displayEl = document.querySelector('.modbus-value[data-address="' + c.address + '"]');
                            const displayText = (data && data.value !== undefined) ? data.value : ((c.el.tagName === 'SELECT') ? c.el.options[c.el.selectedIndex].text : c.value);
                            if (displayEl) displayEl.textContent = displayText;
                            if (c.el.tagName !== 'SELECT') c.el.value = c.value;
                            c.el.dataset.original = String(c.value);
                        } else { fail++; }
                    } catch { fail++; }
                }

                showAlert('Saved ' + success + ' updates' + (fail ? (', ' + fail + ' failed') : ''), fail ? 'danger' : 'success');
                fetchAllGroups();
                if (btn) { btn.disabled = false; btn.innerHTML = originalBtnHtml; }
            }, true);

            // Remove per-row write buttons (group write handles everything)
            document.querySelectorAll('.modbus-write-form button').forEach(function (b) { b.remove(); });

            // --- Focus: mark active param and sync group hidden fields ---
            container.addEventListener('focusin', function (e) {
                const el = e.target;
                if (!el || !el.classList || !el.classList.contains('modbus-param-input')) return;
                const groupBody = el.closest('.accordion-body');
                if (!groupBody) return;
                const form = groupBody.querySelector('.modbus-group-write-form');
                if (!form) return;
                form.querySelector('.modbus-group-address').value = el.dataset.address;
                const valueVal = (el.tagName === 'SELECT') ? el.options[el.selectedIndex].value : el.value;
                form.querySelector('.modbus-group-value').value = valueVal;
                groupBody.querySelectorAll('.modbus-param-input').forEach(x => x.classList.remove('active-param'));
                el.classList.add('active-param');
            });

            container.addEventListener('input', function (e) {
                const el = e.target;
                if (!el || !el.classList || !el.classList.contains('modbus-param-input')) return;
                const groupBody = el.closest('.accordion-body');
                if (!groupBody) return;
                const form = groupBody.querySelector('.modbus-group-write-form');
                if (!form) return;
                const valueVal = (el.tagName === 'SELECT') ? el.options[el.selectedIndex].value : el.value;
                form.querySelector('.modbus-group-value').value = valueVal;
            });

            // ---------------------------------------------------------------
            // fetchAllGroups — refresh all card data from device
            // ---------------------------------------------------------------
            async function fetchAllGroups() {
                for (let c of MODBUS_CARDS) {
                    try {
                        const resp = await fetch(READ_URL + encodeURIComponent(c.address) + '/' + encodeURIComponent(c.count), {
                            method: 'GET', credentials: 'same-origin',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        if (!resp.ok) continue;
                        const data = await resp.json();
                        if (!data || typeof data !== 'object') continue;
                        for (let key in data) {
                            if (!data.hasOwnProperty(key)) continue;
                            const itm = data[key];
                            const addr = itm.address;
                            const val = itm.value;
                            const displayEl = document.querySelector('.modbus-value[data-address="' + addr + '"]');
                            if (displayEl) displayEl.textContent = (val === null || val === undefined) ? '' : String(val);
                            const inputEl = document.querySelector('.modbus-param-input[data-address="' + addr + '"]');
                            if (inputEl) {
                                inputEl.value = (val === null || val === undefined) ? '' : String(val);
                                inputEl.dataset.original = inputEl.value;
                            }
                        }
                    } catch (err) {
                        console.error('Failed to refresh card', c, err);
                    }
                }
                showAlert('Values refreshed from device', 'success');
            }

            // ---------------------------------------------------------------
            // showAlert — temporary toast-style alert
            // ---------------------------------------------------------------
            function showAlert(message, type) {
                const parent = document.getElementById('modbus-alerts') || document.querySelector('.border.rounded.p-5');
                if (!parent) return;
                const el = document.createElement('div');
                el.className = 'alert alert-' + (type === 'success' ? 'success' : (type === 'warning' ? 'warning' : 'danger')) + ' shadow-sm';
                el.innerHTML = '<i class="ti ti-alert-triangle me-2"></i>' + escapeHtml(message);
                parent.prepend(el);
                setTimeout(function () { el.remove(); }, 4000);
            }

            function escapeHtml(s) {
                return String(s == null ? '' : s)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // ---------------------------------------------------------------
            // Reading Measurement modal — populate with live data
            // ---------------------------------------------------------------
            async function populateModal() {
                const contentEl = document.getElementById('reading-measurement-content');
                if (!contentEl) return;
                contentEl.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="text-muted mt-3">Loading measurement data...</p></div>';

                let allData = {};
                for (let c of MODBUS_CARDS) {
                    try {
                        const resp = await fetch(READ_URL + encodeURIComponent(c.address) + '/' + encodeURIComponent(c.count), {
                            method: 'GET', credentials: 'same-origin',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        if (!resp.ok) continue;
                        const data = await resp.json();
                        if (data && typeof data === 'object') Object.assign(allData, data);
                    } catch (err) { console.error('Modal fetch error', err); }
                }

                // Group by category
                const categories = {};
                for (let addr in READING_LIST) {
                    const def = READING_LIST[addr];
                    if (!categories[def.category]) categories[def.category] = [];
                    const entry = allData[def.name] || {};
                    categories[def.category].push({
                        ...def,
                        address: Number(addr),
                        value: entry.value !== undefined ? entry.value : '—'
                    });
                }

                let html = '<div class="row g-3 px-3">';
                const colorMap = { primary: '#696cff', success: '#71dd37', warning: '#ffab00', info: '#03c3ec', danger: '#ff3e1d' };

                for (let cat in categories) {
                    html += `<div class="col-12"><h6 class="text-uppercase text-muted fw-bold small mb-2 border-bottom pb-1">${escapeHtml(cat)}</h6></div>`;
                    for (let item of categories[cat]) {
                        const color = colorMap[item.color] || '#696cff';
                        html += `
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid ${color} !important;">
                                <div class="card-body py-3 px-3">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge" style="background:${color}20; color:${color}; font-size:1rem;">
                                            <i class="ti ${escapeHtml(item.icon)}"></i>
                                        </span>
                                        <span class="text-muted small fw-semibold">${escapeHtml(item.name)}</span>
                                    </div>
                                    <div class="d-flex align-items-end gap-1">
                                        <span class="fs-4 fw-bold" style="color:${color};">${escapeHtml(String(item.value))}</span>
                                        <span class="text-muted small mb-1">${escapeHtml(item.unit)}</span>
                                    </div>
                                    <small class="text-muted" style="font-size:0.7rem;">Addr: ${item.address}</small>
                                </div>
                            </div>
                        </div>`;
                    }
                }
                html += '</div>';
                contentEl.innerHTML = html;
            }

            // Open modal → populate
            const modalEl = document.getElementById('readingMeasurementModal');
            if (modalEl) {
                modalEl.addEventListener('show.bs.modal', populateModal);
            }

            // Refresh button inside modal
            const refreshBtn = document.getElementById('btn-refresh-modal');
            if (refreshBtn) refreshBtn.addEventListener('click', populateModal);

            // ---------------------------------------------------------------
            // Sync Time — POST to server, write PC time to registers 644–649
            // ---------------------------------------------------------------
            async function syncTime() {
                const btn = document.getElementById('btn-sync-time');
                const originalHtml = btn ? btn.innerHTML : null;
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Syncing...';
                }

                // We need a CSRF token — grab it from the form in the same group
                const tokenInput = document.querySelector('.modbus-group-write-form input[name="_token"]');
                const token = tokenInput ? tokenInput.value : null;

                const fd = new FormData();
                if (token) fd.append('_token', token);

                try {
                    const resp = await fetch('/modbus/acudc240/sync-time', {
                        method: 'POST',
                        body: fd,
                        credentials: 'same-origin',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    const data = await resp.json();
                    const ok = data && (data.status === 'ok' || data.status === 'partial');
                    const msg = (data && data.message) ? data.message : (ok ? 'Time synced' : 'Sync failed');
                    showAlert(msg, data.status === 'ok' ? 'success' : (data.status === 'partial' ? 'warning' : 'danger'));
                    if (ok) fetchAllGroups();
                } catch (err) {
                    showAlert('Sync Time failed: ' + (err && err.message ? err.message : 'Unknown error'), 'danger');
                } finally {
                    if (btn) { btn.disabled = false; btn.innerHTML = originalHtml; }
                }
            }

            const syncBtn = document.getElementById('btn-sync-time');
            if (syncBtn) syncBtn.addEventListener('click', syncTime);

        });
    </script>

@endsection
