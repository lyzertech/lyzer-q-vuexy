@extends('layouts/layoutMaster')

@section('title', 'Create Purchase Order - Procurement')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js'])
@endsection


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Create Purchase Order</h5>
                    <p class="text-muted mt-1 mb-0">Create a new purchase order from approved procurement request</p>
                </div>
                <a href="{{ route('procurement.po.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i>Back to POs
                </a>
            </div>

            <form action="{{ route('procurement.po.store') }}" method="POST" id="purchaseOrderForm">
                @csrf
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Request Selection -->
                        <div class="col-12">
                            <h6 class="text-muted fw-semibold">Request Selection</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="procurement_request_id">Procurement Request *</label>
                            <select class="form-select @error('procurement_request_id') is-invalid @enderror" 
                                    id="procurement_request_id" name="procurement_request_id" required>
                                <option value="">Select approved request</option>
                                @foreach($approvedRequests ?? [] as $request)
                                    <option value="{{ $request->id_procurement_request }}" 
                                            data-customer="{{ $request->customer->customer_name ?? 'Internal' }}"
                                            data-title="{{ $request->title }}"
                                            {{ old('procurement_request_id', request('request_id')) == $request->id_procurement_request ? 'selected' : '' }}>
                                        {{ $request->request_number }} - {{ Str::limit($request->title, 50) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Only approved requests without existing POs are shown</div>
                            @error('procurement_request_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6" id="requestInfoSection" style="display: none;">
                            <label class="form-label">Request Information</label>
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <div class="small">
                                        <div><strong>Customer:</strong> <span id="requestCustomer">-</span></div>
                                        <div><strong>Title:</strong> <span id="requestTitle">-</span></div>
                                        <div><strong>Items:</strong> <span id="requestItemsCount">0</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PO Details -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Purchase Order Details</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="po_number">PO Number</label>
                            <input type="text" class="form-control @error('po_number') is-invalid @enderror" 
                                   id="po_number" name="po_number" value="{{ old('po_number') }}" 
                                   placeholder="Auto-generated if empty">
                            <div class="form-text">Leave empty to auto-generate</div>
                            @error('po_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="po_date">PO Date *</label>
                            <input type="text" class="form-control @error('po_date') is-invalid @enderror" 
                                   id="po_date" name="po_date" value="{{ old('po_date', date('Y-m-d')) }}" 
                                   placeholder="Select date" required>
                            @error('po_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="expected_delivery_date">Expected Delivery Date</label>
                            <input type="text" class="form-control @error('expected_delivery_date') is-invalid @enderror" 
                                   id="expected_delivery_date" name="expected_delivery_date" 
                                   value="{{ old('expected_delivery_date') }}" placeholder="Select date">
                            @error('expected_delivery_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Supplier Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Supplier Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="supplier_id">Supplier *</label>
                            <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                    id="supplier_id" name="supplier_id" required>
                                <option value="">Select supplier</option>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id_supplier }}" 
                                            data-payment-terms="{{ $supplier->payment_terms }}"
                                            data-delivery-terms="{{ $supplier->delivery_terms }}"
                                            data-currency="{{ $supplier->currency }}"
                                            {{ old('supplier_id', request('supplier_id')) == $supplier->id_supplier ? 'selected' : '' }}>
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6" id="supplierInfoSection" style="display: none;">
                            <label class="form-label">Supplier Information</label>
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <div class="small">
                                        <div><strong>Payment Terms:</strong> <span id="supplierPaymentTerms">-</span></div>
                                        <div><strong>Delivery Terms:</strong> <span id="supplierDeliveryTerms">-</span></div>
                                        <div><strong>Currency:</strong> <span id="supplierCurrency">IDR</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Terms -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Business Terms</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="payment_terms">Payment Terms (Days)</label>
                            <input type="number" class="form-control @error('payment_terms') is-invalid @enderror" 
                                   id="payment_terms" name="payment_terms" value="{{ old('payment_terms', 30) }}" 
                                   min="1" max="365" placeholder="30">
                            @error('payment_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="delivery_terms">Delivery Terms</label>
                            <select class="form-select @error('delivery_terms') is-invalid @enderror" id="delivery_terms" name="delivery_terms">
                                <option value="">Select Terms</option>
                                <option value="FOB" {{ old('delivery_terms') === 'FOB' ? 'selected' : '' }}>FOB (Free on Board)</option>
                                <option value="CIF" {{ old('delivery_terms') === 'CIF' ? 'selected' : '' }}>CIF (Cost, Insurance, Freight)</option>
                                <option value="EXW" {{ old('delivery_terms') === 'EXW' ? 'selected' : '' }}>EXW (Ex Works)</option>
                                <option value="DDP" {{ old('delivery_terms') === 'DDP' ? 'selected' : '' }}>DDP (Delivered Duty Paid)</option>
                                <option value="FCA" {{ old('delivery_terms') === 'FCA' ? 'selected' : '' }}>FCA (Free Carrier)</option>
                            </select>
                            @error('delivery_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="currency">Currency</label>
                            <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency">
                                <option value="IDR" {{ old('currency', 'IDR') === 'IDR' ? 'selected' : '' }}>IDR (Indonesian Rupiah)</option>
                                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                                <option value="SGD" {{ old('currency') === 'SGD' ? 'selected' : '' }}>SGD (Singapore Dollar)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Items Section -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-muted fw-semibold">Purchase Order Items</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="loadRequestItems()" id="loadItemsBtn" style="display: none;">
                                    <i class="bx bx-refresh me-1"></i>Load Request Items
                                </button>
                            </div>
                        </div>

                        <div class="col-12" id="itemsSection" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Requested Qty</th>
                                            <th>PO Qty</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Notes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <!-- Items will be loaded dynamically -->
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-info">
                                            <td colspan="4" class="text-end fw-bold">Total Amount:</td>
                                            <td class="fw-bold">
                                                <span id="totalAmount">Rp 0</span>
                                                <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
                                      placeholder="Additional notes, special instructions, or terms">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('procurement.po.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-x me-1"></i>Cancel
                    </a>
                    <div>
                        <button type="button" class="btn btn-outline-info me-2" onclick="previewPO()">
                            <i class="bx bx-show me-1"></i>Preview
                        </button>
                        <button type="submit" class="btn btn-primary" name="action" value="draft">
                            <i class="bx bx-save me-1"></i>Save as Draft
                        </button>
                        <button type="submit" class="btn btn-success ms-1" name="action" value="send">
                            <i class="bx bx-send me-1"></i>Save & Send
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let itemsData = [];

document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    if (typeof flatpickr !== 'undefined') {
        flatpickr("#po_date", {
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });
        
        flatpickr("#expected_delivery_date", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    }
    
    // Initialize Select2
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#procurement_request_id, #supplier_id, #delivery_terms, #currency').select2({
            theme: 'bootstrap-5'
        });
    }
    
    // Request selection change handler
    document.getElementById('procurement_request_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            // Show request info
            document.getElementById('requestCustomer').textContent = selectedOption.dataset.customer || '-';
            document.getElementById('requestTitle').textContent = selectedOption.dataset.title || '-';
            document.getElementById('requestInfoSection').style.display = 'block';
            document.getElementById('loadItemsBtn').style.display = 'inline-block';
            
            // Load items for selected request
            loadRequestItems();
        } else {
            document.getElementById('requestInfoSection').style.display = 'none';
            document.getElementById('itemsSection').style.display = 'none';
            document.getElementById('loadItemsBtn').style.display = 'none';
        }
    });
    
    // Supplier selection change handler
    document.getElementById('supplier_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            // Auto-fill supplier terms
            const paymentTerms = selectedOption.dataset.paymentTerms;
            const deliveryTerms = selectedOption.dataset.deliveryTerms;
            const currency = selectedOption.dataset.currency;
            
            if (paymentTerms) {
                document.getElementById('payment_terms').value = paymentTerms;
                document.getElementById('supplierPaymentTerms').textContent = paymentTerms + ' days';
            }
            if (deliveryTerms) {
                document.getElementById('delivery_terms').value = deliveryTerms;
                document.getElementById('supplierDeliveryTerms').textContent = deliveryTerms;
            }
            if (currency) {
                document.getElementById('currency').value = currency;
                document.getElementById('supplierCurrency').textContent = currency;
            }
            
            document.getElementById('supplierInfoSection').style.display = 'block';
        } else {
            document.getElementById('supplierInfoSection').style.display = 'none';
        }
    });
    
    // Trigger change events if values are pre-selected
    const requestSelect = document.getElementById('procurement_request_id');
    const supplierSelect = document.getElementById('supplier_id');
    
    if (requestSelect.value) {
        requestSelect.dispatchEvent(new Event('change'));
    }
    if (supplierSelect.value) {
        supplierSelect.dispatchEvent(new Event('change'));
    }
});

