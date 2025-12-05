@php
    $configData = Helper::appClasses();
    $isFlex = true;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Monitoring')

@section('content')
    <div class="container-fluid py-4" style="background-color:#f8fafc; min-height:100vh;">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-primary mb-0">⚡ Monitoring Dashboard</h2>
                <small class="text-muted">Auto-updating from database</small>
            </div>
        </div>

        <div id="data-cards" class="row g-4">
            <div class="text-center text-muted py-5">Loading data...</div>
        </div>
    </div>

    <script>
        async function fetchData() {
            try {
                const res = await fetch('/api/v1/data/latest');
                const data = await res.json();
                renderData(data);
            } catch (err) {
                console.error('Error fetching data:', err);
            }
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
              <h6 class="fw-bold m-0">⚡ Acuvim Measurement Summary</h6>
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

        // Refresh every 5 seconds
        fetchData();
        setInterval(fetchData, 1000);
    </script>
@endsection
