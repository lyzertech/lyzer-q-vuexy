@extends('layouts/layoutMaster')

@section('title', 'Edit Procurement Request - ' . $request->request_number)

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection


@section('content')

@php
    use App\Enums\procurement\ProcurementRequestStatus;
    use App\Enums\procurement\ProcurementPriority;
@endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Edit Procurement Request</h4>
                        <div class="d-flex align-items-center">
                            <p class="text-muted mb-0 me-3">{{ $request->request_number }}</p>
                            <span class="badge bg-{{ ProcurementRequestStatus::from($request->status)->color() }}">
                                {{ ProcurementRequestStatus::from($request->status)->label() }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('procurement.requests.show', $request) }}" class="btn btn-outline-primary">
                            <i class="bx bx-show me-1"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(!$request->canBeEdited())
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <span class="alert-icon rounded">
                        <i class="bx bx-lock"></i>
                    </span>
                    <span class="alert-text"><strong>Read Only:</strong> This request cannot be edited because it's {{ ProcurementRequestStatus::from($request->status)->label() }}.</span>
                </div>
                @endif

                <form method="POST" action="{{ route('procurement.requests.update', $request) }}" id="procurementRequestForm" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information Section -->
                    <div class="row mb-6">
                        <div class="col-12">
                            <h5 class="mb-4">Basic Information</h5>
                        </div>
                        <div class="col-md-8 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $request->title) }}" 
                                       {{ !$request->canBeEdited() ? 'readonly' : 'required' }}>
                                <label for="title">Request Title *</label>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" {{ !$request->canBeEdited() ? 'disabled' : 'required' }}>
                                    <option value="">Select Priority</option>
                                    @foreach($priorities as $value => $label)
                                        <option value="{{ $value }}" {{ old('priority', $request->priority) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="priority">Priority *</label>
                                @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select select2 @error('id_customer') is-invalid @enderror" 
                                        id="id_customer" name="id_customer" {{ !$request->canBeEdited() ? 'disabled' : '' }}>
                                    <option value="">Internal Request</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id_customer }}" {{ old('id_customer', $request->id_customer) == $customer->id_customer ? 'selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_customer">Customer</label>
                                @error('id_customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('requested_date') is-invalid @enderror" 
                                       id="requested_date" name="requested_date" value="{{ old('requested_date', $request->requested_date->format('Y-m-d')) }}" 
                                       readonly>
                                <label for="requested_date">Requested Date *</label>
                                @error('requested_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Cannot be changed after creation</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control flatpickr-date @error('expected_date') is-invalid @enderror" 
                                       id="expected_date" name="expected_date" value="{{ old('expected_date', $request->expected_date?->format('Y-m-d')) }}"
                                       {{ !$request->canBeEdited() ? 'readonly' : '' }}>
                                <label for="expected_date">Expected Date</label>
                                @error('expected_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" style="height: 100px;"
                                          {{ !$request->canBeEdited() ? 'readonly' : '' }}>{{ old('description', $request->description) }}</textarea>
                                <label for="description">Description</label>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Current Items Section -->
                    @if($request->items->count() > 0)
                    <div class="row mb-6">
                        <div class="col-12">
                            <h5 class="mb-4">Current Items</h5>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                            @if($request->status === 'draft')
                                            <th width="100">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($request->items as $item)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $item->product_name }}</strong>
                                                    @if($item->specification)
                                                    <br><small class="text-muted">{{ Str::limit($item->specification, 100) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ number_format($item->requested_qty, 2) }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>
                                                <span class="badge bg-{{ \App\Enums\procurement\ProcurementItemStatus::from($item->status)->color() }}">
                                                    {{ \App\Enums\procurement\ProcurementItemStatus::from($item->status)->label() }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item->arrived_qty > 0)
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 80px; height: 6px;">
                                                        <div class="progress-bar" style="width: {{ $item->getCompletionPercentageAttribute() }}%"></div>
                                                    </div>
                                                    <small>{{ number_format($item->getCompletionPercentageAttribute(), 0) }}%</small>
                                                </div>
                                                @else
                                                <small class="text-muted">Not started</small>
                                                @endif
                                            </td>
                                            @if($request->status === 'draft')
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="removeItem({{ $item->id_procurement_item }})">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Add New Items Section (only for draft requests) -->
                    @if($request->status === 'draft')
                    <div class="row mb-6">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Add New Items</h5>
                                <button type="button" class="btn btn-primary" id="addItemBtn">
                                    <i class="bx bx-plus me-1"></i>Add Item
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div id="itemsContainer">
                                <!-- New items will be added here -->
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Workflow Information -->
                    @if($request->ack_manager || $request->ack_director)
                    <div class="row mb-6">
                        <div class="col-12">
                            <h5 class="mb-4">Approval History</h5>
                        </div>
                        @if($request->ack_manager)
                        <div class="col-md-6 mb-4">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        <h6 class="mb-0">Manager Approval</h6>
                                    </div>
                                    <p class="text-muted mb-0">{{ $request->ack_manager }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($request->ack_director)
                        <div class="col-md-6 mb-4">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-check-circle text-info me-2"></i>
                                        <h6 class="mb-0">Director Approval</h6>
                                    </div>
                                    <p class="text-muted mb-0">{{ $request->ack_director }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('procurement.requests.show', $request) }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i>Back to Details
                                </a>
                                @if($request->canBeEdited())
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i>Update Request
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Item Template (Hidden) -->
@if($request->status === 'draft')
<template id="itemTemplate">
    <div class="item-row card mb-3" data-index="__INDEX__">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">New Item #__NUMBER__</h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" 
                               name="new_items[__INDEX__][product_name]" required>
                        <label>Product Name *</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="form-floating form-floating-outline">
                        <input type="number" class="form-control" 
                               name="new_items[__INDEX__][requested_qty]" step="0.01" min="0.01" required>
                        <label>Quantity *</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" 
                               name="new_items[__INDEX__][unit]" required>
                        <label>Unit *</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="form-floating form-floating-outline">
                        <select class="form-select product-select" name="new_items[__INDEX__][id_product]">
                            <option value="">Select Product</option>
                        </select>
                        <label>From Catalog</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control" name="new_items[__INDEX__][specification]" rows="2" style="height: 80px;"></textarea>
                        <label>Specification</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
@endif

<script>
// Global configuration
window.procurementConfig = {
    requestId: {{ $request->id_procurement_request }},
    canEdit: {{ $request->canBeEdited() ? 'true' : 'false' }},
    routes: {
        searchProducts: '{{ route("procurement.search_products") }}',
        removeItem: '{{ route("procurement.items.destroy", ["request" => $request, "item" => ":id"]) }}'
    }
};
</script>

@endsection