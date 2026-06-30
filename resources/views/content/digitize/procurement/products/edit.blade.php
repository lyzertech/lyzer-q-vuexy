@extends('layouts/layoutMaster')

@section('title', 'Edit Product - Procurement')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/tagify/tagify.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/tagify/tagify.js'])
@endsection


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Edit Product</h5>
                    <p class="text-muted mt-1 mb-0">Update product information and settings</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('procurement.products.show', $product->id_product) }}" class="btn btn-outline-info btn-sm">
                        <i class="bx bx-show me-1"></i>View Details
                    </a>
                    <a href="{{ route('procurement.products.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to Products
                    </a>
                </div>
            </div>

            <form action="{{ route('procurement.products.update', $product->id_product) }}" method="POST" id="productForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="text-muted fw-semibold">Basic Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="product_name">Product Name *</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                   id="product_name" name="product_name" 
                                   value="{{ old('product_name', $product->product_name) }}" 
                                   placeholder="Enter product name" required>
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="product_code">Product Code</label>
                            <input type="text" class="form-control @error('product_code') is-invalid @enderror" 
                                   id="product_code" name="product_code" 
                                   value="{{ old('product_code', $product->product_code) }}" 
                                   placeholder="Product code">
                            <div class="form-text">Unique identifier for this product</div>
                            @error('product_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="category">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">Select Category</option>
                                <option value="Electronics" {{ old('category', $product->category) === 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Materials" {{ old('category', $product->category) === 'Materials' ? 'selected' : '' }}>Materials</option>
                                <option value="Tools" {{ old('category', $product->category) === 'Tools' ? 'selected' : '' }}>Tools</option>
                                <option value="Equipment" {{ old('category', $product->category) === 'Equipment' ? 'selected' : '' }}>Equipment</option>
                                <option value="Consumables" {{ old('category', $product->category) === 'Consumables' ? 'selected' : '' }}>Consumables</option>
                                <option value="Others" {{ old('category', $product->category) === 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Specifications -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Product Specifications</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="specifications">Specifications</label>
                            <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                      id="specifications" name="specifications" rows="4" 
                                      placeholder="Enter detailed product specifications, features, and technical details">{{ old('specifications', $product->specifications) }}</textarea>
                            @error('specifications')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Unit and Pricing -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Unit & Pricing Information</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="unit_of_measure">Unit of Measure</label>
                            <select class="form-select @error('unit_of_measure') is-invalid @enderror" id="unit_of_measure" name="unit_of_measure">
                                <option value="PCS" {{ old('unit_of_measure', $product->unit_of_measure) === 'PCS' ? 'selected' : '' }}>PCS (Pieces)</option>
                                <option value="KG" {{ old('unit_of_measure', $product->unit_of_measure) === 'KG' ? 'selected' : '' }}>KG (Kilogram)</option>
                                <option value="M" {{ old('unit_of_measure', $product->unit_of_measure) === 'M' ? 'selected' : '' }}>M (Meter)</option>
                                <option value="M2" {{ old('unit_of_measure', $product->unit_of_measure) === 'M2' ? 'selected' : '' }}>M² (Square Meter)</option>
                                <option value="M3" {{ old('unit_of_measure', $product->unit_of_measure) === 'M3' ? 'selected' : '' }}>M³ (Cubic Meter)</option>
                                <option value="L" {{ old('unit_of_measure', $product->unit_of_measure) === 'L' ? 'selected' : '' }}>L (Liter)</option>
                                <option value="BOX" {{ old('unit_of_measure', $product->unit_of_measure) === 'BOX' ? 'selected' : '' }}>BOX</option>
                                <option value="SET" {{ old('unit_of_measure', $product->unit_of_measure) === 'SET' ? 'selected' : '' }}>SET</option>
                                <option value="ROLL" {{ old('unit_of_measure', $product->unit_of_measure) === 'ROLL' ? 'selected' : '' }}>ROLL</option>
                                <option value="PACK" {{ old('unit_of_measure', $product->unit_of_measure) === 'PACK' ? 'selected' : '' }}>PACK</option>
                            </select>
                            @error('unit_of_measure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="unit_price">Unit Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                       id="unit_price" name="unit_price" 
                                       value="{{ old('unit_price', $product->unit_price) }}" 
                                       min="0" step="0.01" placeholder="0.00">
                            </div>
                            <div class="form-text">Price per unit of measure</div>
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="currency">Currency</label>
                            <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency">
                                <option value="IDR" {{ old('currency', $product->currency) === 'IDR' ? 'selected' : '' }}>IDR (Indonesian Rupiah)</option>
                                <option value="USD" {{ old('currency', $product->currency) === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                                <option value="EUR" {{ old('currency', $product->currency) === 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                                <option value="SGD" {{ old('currency', $product->currency) === 'SGD' ? 'selected' : '' }}>SGD (Singapore Dollar)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stock Management -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Stock Management</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="current_stock">Current Stock</label>
                            <input type="number" class="form-control @error('current_stock') is-invalid @enderror" 
                                   id="current_stock" name="current_stock" 
                                   value="{{ old('current_stock', $product->current_stock) }}" 
                                   min="0" placeholder="0">
                            <div class="form-text">Current available quantity</div>
                            @error('current_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="min_stock_level">Minimum Stock Level</label>
                            <input type="number" class="form-control @error('min_stock_level') is-invalid @enderror" 
                                   id="min_stock_level" name="min_stock_level" 
                                   value="{{ old('min_stock_level', $product->min_stock_level) }}" 
                                   min="0" placeholder="0">
                            <div class="form-text">Alert when stock reaches this level</div>
                            @error('min_stock_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="reorder_point">Reorder Point</label>
                            <input type="number" class="form-control @error('reorder_point') is-invalid @enderror" 
                                   id="reorder_point" name="reorder_point" 
                                   value="{{ old('reorder_point', $product->reorder_point) }}" 
                                   min="0" placeholder="0">
                            <div class="form-text">Automatic reorder trigger level</div>
                            @error('reorder_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Supplier Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Supplier Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="primary_supplier">Primary Supplier</label>
                            <select class="form-select @error('primary_supplier') is-invalid @enderror" id="primary_supplier" name="primary_supplier">
                                <option value="">Select Primary Supplier</option>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id_supplier }}" 
                                        {{ old('primary_supplier', $product->primary_supplier) == $supplier->id_supplier ? 'selected' : '' }}>
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('primary_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="alternative_suppliers">Alternative Suppliers</label>
                            <select class="form-select" id="alternative_suppliers" name="alternative_suppliers[]" multiple>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id_supplier }}"
                                        {{ in_array($supplier->id_supplier, old('alternative_suppliers', $product->alternativeSuppliers->pluck('id_supplier')->toArray() ?? [])) ? 'selected' : '' }}>
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple suppliers</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="lead_time_days">Lead Time (Days)</label>
                            <input type="number" class="form-control @error('lead_time_days') is-invalid @enderror" 
                                   id="lead_time_days" name="lead_time_days" 
                                   value="{{ old('lead_time_days', $product->lead_time_days) }}" 
                                   min="1" placeholder="7">
                            <div class="form-text">Average procurement lead time</div>
                            @error('lead_time_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="warranty_period">Warranty Period</label>
                            <input type="text" class="form-control @error('warranty_period') is-invalid @enderror" 
                                   id="warranty_period" name="warranty_period" 
                                   value="{{ old('warranty_period', $product->warranty_period) }}" 
                                   placeholder="e.g., 12 months, 2 years">
                            @error('warranty_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Additional Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="brand">Brand</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" 
                                   value="{{ old('brand', $product->brand) }}" 
                                   placeholder="Product brand or manufacturer">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="model_number">Model Number</label>
                            <input type="text" class="form-control @error('model_number') is-invalid @enderror" 
                                   id="model_number" name="model_number" 
                                   value="{{ old('model_number', $product->model_number) }}" 
                                   placeholder="Model or part number">
                            @error('model_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any additional notes about this product">{{ old('notes', $product->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Settings -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Product Settings</h6>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_serialized" name="is_serialized" 
                                       value="1" {{ old('is_serialized', $product->is_serialized) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_serialized">
                                    Serialized Product
                                </label>
                                <div class="form-text">Track individual serial numbers</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="requires_approval" name="requires_approval" 
                                       value="1" {{ old('requires_approval', $product->requires_approval) ? 'checked' : '' }}>
                                <label class="form-check-label" for="requires_approval">
                                    Requires Approval
                                </label>
                                <div class="form-text">Needs manager approval for procurement</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_hazardous" name="is_hazardous" 
                                       value="1" {{ old('is_hazardous', $product->is_hazardous) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_hazardous">
                                    Hazardous Material
                                </label>
                                <div class="form-text">Requires special handling</div>
                            </div>
                        </div>

                        <!-- Audit Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Record Information</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Created At</label>
                            <input type="text" class="form-control" value="{{ $product->created_at->format('M d, Y H:i') }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control" value="{{ $product->updated_at->format('M d, Y H:i') }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Times Used</label>
                            <input type="text" class="form-control" value="{{ $product->procurementItems->count() ?? 0 }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('procurement.products.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x me-1"></i>Cancel
                        </a>
                        @if($product->status === 'inactive')
                        <button type="button" class="btn btn-outline-success" onclick="toggleStatus('{{ $product->id_product }}', 'inactive')">
                            <i class="bx bx-check-circle me-1"></i>Activate Product
                        </button>
                        @else
                        <button type="button" class="btn btn-outline-warning" onclick="toggleStatus('{{ $product->id_product }}', 'active')">
                            <i class="bx bx-x-circle me-1"></i>Deactivate Product
                        </button>
                        @endif
                        <button type="button" class="btn btn-outline-info" onclick="duplicateProduct('{{ $product->id_product }}', '{{ $product->product_name }}')">
                            <i class="bx bx-copy me-1"></i>Duplicate Product
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary me-2" onclick="saveDraft()">
                            <i class="bx bx-save me-1"></i>Save as Draft
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-set reorder point based on min stock level
    const minStockInput = document.getElementById('min_stock_level');
    const reorderPointInput = document.getElementById('reorder_point');
    
    minStockInput.addEventListener('input', function() {
        if (!reorderPointInput.value || reorderPointInput.hasAttribute('data-auto-calculated')) {
            const reorderPoint = Math.ceil(this.value * 1.5); // 150% of min stock
            reorderPointInput.value = reorderPoint;
            reorderPointInput.setAttribute('data-auto-calculated', 'true');
        }
    });
    
    reorderPointInput.addEventListener('input', function() {
        if (this.value) {
            this.removeAttribute('data-auto-calculated');
        }
    });
    
    // Initialize Select2 for better dropdowns
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#category, #unit_of_measure, #currency, #status, #primary_supplier').select2({
            theme: 'bootstrap-5'
        });
        
        $('#alternative_suppliers').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select alternative suppliers',
            allowClear: true
        });
    }
    
    // Price formatting
    const unitPriceInput = document.getElementById('unit_price');
    unitPriceInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
});

function saveDraft() {
    // Add draft status and submit
    const form = document.getElementById('productForm');
    const draftInput = document.createElement('input');
    draftInput.type = 'hidden';
    draftInput.name = 'save_as_draft';
    draftInput.value = '1';
    form.appendChild(draftInput);
    form.submit();
}

function toggleStatus(productId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this product?`)) {
        fetch(`{{ route('procurement.products.toggle_status', ':id') }}`.replace(':id', productId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function duplicateProduct(productId, productName) {
    if (confirm(`Create a duplicate of "${productName}"?`)) {
        fetch(`{{ route('procurement.products.duplicate', ':id') }}`.replace(':id', productId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `{{ route('procurement.products.edit', ':id') }}`.replace(':id', data.product_id);
            }
        });
    }
}

// Form validation
document.getElementById('productForm').addEventListener('submit', function(e) {
    const requiredFields = ['product_name'];
    let isValid = true;
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    // Validate that reorder point is not less than min stock level
    const minStock = parseInt(document.getElementById('min_stock_level').value) || 0;
    const reorderPoint = parseInt(document.getElementById('reorder_point').value) || 0;
    
    if (reorderPoint > 0 && reorderPoint < minStock) {
        alert('Reorder point should be greater than or equal to minimum stock level');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
        // Focus on first invalid field
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    }
});
</script>

@endsection