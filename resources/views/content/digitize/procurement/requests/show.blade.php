@extends('layouts/layoutMaster')

@section('title', 'Procurement Request - ' . $request->request_number)

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/dropzone/dropzone.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/dropzone/dropzone.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js'])
@endsection


@section('content')

@php
    use App\Enums\procurement\ProcurementRequestStatus;
    use App\Enums\procurement\ProcurementPriority;
@endphp

<div class="row">
    <!-- Request Details Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- Request Card -->
        <div class="card mb-6">
            <div class="card-body">
                <!-- Status Badge -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="badge bg-{{ ProcurementRequestStatus::from($request->status)->color() }} fs-6">
                        {{ ProcurementRequestStatus::from($request->status)->label() }}
                    </span>
                    @if(!$request->isReadOnly())
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                @if($request->status === 'draft' && auth()->user()->id === $request->id_user_sales)
                                    <li><a class="dropdown-item" href="#" onclick="submitRequest()">Submit for Approval</a></li>
                                    <li><a class="dropdown-item" href="{{ route('procurement.requests.edit', $request) }}">Edit Request</a></li>
                                @endif
                                
                                @if($request->status === 'waiting_approval' && in_array(auth()->user()->role, [1, 2]))
                                    <li><a class="dropdown-item" href="#" onclick="showApprovalModal()">Approve</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="showRejectionModal()">Reject</a></li>
                                @endif
                                
                                @if($request->status === 'arrival' && auth()->user()->id === $request->id_user_sales)
                                    <li><a class="dropdown-item" href="#" onclick="showDeliveryModal()">Confirm Delivery</a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="exportToPdf()">Export PDF</a></li>
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Request Info -->
                <div class="mb-4">
                    <h4 class="card-title mb-2">{{ $request->title }}</h4>
                    <small class="text-muted">{{ $request->request_number }}</small>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-muted">Sales Person</small>
                        <div class="fw-medium">{{ $request->salesUser->name }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Customer</small>
                        <div class="fw-medium">{{ $request->customer->customer_name ?? 'Internal Request' }}</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-muted">Priority</small>
                        <div>
                            <span class="badge bg-{{ ProcurementPriority::from($request->priority)->color() }}">
                                {{ ProcurementPriority::from($request->priority)->label() }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Created</small>
                        <div class="fw-medium">{{ $request->created_at->format('M d, Y') }}</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-muted">Requested Date</small>
                        <div class="fw-medium">{{ $request->requested_date->format('M d, Y') }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Expected Date</small>
                        <div class="fw-medium">{{ $request->expected_date?->format('M d, Y') ?? 'TBD' }}</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">Overall Progress</small>
                        <small class="text-muted">{{ $request->getProgressPercentage() }}%</small>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $request->getProgressPercentage() }}%"></div>
                    </div>
                </div>

                @if($request->description)
                <div class="mb-4">
                    <small class="text-muted">Description</small>
                    <p class="mt-1">{{ $request->description }}</p>
                </div>
                @endif

                <!-- Workflow Approvals -->
                @if($request->ack_manager || $request->ack_director)
                <div class="mb-4">
                    <small class="text-muted">Approvals</small>
                    <div class="mt-1">
                        @if($request->ack_manager)
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            <span class="fw-medium">Manager:</span>
                            <span class="ms-2">{{ $request->ack_manager }}</span>
                        </div>
                        @endif
                        @if($request->ack_director)
                        <div class="d-flex align-items-center">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            <span class="fw-medium">Director:</span>
                            <span class="ms-2">{{ $request->ack_director }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Items Card -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Items ({{ $request->items->count() }})</h5>
                @if(!$request->isReadOnly() && $request->status === 'draft')
                <button class="btn btn-sm btn-primary" onclick="showAddItemModal()">
                    <i class="bx bx-plus"></i> Add Item
                </button>
                @endif
            </div>
            <div class="card-body p-0">
                @forelse($request->items as $item)
                <div class="d-flex align-items-center p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item->product_name }}</h6>
                        <div class="d-flex align-items-center text-muted mb-1">
                            <small>{{ number_format($item->requested_qty, 2) }} {{ $item->unit }}</small>
                            @if($item->arrived_qty > 0)
                                <span class="mx-1">•</span>
                                <small>Arrived: {{ number_format($item->arrived_qty, 2) }}</small>
                            @endif
                            @if($item->delivered_qty > 0)
                                <span class="mx-1">•</span>
                                <small>Delivered: {{ number_format($item->delivered_qty, 2) }}</small>
                            @endif
                        </div>
                        @if($item->specification)
                        <small class="text-muted">{{ Str::limit($item->specification, 50) }}</small>
                        @endif
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ \App\Enums\procurement\ProcurementItemStatus::from($item->status)->color() }} mb-2">
                            {{ \App\Enums\procurement\ProcurementItemStatus::from($item->status)->label() }}
                        </span>
                        <div>
                            @if($item->requested_qty > 0)
                            <div class="progress" style="width: 80px; height: 6px;">
                                <div class="progress-bar" style="width: {{ $item->getCompletionPercentageAttribute() }}%"></div>
                            </div>
                            <small class="text-muted">{{ number_format($item->getCompletionPercentageAttribute(), 0) }}%</small>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center p-4">
                    <i class="bx bx-package fs-1 text-muted"></i>
                    <p class="text-muted mt-2">No items added yet</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Purchase Orders Card -->
        @if($request->purchaseOrders->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Purchase Orders</h5>
            </div>
            <div class="card-body p-0">
                @foreach($request->purchaseOrders as $po)
                <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $po->po_number }}</h6>
                        <small class="text-muted">{{ $po->supplier->supplier_name }}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ \App\Enums\procurement\PurchaseOrderStatus::from($po->status)->color() }}">
                            {{ \App\Enums\procurement\PurchaseOrderStatus::from($po->status)->label() }}
                        </span>
                        <div class="mt-1">
                            <small class="text-muted">${{ number_format($po->total_amount, 2) }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Timeline Content -->
    <div class="col-xl-8 col-lg-7 col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Activity Timeline</h5>
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="refreshTimeline()">
                        <i class="bx bx-refresh"></i>
                    </button>
                    @if(!$request->isReadOnly())
                    <button class="btn btn-sm btn-outline-primary" onclick="showAttachmentModal()">
                        <i class="bx bx-paperclip"></i> Attach Files
                    </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(!$request->isReadOnly())
                <!-- Comment Form -->
                <div class="row mb-4">
                    <div class="col-12">
                        <form id="comment-form" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <textarea class="form-control" name="message" rows="3" placeholder="Add a comment..." required></textarea>
                                        <label>Add a comment...</label>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <input type="file" name="attachments[]" id="comment-files" multiple class="d-none" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('comment-files').click()">
                                                <i class="bx bx-paperclip"></i> Attach Files
                                            </button>
                                            <span id="selected-files" class="text-muted ms-2"></span>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="timeline timeline-center" id="activity-timeline">
                    @foreach($timeline as $entry)
                        @if($entry['type'] === 'comment' && !$entry['data']->is_system)
                            @include('content.digitize.procurement.components.timeline.comment', ['comment' => $entry['data']])
                        @elseif($entry['type'] === 'system_comment' || ($entry['type'] === 'comment' && $entry['data']->is_system))
                            @include('content.digitize.procurement.components.timeline.system-comment', ['comment' => $entry['data']])
                        @elseif($entry['type'] === 'status_change')
                            @include('content.digitize.procurement.components.timeline.status-change', ['history' => $entry['data']])
                        @elseif($entry['type'] === 'arrival')
                            @include('content.digitize.procurement.components.timeline.arrival', ['arrival' => $entry['data']])
                        @endif
                    @endforeach

                    @if(empty($timeline))
                    <div class="text-center py-4">
                        <i class="bx bx-time-five fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No activity yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Approve Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approvalForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label">Approval Note</label>
                        <textarea name="approval_note" class="form-control" rows="3" required placeholder="Enter approval note..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addItemForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="product_name" class="form-control" required>
                                <label>Product Name</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="unit" class="form-control" required>
                                <label>Unit</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" name="requested_qty" class="form-control" step="0.01" min="0.01" required>
                            <label>Requested Quantity</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea name="specification" class="form-control" rows="3"></textarea>
                            <label>Specification (Optional)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Global configuration
window.requestConfig = {
    id: {{ $request->id_procurement_request }},
    status: '{{ $request->status }}',
    canEdit: {{ $request->canBeEdited() ? 'true' : 'false' }},
    isReadOnly: {{ $request->isReadOnly() ? 'true' : 'false' }},
    userId: {{ auth()->id() }},
    userRole: {{ auth()->user()->role }},
    routes: {
        comments: '{{ route("procurement.comments.store", $request) }}',
        approval: '{{ route("procurement.requests.ack_manager", $request) }}',
        addItem: '{{ route("procurement.items.store", $request) }}',
        timeline: '{{ route("procurement.comments.index", $request) }}'
    }
};
</script>

@endsection