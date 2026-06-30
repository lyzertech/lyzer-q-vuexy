@extends('layouts/layoutMaster')

@section('title', 'Edit Purchase Order - Procurement')

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
                    <h5 class="card-title mb-0">Edit Purchase Order</h5>
                    <p class="text-muted mt-1 mb-0">Update purchase order information and status</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('procurement.po.show', $purchaseOrder->id_purchase_order) }}" class="btn btn-outline-info btn-sm">
                        <i class="bx bx-show me-1"></i>View Details
                    </a>
                    <a href="{{ route('procurement.po.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to POs
                    </a>
                </div>
            </div>

            <form action="{{ route('procurement.po.update', $purchaseOrder->id_purchase_order) }}" method="POST" id="purchaseOrderForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Status Badge -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-muted fw-semibold">Purchase Order Status</h6>
                                <span class="badge bg-{{ \App\Enums\procurement\PurchaseOrderStatus::from($purchaseOrder->status)->color() }} fs-6">
                                    {{ \App\Enums\procurement\PurchaseOrderStatus::from($purchaseOrder->status)->label() }}
                                </span>
                            </div>
                            @if($purchaseOrder->status !== 'draft')
                                <div class="alert alert-info mt-2">
                                    <i class="bx bx-info-circle me-2"></i>
                                    Some fields are restricted because this PO has been {{ $purchaseOrder->status }}.
                                </div>
                            @endif
                        </div>

                        <!-- Request Information (Read-only) -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Request Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Procurement Request</label>
                            <input type="text" class="form-control" 
                                   value="{{ $purchaseOrder->procurementRequest->request_number }} - {{ $purchaseOrder->procurementRequest->title }}" 
                                   readonly>
                            <input type="hidden" name="procurement_request_id" value="{{ $purchaseOrder->procurement_request_id }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Customer</label>
                            <input type="text" class="form-control" 
                                   value="{{ $purchaseOrder->procurementRequest->customer->customer_name ?? 'Internal' }}" 
                                   readonly>
                        </div>

                        <!-- PO Details -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Purchase Order Details</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="po_number">PO Number</label>
                            <input type="text" class="form-control @error('po_number') is-invalid @enderror" 
                                   id="po_number" name="po_number" 
                                   value="{{ old('po_number', $purchaseOrder->po_number) }}" 
                                   {{ $purchaseOrder->status !== 'draft' ? 'readonly' : '' }}>
                            @error('po_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="po_date">PO Date</label>
                            <input type="text" class="form-control @error('po_date') is-invalid @enderror" 
                                   id="po_date" name="po_date" 
                                   value="{{ old('po_date', $purchaseOrder->po_date->format('Y-m-d')) }}" 
                                   {{ $purchaseOrder->status !== 'draft' ? 'readonly' : '' }}>
                            @error('po_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="expected_delivery_date">Expected Delivery Date</label>
                            <input type="text" class="form-control @error('expected_delivery_date') is-invalid @enderror" 
                                   id="expected_delivery_date" name="expected_delivery_date" 
                                   value="{{ old('expected_delivery_date', $purchaseOrder->expected_delivery_date?->format('Y-m-d')) }}" 
                                   {{ in_array($purchaseOrder->status, ['completed', 'cancelled']) ? 'readonly' : '' }}>
                            @error('expected_delivery_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Supplier Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Supplier Information</h6>
                        </div>

                        @if($purchaseOrder->status === 'draft')
                        <div class="col-md-6">
                            <label class="form-label" for="supplier_id">Supplier</label>
                            <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                    id="supplier_id" name="supplier_id" required>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id_supplier }}" 
                                            data-payment-terms="{{ $supplier->payment_terms }}"
                                            data-delivery-terms="{{ $supplier->delivery_terms }}"
                                            data-currency="{{ $supplier->currency }}"
                                            {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id_supplier ? 'selected' : '' }}>
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <input type="text" class="form-control" 
                                   value="{{ $purchaseOrder->supplier->supplier_name }}" readonly>
                            <input type="hidden" name="supplier_id" value="{{ $purchaseOrder->supplier_id }}">
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label">Supplier Contact</label>
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <div class="small">
                                        <div><strong>Email:</strong> {{ $purchaseOrder->supplier->contact_email ?? 'Not specified' }}</div>
                                        <div><strong>Phone:</strong> {{ $purchaseOrder->supplier->contact_phone ?? 'Not specified' }}</div>
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
                                   id="payment_terms" name="payment_terms" 
                                   value="{{ old('payment_terms', $purchaseOrder->payment_terms) }}" 
                                   min="1" max="365"
                                   {{ in_array($purchaseOrder->status, ['completed', 'cancelled']) ? 'readonly' : '' }}>
                            @error('payment_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="delivery_terms">Delivery Terms</label>
                            <select class="form-select @error('delivery_terms') is-invalid @enderror" 
                                    id="delivery_terms" name="delivery_terms"
                                    {{ in_array($purchaseOrder->status, ['completed', 'cancelled']) ? 'disabled' : '' }}>
                                <option value="">Select Terms</option>
                                <option value="FOB" {{ old('delivery_terms', $purchaseOrder->delivery_terms) === 'FOB' ? 'selected' : '' }}>FOB (Free on Board)</option>
                                <option value="CIF" {{ old('delivery_terms', $purchaseOrder->delivery_terms) === 'CIF' ? 'selected' : '' }}>CIF (Cost, Insurance, Freight)</option>
                                <option value="EXW" {{ old('delivery_terms', $purchaseOrder->delivery_terms) === 'EXW' ? 'selected' : '' }}>EXW (Ex Works)</option>
                                <option value="DDP" {{ old('delivery_terms', $purchaseOrder->delivery_terms) === 'DDP' ? 'selected' : '' }}>DDP (Delivered Duty Paid)</option>
                                <option value="FCA" {{ old('delivery_terms', $purchaseOrder->delivery_terms) === 'FCA' ? 'selected' : '' }}>FCA (Free Carrier)</option>
                            </select>
                            @error('delivery_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="currency">Currency</label>
                            <select class="form-select @error('currency') is-invalid @enderror" 
                                    id="currency" name="currency"
                                    {{ $purchaseOrder->status !== 'draft' ? 'disabled' : '' }}>
                                <option value="IDR" {{ old('currency', $purchaseOrder->currency) === 'IDR' ? 'selected' : '' }}>IDR (Indonesian Rupiah)</option>
                                <option value="USD" {{ old('currency', $purchaseOrder->currency) === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                                <option value="EUR" {{ old('currency', $purchaseOrder->currency) === 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                                <option value="SGD" {{ old('currency', $purchaseOrder->currency) === 'SGD' ? 'selected' : '' }}>SGD (Singapore Dollar)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Items Section -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Purchase Order Items</h6>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Requested Qty</th>
                                            <th>PO Qty</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Notes</th>
                                            @if($purchaseOrder->status === 'draft')
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchaseOrder->items as $index => $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->procurementItem->product->product_name }}</strong>
                                                <br><small class="text-muted">{{ $item->procurementItem->product->product_code ?? '' }}</small>
                                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id_po_item }}">
                                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->procurementItem->id_product }}">
                                                <input type="hidden" name="items[{{ $index }}][procurement_item_id]" value="{{ $item->id_procurement_item }}">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $item->procurementItem->quantity }}</span>
                                                <br><small class="text-muted">{{ $item->procurementItem->unit_of_measure ?? 'PCS' }}</small>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="items[{{ $index }}][quantity]" 
                                                       value="{{ old('items.'.$index.'.quantity', $item->quantity) }}" 
                                                       min="1" max="{{ $item->procurementItem->quantity }}" 
                                                       onchange="calculateItemTotal({{ $index }})" 
                                                       {{ $purchaseOrder->status !== 'draft' ? 'readonly' : '' }} required>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control" 
                                                           name="items[{{ $index }}][unit_price]" 
                                                           value="{{ old('items.'.$index.'.unit_price', $item->unit_price) }}" 
                                                           min="0" step="0.01" 
                                                           onchange="calculateItemTotal({{ $index }})" 
                                                           {{ $purchaseOrder->status !== 'draft' ? 'readonly' : '' }} required>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-medium" id="itemTotal_{{ $index }}">
                                                    Rp {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="items[{{ $index }}][notes]" 
                                                       value="{{ old('items.'.$index.'.notes', $item->notes) }}" 
                                                       placeholder="Item notes" maxlength="255"
                                                       {{ in_array($purchaseOrder->status, ['completed', 'cancelled']) ? 'readonly' : '' }}>
                                            </td>
                                            @if($purchaseOrder->status === 'draft')
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="removeItem({{ $index }})" title="Remove item">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-info">
                                            <td colspan="{{ $purchaseOrder->status === 'draft' ? 5 : 4 }}" class="text-end fw-bold">Total Amount:</td>
                                            <td class="fw-bold">
                                                <span id="totalAmount">Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</span>
                                                <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ $purchaseOrder->total_amount }}">
                                            </td>
                                            @if($purchaseOrder->status === 'draft')
                                            <td></td>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Additional Information</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Additional notes, special instructions, or terms"
                                      {{ in_array($purchaseOrder->status, ['completed', 'cancelled']) ? 'readonly' : '' }}>{{ old('notes', $purchaseOrder->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Audit Information -->
                        <div class="col-12 mt-4">
                            <hr class="my-3">
                            <h6 class="text-muted fw-semibold">Record Information</h6>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Created At</label>
                            <input type="text" class="form-control" value="{{ $purchaseOrder->created_at->format('M d, Y H:i') }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control" value="{{ $purchaseOrder->updated_at->format('M d, Y H:i') }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Created By</label>
                            <input type="text" class="form-control" value="{{ $purchaseOrder->creator->name ?? 'System' }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Current Status</label>
                            <input type="text" class="form-control" value="{{ \App\Enums\procurement\PurchaseOrderStatus::from($purchaseOrder->status)->label() }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('procurement.po.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x me-1"></i>Cancel
                        </a>
                        
                        @if($purchaseOrder->status === 'sent')
                        <button type="button" class="btn btn-outline-warning" onclick="acknowledgePO('{{ $purchaseOrder->id_purchase_order }}')">
                            <i class="bx bx-check me-1"></i>Mark Acknowledged
                        </button>
                        @endif
                        
                        @if(in_array($purchaseOrder->status, ['draft', 'sent', 'acknowledged']))
                        <button type="button" class="btn btn-outline-danger" onclick="cancelPO('{{ $purchaseOrder->id_purchase_order }}')">
                            <i class="bx bx-x-circle me-1"></i>Cancel PO
                        </button>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('procurement.po.pdf', $purchaseOrder->id_purchase_order) }}" 
                           target="_blank" class="btn btn-outline-info">
                            <i class="bx bx-file-blank me-1"></i>Download PDF
                        </a>
                        
                        @if($purchaseOrder->status === 'draft')
                        <button type="submit" class="btn btn-primary" name="action" value="save">
                            <i class="bx bx-save me-1"></i>Update PO
                        </button>
                        <button type="submit" class="btn btn-success" name="action" value="send">
                            <i class="bx bx-send me-1"></i>Update & Send
                        </button>
                        @elseif(in_array($purchaseOrder->status, ['sent', 'acknowledged']))
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>Update PO
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers only if fields are not readonly
    if (typeof flatpickr !== 'undefined') {
        const poDateField = document.getElementById('po_date');
        const deliveryDateField = document.getElementById('expected_delivery_date');
        
        if (!poDateField.readOnly) {
            flatpickr("#po_date", {
                dateFormat: "Y-m-d"
            });
        }
        
        if (!deliveryDateField.readOnly) {
            flatpickr("#expected_delivery_date", {
                dateFormat: "Y-m-d",
                minDate: "today"
            });
        }
    }
    
    // Initialize Select2 only for enabled fields
    if (typeof $ !== 'undefined' && $.fn.select2) {
        const supplierSelect = $('#supplier_id');
        const deliverySelect = $('#delivery_terms');
        const currencySelect = $('#currency');
        
        if (!supplierSelect.prop('disabled')) {
            supplierSelect.select2({ theme: 'bootstrap-5' });
        }
        if (!deliverySelect.prop('disabled')) {
            deliverySelect.select2({ theme: 'bootstrap-5' });
        }
        if (!currencySelect.prop('disabled')) {
            currencySelect.select2({ theme: 'bootstrap-5' });
        }
    }
    
    // Calculate initial grand total
    calculateGrandTotal();
});

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
    
    // Get all quantity and price inputs
    const quantityInputs = document.querySelectorAll('input[name^="items"][name$="[quantity]"]');
    const priceInputs = document.querySelectorAll('input[name^="items"][name$="[unit_price]"]');
    
    for (let i = 0; i < quantityInputs.length; i++) {
        const quantity = parseFloat(quantityInputs[i].value) || 0;
        const price = parseFloat(priceInputs[i].value) || 0;
        grandTotal += quantity * price;
    }
    
    document.getElementById('totalAmount').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
    document.getElementById('totalAmountInput').value = grandTotal;
}

