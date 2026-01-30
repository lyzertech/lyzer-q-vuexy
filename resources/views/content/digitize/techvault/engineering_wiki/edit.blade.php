@extends('layouts/layoutMaster')
@section('title', 'Edit Engineering Wiki')
@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold py-3 mb-0">Edit Engineering Wiki</h4>
                <a href="{{ route('techvault-engineeringwiki') }}" class="btn btn-outline-secondary">Back</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('techvault-engineeringwiki.update', $engineeringWiki) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $engineeringWiki->title) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                        value="{{ old('customer_name', $engineeringWiki->customer_name) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="issue" @selected(old('category', $engineeringWiki->category) == 'issue')>Issue</option>
                                        <option value="update" @selected(old('category', $engineeringWiki->category) == 'update')>Update</option>
                                        <option value="note" @selected(old('category', $engineeringWiki->category) == 'note')>Note</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <input type="text" name="brand" class="form-control"
                                        value="{{ old('brand', $engineeringWiki->brand) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Device Type</label>
                                    <input type="text" name="device_type" class="form-control"
                                        value="{{ old('device_type', $engineeringWiki->device_type) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Model</label>
                                    <input type="text" name="model" class="form-control"
                                        value="{{ old('model', $engineeringWiki->model) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Serial Number</label>
                                    <input type="text" name="serial_number" class="form-control"
                                        value="{{ old('serial_number', $engineeringWiki->serial_number) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Firmware Version</label>
                                    <input type="text" name="firmware_version" class="form-control"
                                        value="{{ old('firmware_version', $engineeringWiki->firmware_version) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hardware Version</label>
                                    <input type="text" name="hardware_version" class="form-control"
                                        value="{{ old('hardware_version', $engineeringWiki->hardware_version) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Symptom</label>
                                    <div class="input-group">
                                        <textarea name="symptom" class="form-control">{{ old('symptom', $engineeringWiki->symptom) }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="symptom_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            @if ($engineeringWiki->symptom_file)
                                                <a href="{{ asset('storage/' . $engineeringWiki->symptom_file) }}"
                                                    target="_blank">Current File</a>
                                            @endif
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="symptom_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                            @if ($engineeringWiki->symptom_image)
                                                <a href="{{ asset('storage/' . $engineeringWiki->symptom_image) }}"
                                                    target="_blank">Current Image</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Root Cause</label>
                                    <div class="input-group">
                                        <textarea name="root_cause" class="form-control">{{ old('root_cause', $engineeringWiki->root_cause) }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="root_cause_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            @if ($engineeringWiki->root_cause_file)
                                                <a href="{{ asset('storage/' . $engineeringWiki->root_cause_file) }}"
                                                    target="_blank">Current File</a>
                                            @endif
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="root_cause_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                            @if ($engineeringWiki->root_cause_image)
                                                <a href="{{ asset('storage/' . $engineeringWiki->root_cause_image) }}"
                                                    target="_blank">Current Image</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Solution</label>
                                    <div class="input-group">
                                        <textarea name="solution" class="form-control">{{ old('solution', $engineeringWiki->solution) }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="solution_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            @if ($engineeringWiki->solution_file)
                                                <a href="{{ asset('storage/' . $engineeringWiki->solution_file) }}"
                                                    target="_blank">Current File</a>
                                            @endif
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="solution_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                            @if ($engineeringWiki->solution_image)
                                                <a href="{{ asset('storage/' . $engineeringWiki->solution_image) }}"
                                                    target="_blank">Current Image</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Action Taken</label>
                                    <div class="input-group">
                                        <textarea name="action_taken" class="form-control">{{ old('action_taken', $engineeringWiki->action_taken) }}</textarea>
                                        <div class="d-flex flex-column ms-2" style="min-width:120px;">
                                            <label class="custom-file-label mb-2">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Attach File</span>
                                                <input type="file" name="action_taken_file" class="custom-file-input"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.csv,.ppt,.pptx">
                                            </label>
                                            @if ($engineeringWiki->action_taken_file)
                                                <a href="{{ asset('storage/' . $engineeringWiki->action_taken_file) }}"
                                                    target="_blank">Current File</a>
                                            @endif
                                            <label class="custom-file-label">
                                                <i class="fa fa-camera"></i>
                                                <span>Choose Image</span>
                                                <input type="file" name="action_taken_image" class="custom-file-input"
                                                    accept="image/*" capture="environment">
                                            </label>
                                            @if ($engineeringWiki->action_taken_image)
                                                <a href="{{ asset('storage/' . $engineeringWiki->action_taken_image) }}"
                                                    target="_blank">Current Image</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="">Select</option>
                                        <option value="open" @selected(old('status', $engineeringWiki->status) == 'open')>Open</option>
                                        <option value="monitoring" @selected(old('status', $engineeringWiki->status) == 'monitoring')>Monitoring</option>
                                        <option value="solved" @selected(old('status', $engineeringWiki->status) == 'solved')>Solved</option>
                                        <option value="closed" @selected(old('status', $engineeringWiki->status) == 'closed')>Closed</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="low" @selected(old('priority', $engineeringWiki->priority) == 'low')>Low</option>
                                        <option value="medium" @selected(old('priority', $engineeringWiki->priority) == 'medium')>Medium</option>
                                        <option value="high" @selected(old('priority', $engineeringWiki->priority) == 'high')>High</option>
                                        <option value="critical" @selected(old('priority', $engineeringWiki->priority) == 'critical')>Critical</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Reference Doc</label>
                                    <input type="text" name="reference_doc" class="form-control"
                                        value="{{ old('reference_doc', $engineeringWiki->reference_doc) }}">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
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