function loadRequestItems() {
    const requestId = document.getElementById('procurement_request_id').value;
    if (!requestId) return;
    
    fetch(`{{ route('procurement.request_items', ':id') }}`.replace(':id', requestId))
        .then(response => response.json())
        .then(data => {
            itemsData = data.items || [];
            renderItemsTable();
            document.getElementById('requestItemsCount').textContent = itemsData.length;
            document.getElementById('itemsSection').style.display = 'block';
        })
        .catch(error => {
            console.error('Error loading items:', error);
            alert('Error loading request items');
        });
}

function renderItemsTable() {
    const tbody = document.getElementById('itemsTableBody');
    tbody.innerHTML = '';
    
    itemsData.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <strong>${item.product_name}</strong>
                <br><small class="text-muted">${item.product_code || ''}</small>
                <input type="hidden" name="items[${index}][product_id]" value="${item.id_product}">
                <input type="hidden" name="items[${index}][procurement_item_id]" value="${item.id_procurement_item}">
            </td>
            <td>
                <span class="fw-medium">${item.quantity}</span>
                <br><small class="text-muted">${item.unit_of_measure || 'PCS'}</small>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" 
                       name="items[${index}][quantity]" 
                       value="${item.quantity}" 
                       min="1" max="${item.quantity}" 
                       onchange="calculateItemTotal(${index})" required>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" 
                           name="items[${index}][unit_price]" 
                           value="${item.estimated_price || 0}" 
                           min="0" step="0.01" 
                           onchange="calculateItemTotal(${index})" required>
                </div>
            </td>
            <td>
                <span class="fw-medium" id="itemTotal_${index}">Rp 0</span>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" 
                       name="items[${index}][notes]" 
                       placeholder="Item notes" maxlength="255">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" 
                        onclick="removeItem(${index})" title="Remove item">
                    <i class="bx bx-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        
        // Calculate initial total for this item
        calculateItemTotal(index);
    });
    
    calculateGrandTotal();
}

