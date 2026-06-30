@extends('layouts/layoutMaster')

@section('title', 'Edit Supplier - Procurement')

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
                    <h5 class="card-title mb-0">Edit Supplier</h5>
                    <p class="text-muted mt-1 mb-0">Update supplier information and settings</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('procurement.suppliers.show', $supplier->id_supplier) }}" class="btn btn-outline-info btn-sm">
                        <i class="bx bx-show me-1"></i>View Details
                    </a>
                    <a href="{{ route('procurement.suppliers.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to Suppliers
                    </a>
                </div>
            </div>

            <form action="{{ route('procurement.suppliers.update', $supplier->id_supplier) }}" method="POST" id="supplierForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="text-muted fw-semibold">Basic Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="supplier_name">Supplier Name *</label>
                            <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" 
                                   id="supplier_name" name="supplier_name" 
                                   value="{{ old('supplier_name', $supplier->supplier_name) }}" 
                                   placeholder="Enter supplier name" required>
                            @error('supplier_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="supplier_code">Supplier Code</label>
                            <input type="text" class="form-control @error('supplier_code') is-invalid @enderror" 
                                   id="supplier_code" name="supplier_code" 
                                   value="{{ old('supplier_code', $supplier->supplier_code) }}" 
                                   placeholder="Supplier code">
                            <div class="form-text">Unique identifier for this supplier</div>
                            @error('supplier_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="category">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">Select Category</option>
                                <option value="Materials" {{ old('category', $supplier->category) === 'Materials' ? 'selected' : '' }}>Materials</option>
                                <option value="Services" {{ old('category', $supplier->category) === 'Services' ? 'selected' : '' }}>Services</option>
                                <option value="Equipment" {{ old('category', $supplier->category) === 'Equipment' ? 'selected' : '' }}>Equipment</option>
                                <option value="Others" {{ old('category', $supplier->category) === 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $supplier->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $supplier->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Contact Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="contact_person">Contact Person</label>
                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                   id="contact_person" name="contact_person" 
                                   value="{{ old('contact_person', $supplier->contact_person) }}" 
                                   placeholder="Primary contact name">
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="contact_email">Email Address</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                   id="contact_email" name="contact_email" 
                                   value="{{ old('contact_email', $supplier->contact_email) }}" 
                                   placeholder="supplier@company.com">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="contact_phone">Phone Number</label>
                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                   id="contact_phone" name="contact_phone" 
                                   value="{{ old('contact_phone', $supplier->contact_phone) }}" 
                                   placeholder="+62 xxx xxxx xxxx">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="website">Website</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                   id="website" name="website" 
                                   value="{{ old('website', $supplier->website) }}" 
                                   placeholder="https://www.supplier.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Complete address including city and postal code">{{ old('address', $supplier->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Business Terms -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Business Terms</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="payment_terms">Payment Terms (Days)</label>
                            <input type="number" class="form-control @error('payment_terms') is-invalid @enderror" 
                                   id="payment_terms" name="payment_terms" 
                                   value="{{ old('payment_terms', $supplier->payment_terms) }}" 
                                   min="1" max="365" placeholder="30">
                            <div class="form-text">Number of days for payment (1-365)</div>
                            @error('payment_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="delivery_terms">Delivery Terms</label>
                            <select class="form-select @error('delivery_terms') is-invalid @enderror" id="delivery_terms" name="delivery_terms">
                                <option value="">Select Terms</option>
                                <option value="FOB" {{ old('delivery_terms', $supplier->delivery_terms) === 'FOB' ? 'selected' : '' }}>FOB (Free on Board)</option>
                                <option value="CIF" {{ old('delivery_terms', $supplier->delivery_terms) === 'CIF' ? 'selected' : '' }}>CIF (Cost, Insurance, Freight)</option>
                                <option value="EXW" {{ old('delivery_terms', $supplier->delivery_terms) === 'EXW' ? 'selected' : '' }}>EXW (Ex Works)</option>
                                <option value="DDP" {{ old('delivery_terms', $supplier->delivery_terms) === 'DDP' ? 'selected' : '' }}>DDP (Delivered Duty Paid)</option>
                                <option value="FCA" {{ old('delivery_terms', $supplier->delivery_terms) === 'FCA' ? 'selected' : '' }}>FCA (Free Carrier)</option>
                            </select>
                            @error('delivery_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="currency">Currency</label>
                            <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency">
                                <option value="IDR" {{ old('currency', $supplier->currency) === 'IDR' ? 'selected' : '' }}>IDR (Indonesian Rupiah)</option>
                                <option value="USD" {{ old('currency', $supplier->currency) === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                                <option value="EUR" {{ old('currency', $supplier->currency) === 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                                <option value="SGD" {{ old('currency', $supplier->currency) === 'SGD' ? 'selected' : '' }}>SGD (Singapore Dollar)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Additional Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="tax_id">Tax ID / NPWP</label>
                            <input type="text" class="form-control @error('tax_id') is-invalid @enderror" 
                                   id="tax_id" name="tax_id" 
                                   value="{{ old('tax_id', $supplier->tax_id) }}" 
                                   placeholder="XX.XXX.XXX.X-XXX.XXX">
                            @error('tax_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="bank_account">Bank Account</label>
                            <input type="text" class="form-control @error('bank_account') is-invalid @enderror" 
                                   id="bank_account" name="bank_account" 
                                   value="{{ old('bank_account', $supplier->bank_account) }}" 
                                   placeholder="Bank Name - Account Number">
                            @error('bank_account')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="products_services">Products/Services</label>
                            <input type="text" class="form-control @error('products_services') is-invalid @enderror" 
                                   id="products_services" name="products_services" 
                                   value="{{ old('products_services', $supplier->products_services) }}" 
                                   placeholder="Comma-separated list of products or services">
                            <div class="form-text">List the main products or services this supplier provides</div>
                            @error('products_services')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any additional notes about this supplier">{{ old('notes', $supplier->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Performance Settings -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Performance Settings</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="performance_score">Performance Score (%)</label>
                            <input type="number" class="form-control @error('performance_score') is-invalid @enderror" 
                                   id="performance_score" name="performance_score" 
                                   value="{{ old('performance_score', $supplier->performance_score) }}" 
                                   min="0" max="100" step="0.1">
                            <div class="form-text">Current performance score (0-100)</div>
                            @error('performance_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4 pt-2">
                                <input class="form-check-input" type="checkbox" id="is_preferred" name="is_preferred" 
                                       value="1" {{ old('is_preferred', $supplier->is_preferred) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_preferred">
                                    Preferred Supplier
                                </label>
                                <div class="form-text">Mark as preferred for priority consideration</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4 pt-2">
                                <input class="form-check-input" type="checkbox" id="can_dropship" name="can_dropship" 
                                       value="1" {{ old('can_dropship', $supplier->can_dropship) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_dropship">
                                    Can Dropship
                                </label>
                                <div class="form-text">Supplier can deliver directly to customers</div>
                            </div>
                        </div>

                        <!-- Audit Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Record Information</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Created At</label>
                            <input type="text" class="form-control" value="{{ $supplier->created_at->format('M d, Y H:i') }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control" value="{{ $supplier->updated_at->format('M d, Y H:i') }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Total Purchase Orders</label>
                            <input type="text" class="form-control" value="{{ $supplier->purchaseOrders->count() ?? 0 }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('procurement.suppliers.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x me-1"></i>Cancel
                        </a>
                        @if($supplier->status === 'inactive')
                        <button type="button" class="btn btn-outline-success" onclick="toggleStatus('{{ $supplier->id_supplier }}', 'inactive')">
                            <i class="bx bx-check-circle me-1"></i>Activate Supplier
                        </button>
                        @else
                        <button type="button" class="btn btn-outline-warning" onclick="toggleStatus('{{ $supplier->id_supplier }}', 'active')">
                            <i class="bx bx-x-circle me-1"></i>Deactivate Supplier
                        </button>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary me-2" onclick="saveDraft()">
                            <i class="bx bx-save me-1"></i>Save as Draft
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>Update Supplier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for better dropdowns
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#category, #delivery_terms, #currency, #status').select2({
            theme: 'bootstrap-5'
        });
    }
    
    // Initialize Tagify for products/services
    if (typeof Tagify !== 'undefined') {
        new Tagify(document.getElementById('products_services'), {
            placeholder: 'Add products or services...'
        });
    }
});

function saveDraft() {
    // Add draft status and submit
    const form = document.getElementById('supplierForm');
    const draftInput = document.createElement('input');
    draftInput.type = 'hidden';
    draftInput.name = 'save_as_draft';
    draftInput.value = '1';
    form.appendChild(draftInput);
    form.submit();
}

function toggleStatus(supplierId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this supplier?`)) {
        fetch(`{{ route('procurement.suppliers.toggle_status', ':id') }}`.replace(':id', supplierId), {
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

// Form validation
document.getElementById('supplierForm').addEventListener('submit', function(e) {
    const requiredFields = ['supplier_name'];
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
    
    if (!isValid) {
        e.preventDefault();
        // Focus on first invalid field
        document.querySelector('.is-invalid').focus();
    }
});
</script>

@endsection