function removeItem(index) {
    if (confirm('Remove this item from the purchase order?')) {
        // Hide the row instead of removing it completely to maintain indices
        const row = document.querySelector(`input[name="items[${index}][id]"]`).closest('tr');
        row.style.display = 'none';
        
        // Set quantity to 0 so it doesn't count in total
        const quantityInput = document.querySelector(`input[name="items[${index}][quantity]"]`);
        quantityInput.value = 0;
        
        calculateGrandTotal();
    }
}

function acknowledgePO(poId) {
    if (confirm('Mark this purchase order as acknowledged by supplier?')) {
        fetch(`{{ route('procurement.po.acknowledge', ':id') }}`.replace(':id', poId), {
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

function cancelPO(poId) {
    if (confirm('Are you sure you want to cancel this purchase order? This action cannot be undone.')) {
        fetch(`{{ route('procurement.po.destroy', ':id') }}`.replace(':id', poId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("procurement.po.index") }}';
            }
        });
    }
}

// Form validation (only for editable POs)
const form = document.getElementById('purchaseOrderForm');
const poStatus = '{{ $purchaseOrder->status }}';

if (poStatus === 'draft') {
    form.addEventListener('submit', function(e) {
        // Validate that all items have quantities and prices
        let hasErrors = false;
        const quantityInputs = document.querySelectorAll('input[name^="items"][name$="[quantity]"]');
        const priceInputs = document.querySelectorAll('input[name^="items"][name$="[unit_price]"]');
        
        for (let i = 0; i < quantityInputs.length; i++) {
            const row = quantityInputs[i].closest('tr');
            if (row.style.display !== 'none') { // Only validate visible rows
                if (!quantityInputs[i].value || quantityInputs[i].value <= 0) {
                    quantityInputs[i].classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    quantityInputs[i].classList.remove('is-invalid');
                }
                
                if (!priceInputs[i].value || priceInputs[i].value < 0) {
                    priceInputs[i].classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    priceInputs[i].classList.remove('is-invalid');
                }
            }
        }
        
        if (hasErrors) {
            alert('Please fill in all item quantities and prices');
            e.preventDefault();
            return;
        }
    });
}
</script>

@endsection