@extends('layouts/layoutMaster')

@section('title', 'Add New Customer - Procurement')

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
                    <h5 class="card-title mb-0">Add New Customer</h5>
                    <p class="text-muted mt-1 mb-0">Create a new customer profile for procurement requests</p>
                </div>
                <a href="{{ route('procurement.customers.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i>Back to Customers
                </a>
            </div>

            <form action="{{ route('procurement.customers.store') }}" method="POST" id="customerForm">
                @csrf
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="text-muted fw-semibold">Basic Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="customer_name">Customer Name *</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" name="customer_name" value="{{ old('customer_name') }}" 
                                   placeholder="Enter customer name" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="customer_code">Customer Code</label>
                            <input type="text" class="form-control @error('customer_code') is-invalid @enderror" 
                                   id="customer_code" name="customer_code" value="{{ old('customer_code') }}" 
                                   placeholder="Auto-generated if empty">
                            <div class="form-text">Leave empty to auto-generate based on customer name</div>
                            @error('customer_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="customer_type">Customer Type</label>
                            <select class="form-select @error('customer_type') is-invalid @enderror" id="customer_type" name="customer_type">
                                <option value="">Select Type</option>
                                <option value="corporate" {{ old('customer_type') === 'corporate' ? 'selected' : '' }}>Corporate</option>
                                <option value="individual" {{ old('customer_type') === 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="government" {{ old('customer_type') === 'government' ? 'selected' : '' }}>Government</option>
                                <option value="other" {{ old('customer_type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('customer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                   id="contact_person" name="contact_person" value="{{ old('contact_person') }}" 
                                   placeholder="Primary contact name">
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="contact_email">Email Address</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                   id="contact_email" name="contact_email" value="{{ old('contact_email') }}" 
                                   placeholder="customer@company.com">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="contact_phone">Phone Number</label>
                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                   id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" 
                                   placeholder="+62 xxx xxxx xxxx">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="tax_id">Tax ID / NPWP</label>
                            <input type="text" class="form-control @error('tax_id') is-invalid @enderror" 
                                   id="tax_id" name="tax_id" value="{{ old('tax_id') }}" 
                                   placeholder="XX.XXX.XXX.X-XXX.XXX">
                            @error('tax_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Address Information</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="address">Primary Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Complete primary address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="city">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" 
                                   placeholder="City name">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="postal_code">Postal Code</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                   id="postal_code" name="postal_code" value="{{ old('postal_code') }}" 
                                   placeholder="12345">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same_billing_address" name="same_billing_address" 
                                       value="1" {{ old('same_billing_address', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="same_billing_address">
                                    Use same address for billing
                                </label>
                            </div>
                        </div>

                        <div id="billing_address_section" class="col-12" style="display: none;">
                            <label class="form-label" for="billing_address">Billing Address</label>
                            <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                      id="billing_address" name="billing_address" rows="3" 
                                      placeholder="Complete billing address if different from primary address">{{ old('billing_address') }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Business Terms -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Business Terms</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="payment_terms">Payment Terms (Days)</label>
                            <input type="number" class="form-control @error('payment_terms') is-invalid @enderror" 
                                   id="payment_terms" name="payment_terms" value="{{ old('payment_terms', 30) }}" 
                                   min="1" max="365" placeholder="30">
                            <div class="form-text">Number of days for payment (1-365)</div>
                            @error('payment_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="credit_limit">Credit Limit</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('credit_limit') is-invalid @enderror" 
                                       id="credit_limit" name="credit_limit" value="{{ old('credit_limit') }}" 
                                       min="0" step="1000" placeholder="0">
                            </div>
                            <div class="form-text">Maximum credit limit (0 for unlimited)</div>
                            @error('credit_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Additional Information</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any additional notes about this customer">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer Preferences -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Customer Preferences</h6>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_vip" name="is_vip" 
                                       value="1" {{ old('is_vip') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_vip">
                                    VIP Customer
                                </label>
                                <div class="form-text">Priority customer with special treatment</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allow_credit" name="allow_credit" 
                                       value="1" {{ old('allow_credit', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_credit">
                                    Allow Credit
                                </label>
                                <div class="form-text">Customer can make purchases on credit</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="auto_approve" name="auto_approve" 
                                       value="1" {{ old('auto_approve') ? 'checked' : '' }}>
                                <label class="form-check-label" for="auto_approve">
                                    Auto Approve Requests
                                </label>
                                <div class="form-text">Automatically approve procurement requests</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('procurement.customers.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-x me-1"></i>Cancel
                    </a>
                    <div>
                        <button type="button" class="btn btn-outline-primary me-2" onclick="saveDraft()">
                            <i class="bx bx-save me-1"></i>Save as Draft
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>Create Customer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate customer code from name
    const nameInput = document.getElementById('customer_name');
    const codeInput = document.getElementById('customer_code');
    
    nameInput.addEventListener('input', function() {
        if (!codeInput.value || codeInput.hasAttribute('data-auto-generated')) {
            const code = generateCustomerCode(this.value);
            codeInput.value = code;
            codeInput.setAttribute('data-auto-generated', 'true');
        }
    });
    
    codeInput.addEventListener('input', function() {
        if (this.value) {
            this.removeAttribute('data-auto-generated');
        }
    });
    
    // Billing address toggle
    const sameBillingCheckbox = document.getElementById('same_billing_address');
    const billingAddressSection = document.getElementById('billing_address_section');
    
    function toggleBillingAddress() {
        if (sameBillingCheckbox.checked) {
            billingAddressSection.style.display = 'none';
        } else {
            billingAddressSection.style.display = 'block';
        }
    }
    
    sameBillingCheckbox.addEventListener('change', toggleBillingAddress);
    toggleBillingAddress(); // Initial state
    
    // Initialize Select2 for better dropdowns
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#customer_type, #status').select2({
            theme: 'bootstrap-5'
        });
    }
    
    // Credit limit formatting
    const creditLimitInput = document.getElementById('credit_limit');
    creditLimitInput.addEventListener('input', function() {
        // Format number with thousands separator
        let value = this.value.replace(/\D/g, '');
        if (value) {
            this.value = parseInt(value).toLocaleString('id-ID');
        }
    });
});

function generateCustomerCode(name) {
    if (!name) return '';
    
    // Take first 3 characters of each word, uppercase
    const words = name.trim().split(' ');
    let code = '';
    
    words.forEach(word => {
        if (word.length > 0) {
            code += word.substring(0, 3).toUpperCase();
        }
    });
    
    // Limit to 6 characters and add random numbers if needed
    if (code.length > 6) {
        code = code.substring(0, 6);
    }
    
    // Add timestamp-based suffix to ensure uniqueness
    const suffix = Date.now().toString().slice(-3);
    return code + suffix;
}

function saveDraft() {
    // Add draft status and submit
    const form = document.getElementById('customerForm');
    const draftInput = document.createElement('input');
    draftInput.type = 'hidden';
    draftInput.name = 'save_as_draft';
    draftInput.value = '1';
    form.appendChild(draftInput);
    form.submit();
}

// Form validation
document.getElementById('customerForm').addEventListener('submit', function(e) {
    const requiredFields = ['customer_name'];
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