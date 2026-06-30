@extends('layouts/layoutMaster')

@section('title', 'Create Procurement Request')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Create New Procurement Request</h4>
                <p class="text-muted mt-1">Fill in the details below to create a new procurement request</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('procurement.requests.store') }}" id="procurementRequestForm" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <div class="row mb-6">
                        <div class="col-12">
                            <h5 class="mb-4">Basic Information</h5>
                        </div>
                        <div class="col-md-8 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                <label for="title">Request Title *</label>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    @foreach($priorities as $value => $label)
                                        <option value="{{ $value }}" {{ old('priority') == $value ? 'selected' : '' }}>
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
                                        id="id_customer" name="id_customer">
                                    <option value="">Internal Request</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id_customer }}" {{ old('id_customer') == $customer->id_customer ? 'selected' : '' }}>
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
                                <input type="text" class="form-control flatpickr-date @error('requested_date') is-invalid @enderror" 
                                       id="requested_date" name="requested_date" value="{{ old('requested_date', date('Y-m-d')) }}" required>
                                <label for="requested_date">Requested Date *</label>
                                @error('requested_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control flatpickr-date @error('expected_date') is-invalid @enderror" 
                                       id="expected_date" name="expected_date" value="{{ old('expected_date') }}">
                                <label for="expected_date">Expected Date</label>
                                @error('expected_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" style="height: 100px;">{{ old('description') }}</textarea>
                                <label for="description">Description</label>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="row mb-6">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Request Items</h5>
                                <button type="button" class="btn btn-primary" id="addItemBtn">
                                    <i class="bx bx-plus me-1"></i>Add Item
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div id="itemsContainer">
                                <!-- Initial item row -->
                                <div class="item-row card mb-3" data-index="0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="card-title mb-0">Item #1</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn d-none">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control" 
                                                           name="items[0][product_name]" required>
                                                    <label>Product Name *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" class="form-control" 
                                                           name="items[0][requested_qty]" step="0.01" min="0.01" required>
                                                    <label>Quantity *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control" 
                                                           name="items[0][unit]" required>
                                                    <label>Unit *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <select class="form-select product-select" name="items[0][id_product]">
                                                        <option value="">Select Product</option>
                                                    </select>
                                                    <label>From Catalog</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating form-floating-outline">
                                                    <textarea class="form-control" name="items[0][specification]" rows="2" style="height: 80px;"></textarea>
                                                    <label>Specification</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @error('items')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            @error('items.*')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                    <i class="bx bx-arrow-back me-1"></i>Cancel
                                </button>
                                <div>
                                    <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2">
                                        <i class="bx bx-save me-1"></i>Save as Draft
                                    </button>
                                    <button type="submit" name="action" value="submit" class="btn btn-primary">
                                        <i class="bx bx-send me-1"></i>Create & Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Item Template (Hidden) -->
<template id="itemTemplate">
    <div class="item-row card mb-3" data-index="__INDEX__">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">Item #__NUMBER__</h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" 
                               name="items[__INDEX__][product_name]" required>
                        <label>Product Name *</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="form-floating form-floating-outline">
                        <input type="number" class="form-control" 
                               name="items[__INDEX__][requested_qty]" step="0.01" min="0.01" required>
                        <label>Quantity *</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" 
                               name="items[__INDEX__][unit]" required>
                        <label>Unit *</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="form-floating form-floating-outline">
                        <select class="form-select product-select" name="items[__INDEX__][id_product]">
                            <option value="">Select Product</option>
                        </select>
                        <label>From Catalog</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control" name="items[__INDEX__][specification]" rows="2" style="height: 80px;"></textarea>
                        <label>Specification</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Global configuration
window.procurementConfig = {
    routes: {
        searchProducts: '{{ route("procurement.search_products") }}'
    }
};
</script>

@endsection