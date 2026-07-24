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
                                            @if ($purchase_request->down_payment === 'ON')
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
                                                    // Purchasing
                                                    'PR Created' => 'bg-label-info',
                                                    'Waiting Director Approval' => 'bg-label-warning',
                                                    'Approved' => 'bg-label-success',
                                                    'Rejected' => 'bg-label-danger',
                                                    'DP Received' => 'bg-label-primary',

                                                    // Principal / Supplier
                                                    'Supplier Production' => 'bg-label-info',
                                                    'Delay Production' => 'bg-label-danger',
                                                    'Supplier Inform Goods Ready for Pick Up' => 'bg-label-success',

                                                    // Shipment
                                                    'Pick Up Arrangement' => 'bg-label-warning',
                                                    'In Transit' => 'bg-label-primary',
                                                    'Delay Shipment' => 'bg-label-danger',
                                                    'Shipment Delivery' => 'bg-label-primary',

                                                    // Customs
                                                    'Customs Clearance' => 'bg-label-warning',
                                                    'PIB Draft' => 'bg-label-info',
                                                    'ID Billing Request' => 'bg-label-info',
                                                    'Payment to Kas Negara' => 'bg-label-warning',
                                                    'Custom Response (Red/Green/Yellow)' => 'bg-label-warning',
                                                    'Shipment Release' => 'bg-label-success',

                                                    // Internal
                                                    'Warehouse Received' => 'bg-label-info',
                                                    'Lab Check' => 'bg-label-warning',
                                                    'Dispatch to End Customer/Buyer' => 'bg-label-primary',

                                                    // Customer
                                                    'Delivered' => 'bg-label-success',

                                                    // Final Status
                                                    'Complete' => 'bg-label-dark',
                                                ];
                                                $statusCls =
                                                    $statusMap[$purchase_request->status] ?? 'bg-label-secondary';
                                            @endphp
                                            <span
                                                class="badge {{ $statusCls }}">{{ $purchase_request->status ?? '-' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Notes</th>
                                        <td>{{ $purchase_request->notes ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $purchase_request->created_at ? $purchase_request->created_at->format('Y-m-d H:i') : '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- DP Received Date Form --}}
                    @if ($purchase_request->down_payment === 'ON')
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="mb-3">DP Received Date</h6>
                                        <form method="POST"
                                            action="{{ route('crm-purchase-request-update-dp-date', $purchase_request->id_purchase_request) }}">
                                            @csrf
                                            <div class="row align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="dp-received-date">Date DP
                                                        Received</label>
                                                    <input type="date" class="form-control" id="dp-received-date"
                                                        name="dp_received_date"
                                                        value="{{ $purchase_request->dp_received_date ?? '' }}"
                                                        {{ $purchase_request->dp_received_date || !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : 'required' }}>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary"
                                                        {{ $purchase_request->dp_received_date || !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : '' }}>
                                                        <i
                                                            class="ti ti-check me-1"></i>{{ $purchase_request->dp_received_date ? 'DP Date Set' : 'Update DP Date' }}
                                                    </button>
                                                </div>
                                                @if ($purchase_request->dp_received_date)
                                                    <div class="col-md-5">
                                                        <small class="text-success">
                                                            <i class="ti ti-circle-check me-1"></i>
                                                            DP Date Recorded:
                                                            <strong>{{ \Carbon\Carbon::parse($purchase_request->dp_received_date)->format('d M Y') }}</strong>
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

                    {{-- Principal PO Number Form --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Principal PO Number</h6>
                                    <form method="POST"
                                        action="{{ route('crm-purchase-request-update-principal-po', $purchase_request->id_purchase_request) }}">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <label class="form-label" for="principal-po-number">Principal PO
                                                    Number</label>
                                                <input type="text" class="form-control" id="principal-po-number"
                                                    name="principal_po_number"
                                                    value="{{ $purchase_request->principal_po_number ?? '' }}"
                                                    placeholder="Enter Principal PO Number"
                                                    {{ $purchase_request->principal_po_number ? 'disabled' : (auth()->user()->name === 'Elka' && auth()->user()->role_id == 8 ? 'required' : 'disabled') }}>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary"
                                                    {{ $purchase_request->principal_po_number || !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : '' }}>
                                                    <i
                                                        class="ti ti-check me-1"></i>{{ $purchase_request->principal_po_number ? 'PO Number Set' : 'Update PO Number' }}
                                                </button>
                                            </div>
                                            @if ($purchase_request->principal_po_number)
                                                <div class="col-md-5">
                                                    <small class="text-success">
                                                        <i class="ti ti-circle-check me-1"></i>
                                                        Principal PO Number Recorded:
                                                        <strong>{{ $purchase_request->principal_po_number }}</strong>
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Update --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Update Status</h6>
                                    <form method="POST"
                                        action="{{ route('crm-purchase-request-update-status', $purchase_request->id_purchase_request) }}">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-6">
                                                <label class="form-label" for="status-select">Select Status</label>
                                                <select class="form-control" id="status-select" name="status" required {{ !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : '' }}>
                                                    <option value="">-- Choose Status --</option>
                                                    <!-- Purchasing -->
                                                    <optgroup label="Purchasing">
                                                        <option value="PR Created"
                                                            {{ $purchase_request->status == 'PR Created' ? 'selected' : '' }}>
                                                            PR Created
                                                        </option>

                                                        <option value="DP Received"
                                                            {{ $purchase_request->status == 'DP Received' ? 'selected' : '' }}>
                                                            DP Received
                                                        </option>
                                                    </optgroup>


                                                    <!-- Principal / Supplier -->
                                                    <optgroup label="Principal / Supplier">
                                                        <option value="Supplier Production"
                                                            {{ $purchase_request->status == 'Supplier Production' ? 'selected' : '' }}>
                                                            Supplier Production
                                                        </option>

                                                        <option value="Delay Production"
                                                            {{ $purchase_request->status == 'Delay Production' ? 'selected' : '' }}>
                                                            Delay Production
                                                        </option>

                                                        <option value="Supplier Inform Goods Ready for Pick Up"
                                                            {{ $purchase_request->status == 'Supplier Inform Goods Ready for Pick Up' ? 'selected' : '' }}>
                                                            Supplier Inform Goods Ready for Pick Up
                                                        </option>
                                                    </optgroup>


                                                    <!-- Shipment -->
                                                    <optgroup label="Shipment">
                                                        <option value="Pick Up Arrangement"
                                                            {{ $purchase_request->status == 'Pick Up Arrangement' ? 'selected' : '' }}>
                                                            Pick Up Arrangement
                                                        </option>

                                                        <option value="In Transit"
                                                            {{ $purchase_request->status == 'In Transit' ? 'selected' : '' }}>
                                                            In Transit
                                                        </option>

                                                        <option value="Delay Shipment"
                                                            {{ $purchase_request->status == 'Delay Shipment' ? 'selected' : '' }}>
                                                            Delay Shipment
                                                        </option>

                                                        <option value="Shipment Delivery"
                                                            {{ $purchase_request->status == 'Shipment Delivery' ? 'selected' : '' }}>
                                                            Shipment Delivery
                                                        </option>
                                                    </optgroup>


                                                    <!-- Customs -->
                                                    <optgroup label="Customs">
                                                        <option value="Customs Clearance"
                                                            {{ $purchase_request->status == 'Customs Clearance' ? 'selected' : '' }}>
                                                            Customs Clearance
                                                        </option>

                                                        <option value="PIB Draft"
                                                            {{ $purchase_request->status == 'PIB Draft' ? 'selected' : '' }}>
                                                            PIB Draft
                                                        </option>

                                                        <option value="ID Billing Request"
                                                            {{ $purchase_request->status == 'ID Billing Request' ? 'selected' : '' }}>
                                                            ID Billing Request
                                                        </option>

                                                        <option value="Payment to Kas Negara"
                                                            {{ $purchase_request->status == 'Payment to Kas Negara' ? 'selected' : '' }}>
                                                            Payment to Kas Negara
                                                        </option>

                                                        <option value="Custom Response (Red/Green/Yellow)"
                                                            {{ $purchase_request->status == 'Custom Response (Red/Green/Yellow)' ? 'selected' : '' }}>
                                                            Custom Response (Red/Green/Yellow)
                                                        </option>

                                                        <option value="Shipment Release"
                                                            {{ $purchase_request->status == 'Shipment Release' ? 'selected' : '' }}>
                                                            Shipment Release
                                                        </option>
                                                    </optgroup>


                                                    <!-- Internal -->
                                                    <optgroup label="Internal">
                                                        <option value="Warehouse Received"
                                                            {{ $purchase_request->status == 'Warehouse Received' ? 'selected' : '' }}>
                                                            Warehouse Received
                                                        </option>

                                                        <option value="Lab Check"
                                                            {{ $purchase_request->status == 'Lab Check' ? 'selected' : '' }}>
                                                            Lab Check
                                                        </option>

                                                        <option value="Dispatch to End Customer/Buyer"
                                                            {{ $purchase_request->status == 'Dispatch to End Customer/Buyer' ? 'selected' : '' }}>
                                                            Dispatch to End Customer/Buyer
                                                        </option>
                                                    </optgroup>


                                                    <!-- Customer -->
                                                    <optgroup label="Customer">
                                                        <option value="Delivered"
                                                            {{ $purchase_request->status == 'Delivered' ? 'selected' : '' }}>
                                                            Delivered
                                                        </option>
                                                    </optgroup>


                                                    <!-- Final Status -->
                                                    <optgroup label="Final Status">
                                                        <option value="Complete"
                                                            {{ $purchase_request->status == 'Complete' ? 'selected' : '' }}>
                                                            Complete
                                                        </option>

                                                        <option value="Rejected"
                                                            {{ $purchase_request->status == 'Rejected' ? 'selected' : '' }}>
                                                            Rejected
                                                        </option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary" {{ !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : '' }}>
                                                    <i class="ti ti-check me-1"></i>Update Status
                                                </button>
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
                                            <th>Brand</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Selling Price</th>
                                            <th>Lead Time</th>
                                            <th>Expected Delivery</th>
                                            <th>Principal Delivery Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($related_prs as $pr)
                                            <tr>
                                                <td>{{ $pr->pr_number }}</td>
                                                <td>{{ $pr->brand ?? '-' }}</td>
                                                <td>{{ $pr->item_list }}</td>
                                                <td>{{ $pr->quantity }}</td>
                                                <td>{{ number_format($pr->selling_price, 0, ',', ' ') }}</td>
                                                <td>{{ $pr->lead_time }}</td>
                                                <td>
                                                    @if ($pr->expected_delivery_date !== '-')
                                                        <span
                                                            class="badge bg-label-success">{{ $pr->expected_delivery_date }}</span>
                                                    @else
                                                        <span class="badge bg-label-secondary">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('crm-purchase-request-update-principal-delivery', $pr->id_purchase_request) }}"
                                                        class="d-flex gap-2 align-items-center">
                                                        @csrf
                                                        <input type="date" class="form-control form-control-sm"
                                                            name="principal_delivery_date"
                                                            value="{{ $pr->principal_delivery_date ?? '' }}"
                                                            {{ !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : 'required' }}
                                                            style="max-width: 150px;">
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            {{ !(auth()->user()->name === 'Elka' && auth()->user()->role_id == 8) ? 'disabled' : '' }}>
                                                            <i class="ti ti-check"></i>
                                                        </button>
                                                        @if ($pr->principal_delivery_date)
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

    {{-- Status History Section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Status History</h5>
                </div>
                <div class="card-body">
                    @php
                        $statusHistories = \App\Models\StatusHistory::where('reference_type', get_class($purchase_request))
                            ->where('reference_id', $purchase_request->id_purchase_request)
                            ->with('user', 'comment')
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp

                    @if($statusHistories->isEmpty())
                        <p class="text-muted">No status history available.</p>
                    @else
                        <div class="timeline">
                            @foreach($statusHistories as $history)
                                <div class="timeline-item mb-3">
                                    <div class="d-flex gap-3">
                                        <div class="avatar avatar-sm flex-shrink-0">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                <i class="ti ti-user"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div>
                                                    <h6 class="mb-0">{{ $history->user->name ?? 'Unknown' }}</h6>
                                                    <small class="text-muted">{{ $history->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <span class="text-muted">Changed status from </span>
                                                @if($history->from_status)
                                                    <span class="badge bg-label-secondary">{{ $history->from_status }}</span>
                                                @else
                                                    <span class="badge bg-label-secondary">-</span>
                                                @endif
                                                <span class="text-muted"> to </span>
                                                <span class="badge bg-label-primary">{{ $history->to_status }}</span>
                                            </div>
                                            @if($history->comment)
                                                <div class="alert alert-secondary p-2 mb-0">
                                                    <small>{{ $history->comment->content }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Comments / Discussion Section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Discussion / Comments</h5>
                </div>
                <div class="card-body">
                    {{-- Add Comment Form --}}
                    <form method="POST" action="{{ route('crm-purchase-request-add-comment', $purchase_request->id_purchase_request) }}" class="mb-4">
                        @csrf
                        <div class="d-flex gap-3">
                            <div class="avatar avatar-sm flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="ti ti-user"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <textarea name="content" class="form-control" rows="3" placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="ti ti-send me-1"></i>Send
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Comments List --}}
                    <div id="comments-list">
                        @php
                            $comments = \App\Models\Comment::where('commentable_type', get_class($purchase_request))
                                ->where('commentable_id', $purchase_request->id_purchase_request)
                                ->whereNull('parent_id')
                                ->with(['user', 'replies.user', 'replies.replies'])
                                ->orderBy('created_at', 'desc')
                                ->get();
                        @endphp

                        @if($comments->isEmpty())
                            <p class="text-muted">No comments yet. Be the first to comment!</p>
                        @else
                            @foreach($comments as $comment)
                                @include('content.digitize.crm.partials.comment-item', ['comment' => $comment, 'level' => 0])
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for Reply Functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle reply button click
            document.querySelectorAll('.reply-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.getElementById('reply-form-' + commentId);

                    // Hide all other reply forms
                    document.querySelectorAll('.reply-form').forEach(function(form) {
                        if (form.id !== 'reply-form-' + commentId) {
                            form.style.display = 'none';
                        }
                    });

                    // Toggle current reply form
                    if (replyForm.style.display === 'none') {
                        replyForm.style.display = 'block';
                        replyForm.querySelector('textarea').focus();
                    } else {
                        replyForm.style.display = 'none';
                    }
                });
            });

            // Handle cancel reply button
            document.querySelectorAll('.cancel-reply').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.getElementById('reply-form-' + commentId);
                    replyForm.style.display = 'none';
                    replyForm.querySelector('textarea').value = '';
                });
            });
        });
    </script>

@endsection
