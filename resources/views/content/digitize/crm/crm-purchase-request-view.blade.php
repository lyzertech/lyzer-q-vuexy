@extends('layouts/layoutMaster')

@section('title', 'Purchase Request Detail')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Purchase Request Detail</h5>
                    <a href="{{ route('crm-purchase-request') }}" class="btn btn-label-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Common Information --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="40%">Customer Name</th>
                                        <td>{{ $purchase_request->customer_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer PO Number</th>
                                        <td>{{ $purchase_request->customer_po_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Project Name</th>
                                        <td>{{ $purchase_request->project_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Term of Payment (TOP)</th>
                                        <td>{{ $purchase_request->term_of_payment ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="40%">Down Payment (DP)</th>
                                        <td>
                                            @if($purchase_request->down_payment === 'ON')
                                                <span class="badge bg-label-success">ON</span>
                                            @else
                                                <span class="badge bg-label-secondary">OFF</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'PR Created' => 'bg-label-info',
                                                    'Waiting Director Approval' => 'bg-label-warning',
                                                    'Approved' => 'bg-label-success',
                                                    'Rejected' => 'bg-label-danger',
                                                    'DP Received' => 'bg-label-primary',
                                                    'Delay' => 'bg-label-danger',
                                                    'Arrived' => 'bg-label-info',
                                                    'Delivered to Customer' => 'bg-label-success',
                                                    'Complete' => 'bg-label-dark',
                                                ];
                                                $statusCls = $statusMap[$purchase_request->status] ?? 'bg-label-secondary';
                                            @endphp
                                            <span class="badge {{ $statusCls }}">{{ $purchase_request->status ?? '-' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Notes</th>
                                        <td>{{ $purchase_request->notes ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $purchase_request->created_at ? $purchase_request->created_at->format('Y-m-d H:i') : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- DP Received Date Form --}}
                    @if($purchase_request->down_payment === 'ON')
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">DP Received Date</h6>
                                    <form method="POST" action="{{ route('crm-purchase-request-update-dp-date', $purchase_request->id_purchase_request) }}">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <label class="form-label" for="dp-received-date">Date DP Received</label>
                                                <input type="date" class="form-control" id="dp-received-date" name="dp_received_date" 
                                                    value="{{ $purchase_request->dp_received_date ?? '' }}" 
                                                    {{ $purchase_request->dp_received_date ? 'disabled' : 'required' }}>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary" {{ $purchase_request->dp_received_date ? 'disabled' : '' }}>
                                                    <i class="ti ti-check me-1"></i>{{ $purchase_request->dp_received_date ? 'DP Date Set' : 'Update DP Date' }}
                                                </button>
                                            </div>
                                            @if($purchase_request->dp_received_date)
                                            <div class="col-md-5">
                                                <small class="text-success">
                                                    <i class="ti ti-circle-check me-1"></i>
                                                    DP Date Recorded: <strong>{{ \Carbon\Carbon::parse($purchase_request->dp_received_date)->format('d M Y') }}</strong>
                                                </small>
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Status Update --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Update Status</h6>
                                    <form method="POST" action="{{ route('crm-purchase-request-update-status', $purchase_request->id_purchase_request) }}">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-6">
                                                <label class="form-label" for="status-select">Select Status</label>
                                                <select class="form-control" id="status-select" name="status" required>
                                                    <option value="">-- Choose Status --</option>
                                                    <option value="PR Created" {{ $purchase_request->status == 'PR Created' ? 'selected' : '' }}>PR Created</option>
                                                    <option value="Waiting Director Approval" {{ $purchase_request->status == 'Waiting Director Approval' ? 'selected' : '' }}>Waiting Director Approval</option>
                                                    <option value="Approved" {{ $purchase_request->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="DP Received" {{ $purchase_request->status == 'DP Received' ? 'selected' : '' }}>DP Received</option>
                                                    <option value="Delay" {{ $purchase_request->status == 'Delay' ? 'selected' : '' }}>Delay</option>
                                                    <option value="Arrived" {{ $purchase_request->status == 'Arrived' ? 'selected' : '' }}>Arrived</option>
                                                    <option value="Delivered to Customer" {{ $purchase_request->status == 'Delivered to Customer' ? 'selected' : '' }}>Delivered to Customer</option>
                                                    <option value="Complete" {{ $purchase_request->status == 'Complete' ? 'selected' : '' }}>Complete</option>
                                                    <option value="Rejected" {{ $purchase_request->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="ti ti-check me-1"></i>Update Status
                                                </button>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted">
                                                    Current: <strong class="badge {{ $statusCls }}">{{ $purchase_request->status }}</strong>
                                                </small>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Items Table --}}
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3">Items</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>PR Number</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Selling Price</th>
                                            <th>Lead Time</th>
                                            <th>Expected Delivery</th>
                                            <th>Principal Delivery Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($related_prs as $pr)
                                        <tr>
                                            <td>{{ $pr->pr_number }}</td>
                                            <td>{{ $pr->item_list }}</td>
                                            <td>{{ $pr->quantity }}</td>
                                            <td>{{ number_format($pr->selling_price, 0, ',', ' ') }}</td>
                                            <td>{{ $pr->lead_time }}</td>
                                            <td>
                                                @if($pr->expected_delivery_date !== '-')
                                                    <span class="badge bg-label-success">{{ $pr->expected_delivery_date }}</span>
                                                @else
                                                    <span class="badge bg-label-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('crm-purchase-request-update-principal-delivery', $pr->id_purchase_request) }}" class="d-flex gap-2 align-items-center">
                                                    @csrf
                                                    <input type="date" 
                                                        class="form-control form-control-sm" 
                                                        name="principal_delivery_date" 
                                                        value="{{ $pr->principal_delivery_date ?? '' }}"
                                                        {{ $pr->principal_delivery_date ? 'disabled' : 'required' }}
                                                        style="max-width: 150px;">
                                                    <button type="submit" 
                                                        class="btn btn-sm btn-primary" 
                                                        {{ $pr->principal_delivery_date ? 'disabled' : '' }}>
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                    @if($pr->principal_delivery_date)
                                                    <small class="text-success">
                                                        <i class="ti ti-circle-check"></i>
                                                    </small>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
