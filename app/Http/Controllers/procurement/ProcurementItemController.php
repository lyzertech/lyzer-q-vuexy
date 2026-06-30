<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementItem;
use App\Models\procurement\ProcurementProduct;
use App\Enums\procurement\ProcurementItemStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementItemController extends Controller
{
    public function index(ProcurementRequest $request)
    {
        $items = $request->items()->with(['product', 'arrivalHistories'])->get();
        
        return view('content.digitize.procurement.items.index', compact('request', 'items'));
    }

    public function store(Request $request, ProcurementRequest $procurementRequest)
    {
        if (!$procurementRequest->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'Cannot add items to this request']);
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'specification' => 'nullable|string',
            'requested_qty' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:50',
            'id_product' => 'nullable|exists:procurement_products,id_product'
        ]);

        $item = $procurementRequest->items()->create([
            'id_product' => $request->id_product,
            'product_name' => $request->product_name,
            'specification' => $request->specification,
            'requested_qty' => $request->requested_qty,
            'unit' => $request->unit,
            'status' => ProcurementItemStatus::REQUESTED->value
        ]);

        // Create status history for the new item
        $item->statusHistories()->create([
            'id_procurement_request' => $procurementRequest->id_procurement_request,
            'new_status' => ProcurementItemStatus::REQUESTED->value,
            'note' => 'Item added to request',
            'changed_by' => auth()->id()
        ]);

        // Create system comment
        $procurementRequest->comments()->create([
            'id_user' => auth()->id(),
            'message' => "New item added: {$request->product_name} ({$request->requested_qty} {$request->unit})",
            'is_system' => true
        ]);

        return response()->json(['success' => true, 'message' => 'Item added successfully']);
    }

    public function show(ProcurementRequest $request, ProcurementItem $item)
    {
        if ($item->id_procurement_request !== $request->id_procurement_request) {
            abort(404);
        }

        $item->load(['product', 'arrivalHistories.createdBy', 'statusHistories.changedBy']);
        
        return view('content.digitize.procurement.items.show', compact('request', 'item'));
    }

    public function update(Request $request, ProcurementRequest $procurementRequest, ProcurementItem $item)
    {
        if (!$procurementRequest->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'Cannot edit items in this request']);
        }

        if ($item->id_procurement_request !== $procurementRequest->id_procurement_request) {
            abort(404);
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'specification' => 'nullable|string',
            'requested_qty' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:50',
            'remarks' => 'nullable|string'
        ]);

        $oldData = [
            'product_name' => $item->product_name,
            'requested_qty' => $item->requested_qty,
            'unit' => $item->unit
        ];

        $item->update([
            'product_name' => $request->product_name,
            'specification' => $request->specification,
            'requested_qty' => $request->requested_qty,
            'unit' => $request->unit,
            'remarks' => $request->remarks
        ]);

        // Create system comment about the change
        $changes = [];
        if ($oldData['product_name'] !== $request->product_name) {
            $changes[] = "Product name: {$oldData['product_name']} → {$request->product_name}";
        }
        if ($oldData['requested_qty'] != $request->requested_qty) {
            $changes[] = "Quantity: {$oldData['requested_qty']} → {$request->requested_qty}";
        }
        if ($oldData['unit'] !== $request->unit) {
            $changes[] = "Unit: {$oldData['unit']} → {$request->unit}";
        }

        if (!empty($changes)) {
            $procurementRequest->comments()->create([
                'id_user' => auth()->id(),
                'message' => "Item updated: " . implode(', ', $changes),
                'is_system' => true
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Item updated successfully']);
    }

    public function destroy(ProcurementRequest $request, ProcurementItem $item)
    {
        if (!$request->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete items from this request']);
        }

        if ($item->id_procurement_request !== $request->id_procurement_request) {
            abort(404);
        }

        // Check if item has arrivals
        if ($item->arrivalHistories()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete item that has arrival history']);
        }

        $productName = $item->product_name;
        $item->delete();

        // Create system comment
        $request->comments()->create([
            'id_user' => auth()->id(),
            'message' => "Item removed: {$productName}",
            'is_system' => true
        ]);

        return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
    }

    // Status change methods for purchasing team
    public function markAsOrdered(Request $request, ProcurementRequest $procurementRequest, ProcurementItem $item)
    {
        return $this->changeItemStatus($item, ProcurementItemStatus::ORDERED, 'Item marked as ordered');
    }

    public function markAsProduction(Request $request, ProcurementRequest $procurementRequest, ProcurementItem $item)
    {
        return $this->changeItemStatus($item, ProcurementItemStatus::PRODUCTION, 'Item is now in production');
    }

    public function markAsShipping(Request $request, ProcurementRequest $procurementRequest, ProcurementItem $item)
    {
        return $this->changeItemStatus($item, ProcurementItemStatus::SHIPPING, 'Item is now shipping');
    }

    public function cancel(Request $request, ProcurementRequest $procurementRequest, ProcurementItem $item)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        return $this->changeItemStatus(
            $item, 
            ProcurementItemStatus::CANCELLED, 
            'Item cancelled: ' . $request->cancellation_reason
        );
    }

    private function changeItemStatus(ProcurementItem $item, ProcurementItemStatus $newStatus, string $note = null): \Illuminate\Http\JsonResponse
    {
        $currentStatus = ProcurementItemStatus::from($item->status);
        
        if (!$currentStatus->canTransitionTo($newStatus)) {
            return response()->json([
                'success' => false, 
                'message' => "Cannot change from {$currentStatus->label()} to {$newStatus->label()}"
            ]);
        }

        DB::transaction(function () use ($item, $currentStatus, $newStatus, $note) {
            // Update item status
            $item->status = $newStatus->value;
            $item->save();

            // Create status history
            $item->statusHistories()->create([
                'id_procurement_request' => $item->id_procurement_request,
                'old_status' => $currentStatus->value,
                'new_status' => $newStatus->value,
                'note' => $note,
                'changed_by' => auth()->id()
            ]);

            // Create system comment
            $item->request->comments()->create([
                'id_user' => auth()->id(),
                'message' => "{$item->product_name}: Status changed from {$currentStatus->label()} to {$newStatus->label()}" . 
                           ($note ? " - {$note}" : ""),
                'is_system' => true
            ]);

            // Update request status if needed
            $this->updateRequestStatusBasedOnItems($item->request);
        });

        return response()->json([
            'success' => true, 
            'message' => "Item status changed to {$newStatus->label()}"
        ]);
    }

    private function updateRequestStatusBasedOnItems(ProcurementRequest $request): void
    {
        $items = $request->items;
        $totalItems = $items->count();
        
        if ($totalItems === 0) return;

        $arrivedItems = $items->where('status', ProcurementItemStatus::ARRIVAL->value)->count();
        $partialItems = $items->where('status', ProcurementItemStatus::PARTIAL_ARRIVAL->value)->count();
        $deliveredItems = $items->where('status', ProcurementItemStatus::DELIVERED->value)->count();

        // Auto-update request status logic would go here
        // This is a simplified version - full logic would be in a service class
    }

    public function getProducts(Request $request)
    {
        $query = ProcurementProduct::active();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%");
            });
        }

        $products = $query->take(20)->get(['id_product', 'product_code', 'product_name', 'unit']);
        
        return response()->json($products);
    }
}