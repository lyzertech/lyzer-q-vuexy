<!-- Energy -->
                    <div class="tab-pane fade show active" id="energy" role="tabpanel" aria-labelledby="energy-tab">
                        <h5 class="fw-bold mb-2">
                            <i class="ti ti-activity me-1"></i> Energy Monitoring
                        </h5>
                        <p class="text-muted mb-0">
                            Live data Energy feed updates.
                        </p>
                        <div class="tab-pane fade show active" id="energy" role="tabpanel" aria-labelledby="energy-tab">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <!-- === Time Frame Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2 my-3">
                                            <label class="form-label fw-semibold mb-0">Select a Time Frame:</label>
                                        </div>
                                        <div class="col-md-10 d-flex flex-wrap align-items-center gap-2">
                                            <select id="dateRangeSelect" class="form-select w-auto">
                                                <option value="today" selected>Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="this_week">This Week</option>
                                                <option value="custom">Custom</option>
                                            </select>

                                            <!-- Only visible if user picks Custom -->
                                            <input type="date" id="startDate" class="form-control w-auto d-none">
                                            <input type="date" id="endDate" class="form-control w-auto d-none">
                                        </div>
                                    </div>

                                    <hr class="my-3" />

                                    <!-- === Parameter Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2 my-3">
                                            <label class="form-label fw-semibold mb-0">Select a Parameter:</label>
                                        </div>
                                        <div class="col-md-10 d-flex flex-wrap align-items-center gap-4">

                                            <style>
                                                .nav-item {
                                                    /* Button spacing */
                                                    border-radius: 6px;
                                                    /* Rounded edges */
                                                    margin-right: 6px;
                                                }

                                                .nav-item .param {
                                                    border: 1px solid #E6E6E8;
                                                }
                                            </style>

                                            <!-- === PARAM TYPE BUTTONS (Active, Reactive, Apparent) === -->
                                            <div class="btn-group flex-wrap" role="group" id="paramButtonsEnergy">
                                                <ul class="nav nav-pills gap-2">

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light active"
                                                            data-param="Active">
                                                            Active
                                                        </button>
                                                    </li>

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="Reactive">
                                                            Reactive
                                                        </button>
                                                    </li>

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-param="Apparent">
                                                            Apparent
                                                        </button>
                                                    </li>

                                                </ul>
                                            </div>

                                            <!-- Divider -->
                                            <span class="vr mx-3" style="background-color:#E6E6E8;"></span>

                                            <!-- === DIRECTION BUTTONS (Import, Export, Net, Total) === -->
                                            <div class="btn-group flex-wrap" role="group" id="directionButtonsEnergy">
                                                <ul class="nav nav-pills gap-2">

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light active"
                                                            data-direction="Import">
                                                            Import
                                                        </button>
                                                    </li>

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-direction="Export">
                                                            Export
                                                        </button>
                                                    </li>

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-direction="Net">
                                                            Net
                                                        </button>
                                                    </li>

                                                    <li class="nav-item">
                                                        <button type="button"
                                                            class="nav-link param waves-effect waves-light"
                                                            data-direction="Total">
                                                            Total
                                                        </button>
                                                    </li>

                                                </ul>
                                            </div>

                                            <!-- Divider -->
                                            <span class="vr mx-3" style="background-color:#E6E6E8;"></span>

                                            <!-- === SYSTEM / PHASE === -->
                                            <div class="form-check form-check-inline m-0">
                                                <input class="form-check-input" type="radio" name="systemTypeEnergy"
                                                    id="systemEnergy" value="system" checked />
                                                <label class="form-check-label" for="systemEnergy">System</label>
                                            </div>

                                            <div class="form-check form-check-inline m-0">
                                                <input class="form-check-input" type="radio" name="systemTypeEnergy"
                                                    id="phaseEnergy" value="phase" />
                                                <label class="form-check-label" for="phaseEnergy">Phase</label>
                                            </div>

                                        </div>

                                    </div>

                                    <hr class="my-3" />

                                    <!-- === Time Interval Selection === -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-2 my-3">
                                            <label class="form-label fw-semibold mb-0">Select a Time Interval:</label>
                                        </div>
                                        <div class="col-md-10 d-flex align-items-center gap-3">
                                            <select id="intervalSelect" class="form-select w-auto">
                                                <option value="1">1 Minute</option>
                                                <option value="5" selected>5 Minutes</option>
                                                <option value="10">10 Minutes</option>
                                                <option value="15">15 Minutes</option>
                                                <option value="30">30 Minutes</option>
                                                <option value="60">60 Minutes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chart -->
                        <div class="card mt-6">
                            <div class="card-body p-0">
                                <style>
                                    body {
                                        font-family: "Inter", sans-serif;
                                        background: #f8f9fa;
                                        /* padding: 20px; */
                                    }

                                    #ChartEnergy {
                                        width: 100%;
                                        height: 100%;
                                        background: #fff;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                                        padding: 10px;
                                    }
                                </style>
                                <div id="ChartEnergy" style="width: 100%; height: 500px;"></div>

                            </div>
                        </div>

                    </div>