function calculateItemTotal(index) {
    const quantityInput = document.querySelector(`input[name="items[${index}][quantity]"]`);
    const priceInput = document.querySelector(`input[name="items[${index}][unit_price]"]`);
    const totalSpan = document.getElementById(`itemTotal_${index}`);
    
    if (quantityInput && priceInput && totalSpan) {
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = quantity * price;
        
        totalSpan.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
        
        calculateGrandTotal();
    }
}

function calculateGrandTotal() {
    let grandTotal = 0;
    
    itemsData.forEach((item, index) => {
        const quantityInput = document.querySelector(`input[name="items[${index}][quantity]"]`);
        const priceInput = document.querySelector(`input[name="items[${index}][unit_price]"]`);
        
        if (quantityInput && priceInput) {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            grandTotal += quantity * price;
        }
    });
    
    document.getElementById('totalAmount').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
    document.getElementById('totalAmountInput').value = grandTotal;
}

function removeItem(index) {
    if (confirm('Remove this item from the purchase order?')) {
        itemsData.splice(index, 1);
        renderItemsTable();
    }
}

function previewPO() {
    // Basic validation
    const requestId = document.getElementById('procurement_request_id').value;
    const supplierId = document.getElementById('supplier_id').value;
    
    if (!requestId) {
        alert('Please select a procurement request');
        return;
    }
    if (!supplierId) {
        alert('Please select a supplier');
        return;
    }
    if (itemsData.length === 0) {
        alert('No items to include in the purchase order');
        return;
    }
    
    // Generate preview (could open in modal or new window)
    alert('PO Preview functionality to be implemented');
}

// Form validation
document.getElementById('purchaseOrderForm').addEventListener('submit', function(e) {
    const requestId = document.getElementById('procurement_request_id').value;
    const supplierId = document.getElementById('supplier_id').value;
    
    if (!requestId) {
        alert('Please select a procurement request');
        e.preventDefault();
        return;
    }
    if (!supplierId) {
        alert('Please select a supplier');
        e.preventDefault();
        return;
    }
    if (itemsData.length === 0) {
        alert('No items to include in the purchase order');
        e.preventDefault();
        return;
    }
    
    // Validate that all items have quantities and prices
    let hasErrors = false;
    itemsData.forEach((item, index) => {
        const quantityInput = document.querySelector(`input[name="items[${index}][quantity]"]`);
        const priceInput = document.querySelector(`input[name="items[${index}][unit_price]"]`);
        
        if (!quantityInput.value || quantityInput.value <= 0) {
            quantityInput.classList.add('is-invalid');
            hasErrors = true;
        } else {
            quantityInput.classList.remove('is-invalid');
        }
        
        if (!priceInput.value || priceInput.value < 0) {
            priceInput.classList.add('is-invalid');
            hasErrors = true;
        } else {
            priceInput.classList.remove('is-invalid');
        }
    });
    
    if (hasErrors) {
        alert('Please fill in all item quantities and prices');
        e.preventDefault();
        return;
    }
});
</script>

@endsection