@extends('layouts/layoutMaster')
@section('title', 'Wiki Detail')

@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold py-3 mb-0">
                    <i class="bi bi-journal-text me-2"></i> Engineering Wiki Detail
                </h4>
                <a href="{{ route('techvault-engineeringwiki') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light fw-bold d-flex align-items-center">
                            <i class="bi bi-cpu me-2"></i> Device Info
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Title:</strong> {{ $engineeringWiki->title }}</li>
                                <li class="list-group-item"><strong>Customer Name:</strong>
                                    {{ $engineeringWiki->customer_name }}</li>
                                <li class="list-group-item"><strong>Category:</strong> <span
                                        class="badge
                                    @if ($engineeringWiki->category == 'issue') bg-danger
                                    @elseif($engineeringWiki->category == 'update') bg-warning text-dark
                                    @elseif($engineeringWiki->category == 'note') bg-info
                                    @else bg-secondary @endif
                                ">{{ ucfirst($engineeringWiki->category) }}</span>
                                </li>
                                <li class="list-group-item"><strong>Brand:</strong> {{ $engineeringWiki->brand }}</li>
                                <li class="list-group-item"><strong>Device Type:</strong>
                                    {{ $engineeringWiki->device_type }}</li>
                                <li class="list-group-item"><strong>Model:</strong> {{ $engineeringWiki->model }}</li>
                                <li class="list-group-item"><strong>Serial Number:</strong>
                                    {{ $engineeringWiki->serial_number }}</li>
                                <li class="list-group-item"><strong>Firmware Version:</strong>
                                    {{ $engineeringWiki->firmware_version }}</li>
                                <li class="list-group-item"><strong>Hardware Version:</strong>
                                    {{ $engineeringWiki->hardware_version }}</li>
                                <li class="list-group-item"><strong>Status:</strong> @include(
                                    'content.digitize.techvault.engineering_wiki.partials.status_badge',
                                    ['status' => $engineeringWiki->status]
                                )</li>
                                <li class="list-group-item"><strong>Priority:</strong> @include(
                                    'content.digitize.techvault.engineering_wiki.partials.priority_badge',
                                    ['priority' => $engineeringWiki->priority]
                                )</li>
                                <li class="list-group-item"><strong>Reference Doc:</strong>
                                    {{ $engineeringWiki->reference_doc }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light fw-bold d-flex align-items-center">
                            <i class="bi bi-pencil-square me-2"></i> Engineering Notes
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Symptom:</strong>
                                    <br>{!! nl2br(e($engineeringWiki->symptom)) !!}
                                    <div class="mt-2">
                                        @if ($engineeringWiki->symptom_file)
                                            <a href="{{ asset('storage/' . $engineeringWiki->symptom_file) }}"
                                                target="_blank" class="me-2">
                                                <i class="fa fa-paperclip"></i> File
                                            </a>
                                        @endif
                                        @if ($engineeringWiki->symptom_image)
                                            <a href="{{ asset('storage/' . $engineeringWiki->symptom_image) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $engineeringWiki->symptom_image) }}"
                                                    alt="Symptom Image"
                                                    style="width:80px;height:80px;object-fit:contain;border-radius:4px;border:1px solid #ccc;background:#f8f9fa;vertical-align:middle;display:inline-block;">
                                                <i class="fa fa-camera ms-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item"><strong>Root Cause:</strong>
                                    <br>{!! nl2br(e($engineeringWiki->root_cause)) !!}
                                    <div class="mt-2">
                                        @if ($engineeringWiki->root_cause_file)
                                            <a href="{{ asset('storage/' . $engineeringWiki->root_cause_file) }}"
                                                target="_blank" class="me-2">
                                                <i class="fa fa-paperclip"></i> File
                                            </a>
                                        @endif
                                        @if ($engineeringWiki->root_cause_image)
                                            <a href="{{ asset('storage/' . $engineeringWiki->root_cause_image) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $engineeringWiki->root_cause_image) }}"
                                                    alt="Root Cause Image"
                                                    style="width:80px;height:80px;object-fit:contain;border-radius:4px;border:1px solid #ccc;background:#f8f9fa;vertical-align:middle;display:inline-block;">
                                                <i class="fa fa-camera ms-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item"><strong>Solution:</strong>
                                    <br>{!! nl2br(e($engineeringWiki->solution)) !!}
                                    <div class="mt-2">
                                        @if ($engineeringWiki->solution_file)
                                            <a href="{{ asset('storage/' . $engineeringWiki->solution_file) }}"
                                                target="_blank" class="me-2">
                                                <i class="fa fa-paperclip"></i> File
                                            </a>
                                        @endif
                                        @if ($engineeringWiki->solution_image)
                                            <a href="{{ asset('storage/' . $engineeringWiki->solution_image) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $engineeringWiki->solution_image) }}"
                                                    alt="Solution Image"
                                                    style="width:80px;height:80px;object-fit:contain;border-radius:4px;border:1px solid #ccc;background:#f8f9fa;vertical-align:middle;display:inline-block;">
                                                <i class="fa fa-camera ms-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item"><strong>Action Taken:</strong>
                                    <br>{!! nl2br(e($engineeringWiki->action_taken)) !!}
                                    <div class="mt-2">
                                        @if ($engineeringWiki->action_taken_file)
                                            <a href="{{ asset('storage/' . $engineeringWiki->action_taken_file) }}"
                                                target="_blank" class="me-2">
                                                <i class="fa fa-paperclip"></i> File
                                            </a>
                                        @endif
                                        @if ($engineeringWiki->action_taken_image)
                                            <a href="{{ asset('storage/' . $engineeringWiki->action_taken_image) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $engineeringWiki->action_taken_image) }}"
                                                    alt="Action Taken Image"
                                                    style="width:80px;height:80px;object-fit:contain;border-radius:4px;border:1px solid #ccc;background:#f8f9fa;vertical-align:middle;display:inline-block;">
                                                <i class="fa fa-camera ms-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
@endpush
