@extends('layouts/layoutMaster')
@section('title', 'Add Engineering Wiki')
@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold py-3 mb-0">Add Engineering Wiki</h4>
                <a href="{{ route('techvault-engineeringwiki') }}" class="btn btn-outline-secondary">Back</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('techvault-engineeringwiki.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                        value="{{ old('customer_name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="issue" @selected(old('category') == 'issue')>Issue</option>
                                        <option value="update" @selected(old('category') == 'update')>Update</option>
                                        <option value="note" @selected(old('category') == 'note')>Note</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <div class="input-group">
                                        <select name="brand" class="form-select" id="brandSelect"
                                            onchange="document.getElementById('brandInput').value=this.value;">
                                            <option value="">Select</option>
                                            @foreach ($brands ?? [] as $brand)
                                                <option value="{{ $brand }}" @selected(old('brand') == $brand)>
                                                    {{ $brand }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="brand" id="brandInput" class="form-control"
                                            placeholder="Or enter new..." value="{{ old('brand') }}"
                                            oninput="document.getElementById('brandSelect').value='';">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Device Type</label>
                                    <div class="input-group">
                                        <select name="device_type" class="form-select" id="deviceTypeSelect"
                                            onchange="document.getElementById('deviceTypeInput').value=this.value;">
                                            <option value="">Select</option>
                                            @foreach ($deviceTypes ?? [] as $type)
                                                <option value="{{ $type }}" @selected(old('device_type') == $type)>
                                                    {{ $type }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="device_type" id="deviceTypeInput" class="form-control"
                                            placeholder="Or enter new..." value="{{ old('device_type') }}"
                                            oninput="document.getElementById('deviceTypeSelect').value='';">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Model</label>
                                    <div class="input-group">
                                        <select name="model" class="form-select" id="modelSelect"
                                            onchange="document.getElementById('modelInput').value=this.value;">
                                            <option value="">Select</option>
                                            @foreach ($models ?? [] as $model)
                                                <option value="{{ $model }}" @selected(old('model') == $model)>
                                                    {{ $model }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="model" id="modelInput" class="form-control"
                                            placeholder="Or enter new..." value="{{ old('model') }}"
                                            oninput="document.getElementById('modelSelect').value='';">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Serial Number</label>
                                    <input type="text" name="serial_number" class="form-control"
                                        value="{{ old('serial_number') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Firmware Version</label>
                                    <div class="input-group">
                                        <select name="firmware_version" class="form-select" id="firmwareVersionSelect"
                                            onchange="document.getElementById('firmwareVersionInput').value=this.value;">
                                            <option value="">Select</option>
                                            @foreach ($firmwareVersions ?? [] as $firmware)
                                                <option value="{{ $firmware }}" @selected(old('firmware_version') == $firmware)>
                                                    {{ $firmware }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="firmware_version" id="firmwareVersionInput"
                                            class="form-control" placeholder="Or enter new..."
                                            value="{{ old('firmware_version') }}"
                                            oninput="document.getElementById('firmwareVersionSelect').value='';">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hardware Version</label>
                                    <div class="input-group">
                                        <select name="hardware_version" class="form-select" id="hardwareVersionSelect"
                                            onchange="document.getElementById('hardwareVersionInput').value=this.value;">
                                            <option value="">Select</option>
                                            @foreach ($hardwareVersions ?? [] as $hardware)
                                                <option value="{{ $hardware }}" @selected(old('hardware_version') == $hardware)>
                                                    {{ $hardware }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="hardware_version" id="hardwareVersionInput"
                                            class="form-control" placeholder="Or enter new..."
                                            value="{{ old('hardware_version') }}"
                                            oninput="document.getElementById('hardwareVersionSelect').value='';">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Symptom</label>
                                    <div class="input-group">
                                        <textarea name="symptom" class="form-control">{{ old('symptom') }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="symptom_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="symptom_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Root Cause</label>
                                    <div class="input-group">
                                        <textarea name="root_cause" class="form-control">{{ old('root_cause') }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="root_cause_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="root_cause_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Solution</label>
                                    <div class="input-group">
                                        <textarea name="solution" class="form-control">{{ old('solution') }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="solution_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="solution_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Action Taken</label>
                                    <div class="input-group">
                                        <textarea name="action_taken" class="form-control">{{ old('action_taken') }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="action_taken_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="action_taken_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="open" @selected(old('status') == 'open')>Open</option>
                                        <option value="monitoring" @selected(old('status') == 'monitoring')>Monitoring</option>
                                        <option value="solved" @selected(old('status') == 'solved')>Solved</option>
                                        <option value="closed" @selected(old('status') == 'closed')>Closed</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="low" @selected(old('priority') == 'low')>Low</option>
                                        <option value="medium" @selected(old('priority') == 'medium')>Medium</option>
                                        <option value="high" @selected(old('priority') == 'high')>High</option>
                                        <option value="critical" @selected(old('priority') == 'critical')>Critical</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Reference Doc</label>
                                    <input type="text" name="reference_doc" class="form-control"
                                        value="{{ old('reference_doc') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('styles')
        <style>
            .custom-file-label {
                display: flex;
                align-items: center;
                cursor: pointer;
            }

            .custom-file-label i {
                margin-right: 6px;
            }

            .custom-file-input {
                display: none;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @endpush
