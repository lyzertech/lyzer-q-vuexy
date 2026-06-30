<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementCustomer;
use App\Models\procurement\ProcurementItem;
use App\Models\User;
use App\Enums\procurement\ProcurementRequestStatus;
use App\Enums\procurement\ProcurementPriority;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helpers;

class ProcurementRequestController extends Controller
{
    public function index()
    {
        // Following your existing pattern for page config
        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-requests-page'
        ];

        return view('content.digitize.procurement.requests.index', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function data(Request $request)
    {
        // Following your DataTable pattern
        $query = ProcurementRequest::with(['salesUser', 'customer', 'items'])
                    ->select('procurement_requests.*');

        // Apply role-based filtering (following your role pattern)
        if (in_array(auth()->user()->role, [4, 5])) { // Sales roles
            $query->where('id_user_sales', auth()->id());
        }

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        return DataTables::of($query)
            ->addColumn('sales_name', function ($request) {
                return $request->salesUser->name ?? '';
            })
            ->addColumn('customer_name', function ($request) {
                return $request->customer->customer_name ?? 'Internal Request';
            })
            ->addColumn('items_count', function ($request) {
                return $request->items->count();
            })
            ->addColumn('progress', function ($request) {
                return $request->getProgressPercentage() . '%';
            })
            ->addColumn('status_badge', function ($request) {
                $status = ProcurementRequestStatus::from($request->status);
                return '<span class="badge bg-' . $status->color() . '">' . $status->label() . '</span>';
            })
            ->addColumn('priority_badge', function ($request) {
                $priority = ProcurementPriority::from($request->priority);
                return '<span class="badge bg-' . $priority->color() . '">' . $priority->label() . '</span>';
            })
            ->addColumn('actions', function ($request) {
                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>';
                $actions .= '<ul class="dropdown-menu">';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.requests.show', $request->id_procurement_request) . '">View</a></li>';
                
                if ($request->canBeEdited()) {
                    $actions .= '<li><a class="dropdown-item" href="' . route('procurement.requests.edit', $request->id_procurement_request) . '">Edit</a></li>';
                }
                
                $actions .= '</ul></div>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'priority_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $customers = ProcurementCustomer::active()->get();
        $priorities = ProcurementPriority::getSelectOptions();
        
        return view('content.digitize.procurement.requests.create', compact('customers', 'priorities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:500',
            'description' => 'nullable|string',
            'id_customer' => 'nullable|exists:procurement_customers,id_customer',
            'priority' => 'required|in:' . implode(',', array_keys(ProcurementPriority::getSelectOptions())),
            'requested_date' => 'required|date',
            'expected_date' => 'nullable|date|after_or_equal:requested_date',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.specification' => 'nullable|string',
            'items.*.requested_qty' => 'required|numeric|min:0.01',
            'items.*.unit' => 'required|string'
        ]);

        DB::transaction(function () use ($request) {
            // Create procurement request
            $procurementRequest = ProcurementRequest::create([
                'id_user_sales' => auth()->id(),
                'id_customer' => $request->id_customer,
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'requested_date' => $request->requested_date,
                'expected_date' => $request->expected_date,
                'created_by' => auth()->id(),
                'status' => ProcurementRequestStatus::DRAFT->value
            ]);

            // Create items
            foreach ($request->items as $itemData) {
                $procurementRequest->items()->create([
                    'product_name' => $itemData['product_name'],
                    'specification' => $itemData['specification'] ?? null,
                    'requested_qty' => $itemData['requested_qty'],
                    'unit' => $itemData['unit'],
                    'status' => 'requested'
                ]);
            }

            // Create initial status history
            $procurementRequest->statusHistories()->create([
                'new_status' => ProcurementRequestStatus::DRAFT->value,
                'note' => 'Request created',
                'changed_by' => auth()->id()
            ]);

            // Create initial system comment
            $procurementRequest->comments()->create([
                'id_user' => auth()->id(),
                'message' => 'Procurement request created with ' . count($request->items) . ' items.',
                'is_system' => true
            ]);
        });

        return redirect()->route('procurement.requests.index')
                        ->with('success', 'Procurement request created successfully.');
    }

    public function show(ProcurementRequest $request)
    {
        // Load relationships for timeline view
        $request->load([
            'items.arrivalHistories.createdBy',
            'comments.user',
            'comments.replies.user',
            'attachments',
            'statusHistories.changedBy',
            'purchaseOrders.supplier'
        ]);

        // Build timeline data (chronological order)
        $timeline = $this->buildTimeline($request);

        return view('content.digitize.procurement.requests.show', [
            'request' => $request,
            'timeline' => $timeline,
            'pageConfigs' => [
                'pageHeader' => true,
                'contentLayout' => "content-detached-left-sidebar"
            ]
        ]);
    }

    public function edit(ProcurementRequest $request)
    {
        if (!$request->canBeEdited()) {
            return redirect()->route('procurement.requests.show', $request)
                           ->with('error', 'This request cannot be edited.');
        }

        $customers = ProcurementCustomer::active()->get();
        $priorities = ProcurementPriority::getSelectOptions();
        
        return view('content.digitize.procurement.requests.edit', compact('request', 'customers', 'priorities'));
    }

    public function update(Request $request, ProcurementRequest $procurementRequest)
    {
        if (!$procurementRequest->canBeEdited()) {
            return redirect()->route('procurement.requests.show', $procurementRequest)
                           ->with('error', 'This request cannot be edited.');
        }

        $request->validate([
            'title' => 'required|string|max:500',
            'description' => 'nullable|string',
            'id_customer' => 'nullable|exists:procurement_customers,id_customer',
            'priority' => 'required|in:' . implode(',', array_keys(ProcurementPriority::getSelectOptions())),
            'expected_date' => 'nullable|date|after_or_equal:requested_date',
        ]);

        $procurementRequest->update([
            'title' => $request->title,
            'description' => $request->description,
            'id_customer' => $request->id_customer,
            'priority' => $request->priority,
            'expected_date' => $request->expected_date,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('procurement.requests.show', $procurementRequest)
                        ->with('success', 'Request updated successfully.');
    }

    public function destroy(ProcurementRequest $request)
    {
        if (!$request->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete completed or cancelled request']);
        }

        $request->delete();
        return redirect()->route('procurement.requests.index')
                        ->with('success', 'Request deleted successfully.');
    }

    // Following your ack_manager pattern
    public function submit(ProcurementRequest $request)
    {
        if ($request->status !== ProcurementRequestStatus::DRAFT->value) {
            return response()->json(['success' => false, 'message' => 'Request is not in draft status']);
        }

        $this->changeRequestStatus(
            $request, 
            ProcurementRequestStatus::WAITING_APPROVAL,
            'Request submitted for approval'
        );

        return response()->json(['success' => true, 'message' => 'Request submitted successfully']);
    }

    public function ack_manager(Request $request, ProcurementRequest $procurementRequest)
    {
        $request->validate([
            'approval_note' => 'required|string|max:1000'
        ]);

        $procurementRequest->ack_manager = $request->approval_note;
        $procurementRequest->save();

        $this->changeRequestStatus(
            $procurementRequest,
            ProcurementRequestStatus::APPROVED,
            'Approved by Manager: ' . $request->approval_note
        );

        return response()->json(['success' => true, 'message' => 'Request approved successfully']);
    }

    public function ack_director(Request $request, ProcurementRequest $procurementRequest)
    {
        $request->validate([
            'approval_note' => 'required|string|max:1000'
        ]);

        $procurementRequest->ack_director = $request->approval_note;
        $procurementRequest->save();

        return response()->json(['success' => true, 'message' => 'Director acknowledgment recorded']);
    }

    public function reject(Request $request, ProcurementRequest $procurementRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $this->changeRequestStatus(
            $procurementRequest,
            ProcurementRequestStatus::CANCELLED,
            'Rejected: ' . $request->rejection_reason
        );

        return response()->json(['success' => true, 'message' => 'Request rejected']);
    }

    public function confirmDelivery(Request $request, ProcurementRequest $procurementRequest)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:procurement_items,id_procurement_item',
            'items.*.delivered_qty' => 'required|numeric|min:0'
        ]);

        DB::transaction(function () use ($request, $procurementRequest) {
            foreach ($request->items as $itemData) {
                $item = $procurementRequest->items()->find($itemData['item_id']);
                
                if ($item && $item->status === 'arrival') {
                    $item->delivered_qty = $itemData['delivered_qty'];
                    $item->status = 'delivered';
                    $item->save();

                    // Create status history
                    $item->statusHistories()->create([
                        'id_procurement_request' => $procurementRequest->id_procurement_request,
                        'old_status' => 'arrival',
                        'new_status' => 'delivered',
                        'note' => "Delivered quantity: {$itemData['delivered_qty']}",
                        'changed_by' => auth()->id()
                    ]);
                }
            }

            // Update request status if all items delivered
            if ($procurementRequest->isAllItemsDelivered()) {
                $this->changeRequestStatus($procurementRequest, ProcurementRequestStatus::COMPLETED, 'All items delivered');
            }
        });

        return response()->json(['success' => true, 'message' => 'Delivery confirmed successfully']);
    }

    private function changeRequestStatus(ProcurementRequest $request, ProcurementRequestStatus $newStatus, string $note = null): void
    {
        $oldStatus = ProcurementRequestStatus::from($request->status);
        
        if (!$oldStatus->canTransitionTo($newStatus)) {
            throw new \InvalidArgumentException("Cannot transition from {$oldStatus->value} to {$newStatus->value}");
        }

        $request->status = $newStatus->value;
        
        if ($newStatus === ProcurementRequestStatus::COMPLETED) {
            $request->completed_at = now();
        }
        
        $request->save();

        // Create status history
        $request->statusHistories()->create([
            'old_status' => $oldStatus->value,
            'new_status' => $newStatus->value,
            'note' => $note,
            'changed_by' => auth()->id(),
        ]);

        // Create system comment
        $request->comments()->create([
            'id_user' => auth()->id(),
            'message' => "Status changed from {$oldStatus->label()} to {$newStatus->label()}" . 
                        ($note ? " - {$note}" : ""),
            'is_system' => true,
        ]);
    }

    private function buildTimeline(ProcurementRequest $request): array
    {
        $timeline = [];

        // Add comments
        foreach ($request->comments as $comment) {
            $timeline[] = [
                'type' => $comment->is_system ? 'system_comment' : 'comment',
                'timestamp' => $comment->created_at,
                'data' => $comment,
                'sort_key' => $comment->created_at->timestamp
            ];
        }

        // Add status histories
        foreach ($request->statusHistories as $history) {
            $timeline[] = [
                'type' => 'status_change',
                'timestamp' => $history->created_at,
                'data' => $history,
                'sort_key' => $history->created_at->timestamp
            ];
        }

        // Add arrival histories
        foreach ($request->items as $item) {
            foreach ($item->arrivalHistories as $arrival) {
                $timeline[] = [
                    'type' => 'arrival',
                    'timestamp' => $arrival->created_at,
                    'data' => $arrival,
                    'sort_key' => $arrival->created_at->timestamp
                ];
            }
        }

        // Sort chronologically
        usort($timeline, function ($a, $b) {
            return $a['sort_key'] <=> $b['sort_key'];
        });

        return $timeline;
    }
}