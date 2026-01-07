@php
    $configData = Helper::appClasses();
    $isFlex = true;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Monitoring')


{{-- @section('content')

    <div class="flex-shrink-1 flex-grow-0 w-px-350 border-end container-p-x container-p-y">
        <div class="layout-example-sidebar layout-example-content-inner">
            Sidebar
        </div>
    </div>

    <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
        <!-- Layout Demo -->
        <div class="layout-demo-wrapper">
            <div class="layout-demo-placeholder">
                <img src="{{ asset('assets/img/layouts/layout-content-navbar-and-sidebar-' . $configData['style'] . '.png') }}"
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
@endsection --}}

@section('vendor-style')
    @vite('resources/assets/vendor/libs/jstree/jstree.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/jstree/jstree.js')
@endsection

@section('content')
    <div class="border-end container-p-x container-p-y" style="width: 400px; flex-shrink: 0;">
        <div class="layout-example-sidebar layout-example-content-inner">
            <div class="col-md-12 col-12">
                <div class="card mb-md-0 mb-6">
                    <h5 class="card-header">Devices</h5>
                    <div class="card-body px-4">
                        <div id="tree"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-primary mb-0">⚡ Monitoring Dashboard</h2>
                <small class="text-muted">Select a device on the left to view the latest reading (auto-refreshes)</small>
            </div>
        </div>

        <div id="data-cards" class="row g-4">
            <div class="text-center text-muted py-5">Loading data...</div>
        </div>
    </div>

    <!-- Include jsTree + jQuery for robustness (CDN fallback) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

    <!-- Make the jsTree panel scroll independently and stick in viewport -->
    <style>
        /* Sidebar stays visible and aligns with the main content */
        .layout-example-sidebar {
            position: sticky;
            top: 1rem;
            align-self: flex-start;
        }

        /* Limit height to viewport and enable internal scroll only */
        #tree {
            max-height: calc(100vh - 280px);
            /* adjust if your navbar/header height differs */
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 6px;
            /* small padding to avoid scrollbar overlap */
        }

        /* Optional: nicer thin scrollbar for wide screens */
        #tree::-webkit-scrollbar {
            width: 8px;
        }

        #tree::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.12);
            border-radius: 6px;
        }
    </style>

    <script>
        let selectedSerial = null;
        let fetchCounter = 0; // prevent out-of-order responses from overwriting newer data

        async function fetchOverallLatest() {
            // If user selected a device, don't fetch the overall latest (avoids flicker)
            if (selectedSerial) return;
            const token = ++fetchCounter;
            try {
                const res = await fetch('/api/v1/data/latest');
                const data = await res.json();
                // Only render if no newer fetch started and user still has no selection
                if (token === fetchCounter && !selectedSerial) renderData(data);
            } catch (err) {
                console.error('Error fetching overall latest:', err);
            }
        }

        async function fetchLatestForDevice(serial) {
            const token = ++fetchCounter;
            try {
                const res = await fetch(`/api/v1/data/latest?device_serial=${encodeURIComponent(serial)}`);
                const data = await res.json();
                // Only render if this fetch is the most recent and the serial is still selected (or part of selected array)
                const stillSelected = (selectedSerial === serial) || (Array.isArray(selectedSerial) && selectedSerial
                    .includes(serial));
                if (token === fetchCounter && stillSelected) renderData(data);
            } catch (err) {
                console.error('Error fetching device latest:', err);
            }
        }

        // Fetch latest for multiple devices in parallel and render combined results
        async function fetchLatestForDevices(serials) {
            if (!serials || serials.length === 0) return;
            const token = ++fetchCounter;
            try {
                const promises = serials.map(s => fetch(`/api/v1/data/latest?device_serial=${encodeURIComponent(s)}`)
                    .then(r => r.json()).catch(() => []));
                const results = await Promise.all(promises);
                // results is array of arrays (each endpoint returns an array with 0 or 1 item)
                const combined = results.flat().filter(Boolean);
                // Only render if still the most recent and selection hasn't changed
                const stillSelected = (Array.isArray(selectedSerial) && arraysEqual(serials, selectedSerial)) || (
                    serials.length === 1 && selectedSerial === serials[0]);
                if (token === fetchCounter && stillSelected) renderData(combined);
            } catch (err) {
                console.error('Error fetching multiple device latest:', err);
            }
        }

        // Helper to compare arrays (shallow, order-insensitive)
        function arraysEqual(a, b) {
            if (!Array.isArray(a) || !Array.isArray(b)) return false;
            if (a.length !== b.length) return false;
            const sa = a.slice().sort();
            const sb = b.slice().sort();
            for (let i = 0; i < sa.length; i++)
                if (sa[i] !== sb[i]) return false;
            return true;
        }

        function renderData(data) {
            const container = document.getElementById('data-cards');
            container.innerHTML = ''; // clear current cards

            if (!data || data.length === 0) {
                container.innerHTML = `<div class="text-center text-muted py-5">No data available.</div>`;
                return;
            }

            data.forEach(item => {
                const updated = new Date(item.Timestamp).toLocaleString();

                const card = document.createElement('div');
                card.className = 'col-md-11';
                card.innerHTML = `
          <div class="acuvim-full p-3 rounded shadow-sm bg-light small">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="fw-bold m-0">⚡ Acuvim Measurement Summary <small class="text-muted ms-2">${item.device_name ?? item.device_serial ?? ''}</small></h6>
              <small class="text-muted">Last Update: <b>${item.Timestamp ?? '-'}</b></small>
            </div>

            <div class="row fw-bold border-bottom pb-1 mb-1 text-center">
              <div class="col text-start">Phase</div>
              <div class="col">Voltage L-N (V)</div>
              <div class="col">Voltage L-L (V)</div>
              <div class="col">Current (A)</div>
              <div class="col">Power (kW)</div>
              <div class="col">Reactive (kvar)</div>
              <div class="col">Apparent (kVA)</div>
              <div class="col">PF</div>
            </div>

            <div class="row border-bottom pb-1 mb-1 text-center phase-r">
              <div class="col text-start fw-bold">R</div>
              <div class="col">${item.V1 ?? '-'}</div>
              <div class="col">${item.V12 ?? '-'}</div>
              <div class="col">${item.I1 ?? '-'}</div>
              <div class="col">${item.P1 ?? '-'}</div>
              <div class="col">${item.Q1 ?? '-'}</div>
              <div class="col">${item.S1 ?? '-'}</div>
              <div class="col">${item.PF1 ?? '-'}</div>
            </div>

            <div class="row border-bottom pb-1 mb-1 text-center phase-s">
              <div class="col text-start fw-bold">S</div>
              <div class="col">${item.V2 ?? '-'}</div>
              <div class="col">${item.V23 ?? '-'}</div>
              <div class="col">${item.I2 ?? '-'}</div>
              <div class="col">${item.P2 ?? '-'}</div>
              <div class="col">${item.Q2 ?? '-'}</div>
              <div class="col">${item.S2 ?? '-'}</div>
              <div class="col">${item.PF2 ?? '-'}</div>
            </div>

            <div class="row border-bottom pb-1 mb-1 text-center phase-t">
              <div class="col text-start fw-bold">T</div>
              <div class="col">${item.V3 ?? '-'}</div>
              <div class="col">${item.V31 ?? '-'}</div>
              <div class="col">${item.I3 ?? '-'}</div>
              <div class="col">${item.P3 ?? '-'}</div>
              <div class="col">${item.Q3 ?? '-'}</div>
              <div class="col">${item.S3 ?? '-'}</div>
              <div class="col">${item.PF3 ?? '-'}</div>
            </div>

            <div class="row border-bottom pb-1 mb-1 text-center phase-n">
              <div class="col text-start fw-bold">N</div>
              <div class="col">-</div>
              <div class="col">-</div>
              <div class="col">${item.In ?? '-'}</div>
              <div class="col">-</div>
              <div class="col">-</div>
              <div class="col">-</div>
              <div class="col">-</div>
            </div>

            <div class="row fw-bold align-items-center text-center phase-sum mt-1">
              <div class="col text-start">Σ / Avg</div>
              <div class="col">${item.Vnavg_V ?? '-'}</div>
              <div class="col">${item.Vlavg_V ?? '-'}</div>
              <div class="col">${item.Iavg_A ?? '-'}</div>
              <div class="col">${item.Psum_kW ?? '-'}</div>
              <div class="col">${item.Qsum_kvar ?? '-'}</div>
              <div class="col">${item.Ssum_kVA ?? '-'}</div>
              <div class="col">${item.PF ?? '-'}</div>
            </div>

            <div class="row text-center mt-3 small text-muted">
              <div class="col">Freq: <b>${item.Freq_Hz ?? '-'}</b> Hz</div>
              <div class="col">Load: <b>${item.LoadType ?? '-'}</b></div>
              <div class="col">Unbl V: <b>${item.Unbl_V ?? '-'}%</b></div>
              <div class="col">Unbl I: <b>${item.Unbl_I ?? '-'}%</b></div>
            </div>
          </div>

          <style>
            .acuvim-full {
              font-size: 0.9rem;
              background: #f9fafb;
              color: #222;
            }
            .acuvim-full .border-bottom { border-color: #dee2e6 !important; }
            .acuvim-full h6 {
              color: #333;
              border-bottom: 1px solid #ccc;
              padding-bottom: 4px;
            }
            .phase-r { background-color: rgba(255, 0, 0, 0.05); }
            .phase-s { background-color: rgba(255, 215, 0, 0.1); }
            .phase-t { background-color: rgba(0, 128, 255, 0.08); }
            .phase-n { background-color: rgba(120, 120, 120, 0.08); }
            .phase-sum { background-color: rgba(180, 180, 180, 0.12); }
            .acuvim-full b { color: #111; }
          </style>

        `;
                container.appendChild(card);
            });
        }

        // Initialize jsTree
        $(document).ready(function() {
            $.getJSON('/monitoring/analysis/data', function(data) {
                $('#tree').jstree({
                    core: {
                        themes: {
                            name: 'default'
                        },
                        data: data
                    },
                    plugins: ['types', 'wholerow', 'checkbox'],
                    checkbox: {
                        keep_selected_style: false,
                        three_state: false,
                        cascade: 'undetermined'
                    },
                    types: {
                        default: {
                            icon: 'ti ti-folder'
                        },
                        facility: {
                            icon: 'ti ti-building-community text-warning'
                        },
                        location: {
                            icon: 'ti ti-building text-success'
                        },
                        file: {
                            icon: 'ti ti-activity-heartbeat text-primary file-node'
                        }
                    }
                });
            });

            // Single-click toggles node (same behavior as Analysis/Datalog pages)
            $('#tree').on('click.jstree', '.jstree-anchor', function(e) {
                const tree = $('#tree').jstree(true);
                const node = tree.get_node(this);

                // Toggle open/close without needing double-click
                tree.toggle_node(node);
            });

            // Support multiple selection: when selection changes, get all selected device serials
            $('#tree').on('changed.jstree', function(e, data) {
                const tree = $('#tree').jstree(true);
                const selectedIds = data.selected || [];

                const serials = selectedIds.map(id => {
                    const node = tree.get_node(id);
                    if (node && node.id.startsWith('model_')) {
                        const m = node.text.match(/^(.*)\s+\((.*)\)$/);
                        return m ? m[2].trim() : null;
                    }
                    return null;
                }).filter(Boolean);

                if (serials.length === 0) {
                    selectedSerial = null;
                    fetchOverallLatest();
                } else {
                    // store the array of selected serials for polling and rendering
                    selectedSerial = serials.length === 1 ? serials[0] : serials.slice();
                    fetchLatestForDevices(serials);
                }
            });

            // Keep backward compatibility: if a single node is explicitly selected via select_node, trigger changed handler behavior
            $('#tree').on('select_node.jstree', function(e, data) {
                const node = data.node;
                if (node.id.startsWith('model_')) {
                    // do nothing here because 'changed' will already handle selection updates
                }
            });

            // Prevent page scrolling when using mouse wheel over the tree (avoids affecting right pane)
            (function() {
                const treeEl = document.getElementById('tree');
                if (!treeEl) return;

                // Use a non-passive listener to allow preventDefault()
                treeEl.addEventListener('wheel', function(e) {
                    const delta = e.deltaY;
                    const atTop = treeEl.scrollTop === 0;
                    const atBottom = Math.abs(treeEl.scrollHeight - treeEl.clientHeight - treeEl
                        .scrollTop) < 1;

                    // If we're trying to scroll past the top or bottom, prevent the event from reaching the page
                    if ((delta < 0 && atTop) || (delta > 0 && atBottom)) {
                        e.preventDefault();
                    }
                }, {
                    passive: false
                });
            })();

            // Deselect handling: if no node selected, revert to overall latest
            $('#tree').on('deselect_all.jstree', function() {
                selectedSerial = null;
                fetchOverallLatest();
            });

            // Polling loop: refresh depending on selection
            fetchOverallLatest();
            setInterval(() => {
                if (selectedSerial) {
                    // If multiple devices are selected (array), call the multi-device fetch
                    if (Array.isArray(selectedSerial)) {
                        fetchLatestForDevices(selectedSerial);
                    } else {
                        fetchLatestForDevice(selectedSerial);
                    }
                } else {
                    fetchOverallLatest();
                }
            }, 5000);
        });
    </script>
@endsection
