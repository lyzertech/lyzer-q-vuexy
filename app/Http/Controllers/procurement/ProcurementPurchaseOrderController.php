<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementPurchaseOrder;
use App\Models\procurement\ProcurementSupplier;
use App\Enums\procurement\PurchaseOrderStatus;
use App\Enums\procurement\ProcurementRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcurementPurchaseOrderController extends Controller
{
    public function index()
    {
        // Statistics for Purchase Orders Index
        $stats = [
            'total' => ProcurementPurchaseOrder::count(),
            'pending' => ProcurementPurchaseOrder::whereIn('status', ['draft', 'pending_approval'])->count(),
            'sent' => ProcurementPurchaseOrder::where('status', 'sent')->count(),
            'monthly_value' => ProcurementPurchaseOrder::whereMonth('created_at', now()->month)->sum('total_amount') ?? 0,
        ];

        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-purchase-orders-page'
        ];

        return view('content.digitize.procurement.po.index', [
            'pageConfigs' => $pageConfigs,
            'stats' => $stats
        ]);
    }

    public function data(Request $request)
    {
        $query = ProcurementPurchaseOrder::with([
            'request.salesUser',
            'supplier',
            'createdBy'
        ])->select('procurement_purchase_orders.*');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('supplier_id')) {
            $query->where('id_supplier', $request->supplier_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('po_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('po_date', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('request_number', function ($po) {
                return $po->request->request_number ?? '';
            })
            ->addColumn('supplier_name', function ($po) {
                return $po->supplier->supplier_name ?? '';
            })
            ->addColumn('sales_name', function ($po) {
                return $po->request->salesUser->name ?? '';
            })
            ->addColumn('created_by_name', function ($po) {
                return $po->createdBy->name ?? '';
            })
            ->addColumn('status_badge', function ($po) {
                $status = PurchaseOrderStatus::from($po->status);
                return '<span class="badge bg-' . $status->color() . '">' . $status->label() . '</span>';
            })
            ->addColumn('actions', function ($po) {
                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>';
                $actions .= '<ul class="dropdown-menu">';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.po.show', $po->id_purchase_order) . '">View</a></li>';
                
                if ($po->canBeEdited()) {
                    $actions .= '<li><a class="dropdown-item" href="' . route('procurement.po.edit', $po->id_purchase_order) . '">Edit</a></li>';
                }
                
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.po.pdf', $po->id_purchase_order) . '" target="_blank">Download PDF</a></li>';
                
                if ($po->status === 'draft') {
                    $actions .= '<li><a class="dropdown-item" onclick="sendPO(' . $po->id_purchase_order . ')">Send to Supplier</a></li>';
                }
                
                if ($po->status === 'sent') {
                    $actions .= '<li><a class="dropdown-item" onclick="acknowledgePO(' . $po->id_purchase_order . ')">Mark as Acknowledged</a></li>';
                }
                
                $actions .= '</ul></div>';
                return $actions;
            })
            ->editColumn('po_date', function ($po) {
                return $po->po_date->format('M d, Y');
            })
            ->editColumn('total_amount', function ($po) {
                return number_format($po->total_amount, 2);
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $requests = ProcurementRequest::with(['salesUser', 'customer'])
                                    ->whereIn('status', ['approved', 'purchasing'])
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        
        $suppliers = ProcurementSupplier::active()->orderBy('supplier_name')->get();

        return view('content.digitize.procurement.po.create', compact('requests', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_procurement_request' => 'required|exists:procurement_requests,id_procurement_request',
            'id_supplier' => 'required|exists:procurement_suppliers,id_supplier',
            'po_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        $procurementRequest = ProcurementRequest::findOrFail($request->id_procurement_request);
        
        // Check if request can have PO created
        if (!in_array($procurementRequest->status, ['approved', 'purchasing'])) {
            return redirect()->back()->withErrors(['error' => 'Cannot create PO for request in current status']);
        }

        DB::transaction(function () use ($request, $procurementRequest) {
            // Create purchase order
            $po = ProcurementPurchaseOrder::create([
                'id_procurement_request' => $request->id_procurement_request,
                'id_supplier' => $request->id_supplier,
                'po_date' => $request->po_date,
                'total_amount' => $request->total_amount,
                'notes' => $request->notes,
                'status' => PurchaseOrderStatus::DRAFT->value,
                'created_by' => auth()->id()
            ]);

            // Update procurement request status to purchasing if not already
            if ($procurementRequest->status !== ProcurementRequestStatus::PURCHASING->value) {
                $this->updateRequestStatus($procurementRequest, ProcurementRequestStatus::PURCHASING, 'Purchase Order created');
            }

            // Update related items to ordered status
            $procurementRequest->items()
                              ->where('status', 'requested')
                              ->update(['status' => 'ordered']);

            // Create system comment
            $supplier = ProcurementSupplier::find($request->id_supplier);
            $procurementRequest->comments()->create([
                'id_user' => auth()->id(),
                'message' => "Purchase Order {$po->po_number} created for supplier: {$supplier->supplier_name}",
                'is_system' => true
            ]);
        });

        return redirect()->route('procurement.po.index')
                        ->with('success', 'Purchase Order created successfully.');
    }

    public function show(ProcurementPurchaseOrder $po)
    {
        $po->load([
            'request.salesUser',
            'request.customer', 
            'request.items',
            'supplier',
            'createdBy'
        ]);

        return view('content.digitize.procurement.po.show', compact('po'));
    }

    public function edit(ProcurementPurchaseOrder $po)
    {
        if (!$po->canBeEdited()) {
            return redirect()->route('procurement.po.show', $po)
                           ->with('error', 'This Purchase Order cannot be edited.');
        }

        $suppliers = ProcurementSupplier::active()->orderBy('supplier_name')->get();

        return view('content.digitize.procurement.po.edit', compact('po', 'suppliers'));
    }

    public function update(Request $request, ProcurementPurchaseOrder $po)
    {
        if (!$po->canBeEdited()) {
            return redirect()->route('procurement.po.show', $po)
                           ->with('error', 'This Purchase Order cannot be edited.');
        }

        $request->validate([
            'id_supplier' => 'required|exists:procurement_suppliers,id_supplier',
            'po_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        $oldSupplier = $po->supplier;
        $po->update($request->only(['id_supplier', 'po_date', 'total_amount', 'notes']));

        // Create system comment if supplier changed
        if ($po->id_supplier != $oldSupplier->id_supplier) {
            $newSupplier = ProcurementSupplier::find($po->id_supplier);
            $po->request->comments()->create([
                'id_user' => auth()->id(),
                'message' => "PO {$po->po_number} supplier changed from {$oldSupplier->supplier_name} to {$newSupplier->supplier_name}",
                'is_system' => true
            ]);
        }

        return redirect()->route('procurement.po.show', $po)
                        ->with('success', 'Purchase Order updated successfully.');
    }

    public function destroy(ProcurementPurchaseOrder $po)
    {
        if (!$po->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete completed PO']);
        }

        $poNumber = $po->po_number;
        $request = $po->request;

        $po->delete();

        // Create system comment
        $request->comments()->create([
            'id_user' => auth()->id(),
            'message' => "Purchase Order {$poNumber} deleted",
            'is_system' => true
        ]);

        return redirect()->route('procurement.po.index')
                        ->with('success', 'Purchase Order deleted successfully.');
    }

    public function send(ProcurementPurchaseOrder $po)
    {
        if ($po->status !== PurchaseOrderStatus::DRAFT->value) {
            return response()->json(['success' => false, 'message' => 'PO is not in draft status']);
        }

        $this->changePOStatus($po, PurchaseOrderStatus::SENT, 'Purchase Order sent to supplier');

        return response()->json(['success' => true, 'message' => 'Purchase Order sent successfully']);
    }

    public function acknowledge(ProcurementPurchaseOrder $po)
    {
        if ($po->status !== PurchaseOrderStatus::SENT->value) {
            return response()->json(['success' => false, 'message' => 'PO is not in sent status']);
        }

        $this->changePOStatus($po, PurchaseOrderStatus::ACKNOWLEDGED, 'Purchase Order acknowledged by supplier');

        return response()->json(['success' => true, 'message' => 'Purchase Order acknowledged']);
    }

    public function markPartialReceived(Request $request, ProcurementPurchaseOrder $po)
    {
        if (!in_array($po->status, [PurchaseOrderStatus::ACKNOWLEDGED->value, PurchaseOrderStatus::PARTIAL_RECEIVED->value])) {
            return response()->json(['success' => false, 'message' => 'Invalid PO status for partial receipt']);
        }

        $request->validate([
            'note' => 'nullable|string|max:500'
        ]);

        $this->changePOStatus($po, PurchaseOrderStatus::PARTIAL_RECEIVED, 'Partial items received' . ($request->note ? ' - ' . $request->note : ''));

        return response()->json(['success' => true, 'message' => 'PO marked as partially received']);
    }

    public function markCompleted(Request $request, ProcurementPurchaseOrder $po)
    {
        if (!in_array($po->status, [PurchaseOrderStatus::ACKNOWLEDGED->value, PurchaseOrderStatus::PARTIAL_RECEIVED->value])) {
            return response()->json(['success' => false, 'message' => 'Invalid PO status for completion']);
        }

        $request->validate([
            'note' => 'nullable|string|max:500'
        ]);

        $this->changePOStatus($po, PurchaseOrderStatus::COMPLETED, 'All items received' . ($request->note ? ' - ' . $request->note : ''));

        return response()->json(['success' => true, 'message' => 'PO marked as completed']);
    }

    public function generatePdf(ProcurementPurchaseOrder $po)
    {
        $po->load([
            'request.salesUser',
            'request.customer',
            'request.items',
            'supplier',
            'createdBy'
        ]);

        $pdf = Pdf::loadView('procurement.purchase-orders.pdf', compact('po'));
        
        return $pdf->download("PO_{$po->po_number}.pdf");
    }

    public function getRequestItems(ProcurementRequest $request)
    {
        $items = $request->items()->with('product')->get();
        
        return response()->json([
            'request' => [
                'id' => $request->id_procurement_request,
                'request_number' => $request->request_number,
                'title' => $request->title,
                'sales_name' => $request->salesUser->name,
                'customer_name' => $request->customer->customer_name ?? 'Internal'
            ],
            'items' => $items->map(function ($item) {
                return [
                    'id' => $item->id_procurement_item,
                    'product_name' => $item->product_name,
                    'specification' => $item->specification,
                    'requested_qty' => $item->requested_qty,
                    'unit' => $item->unit,
                    'status' => $item->status
                ];
            })
        ]);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'po_ids' => 'required|array',
            'po_ids.*' => 'integer|exists:procurement_purchase_orders,id_purchase_order',
            'status' => 'required|string|in:' . implode(',', array_map(fn($status) => $status->value, PurchaseOrderStatus::cases())),
            'note' => 'nullable|string|max:500'
        ]);

        $pos = ProcurementPurchaseOrder::whereIn('id_purchase_order', $request->po_ids)->get();
        $updatedCount = 0;
        $errors = [];

        foreach ($pos as $po) {
            try {
                $currentStatus = PurchaseOrderStatus::from($po->status);
                $newStatus = PurchaseOrderStatus::from($request->status);
                
                if (!$currentStatus->canTransitionTo($newStatus)) {
                    $errors[] = "PO {$po->po_number}: Cannot transition from {$currentStatus->label()} to {$newStatus->label()}";
                    continue;
                }

                $this->changePOStatus($po, $newStatus, $request->note ?? "Bulk status update");
                $updatedCount++;

            } catch (\Exception $e) {
                $errors[] = "PO {$po->po_number}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => $updatedCount > 0,
            'message' => "{$updatedCount} Purchase Order(s) updated successfully",
            'updated_count' => $updatedCount,
            'errors' => $errors
        ]);
    }

    private function changePOStatus(ProcurementPurchaseOrder $po, PurchaseOrderStatus $newStatus, string $note = null): void
    {
        $oldStatus = PurchaseOrderStatus::from($po->status);
        
        if (!$oldStatus->canTransitionTo($newStatus)) {
            throw new \InvalidArgumentException("Cannot transition from {$oldStatus->value} to {$newStatus->value}");
        }

        $po->status = $newStatus->value;
        $po->save();

        // Create system comment
        $po->request->comments()->create([
            'id_user' => auth()->id(),
            'message' => "PO {$po->po_number}: Status changed from {$oldStatus->label()} to {$newStatus->label()}" . 
                        ($note ? " - {$note}" : ""),
            'is_system' => true
        ]);
    }

    private function updateRequestStatus(ProcurementRequest $request, ProcurementRequestStatus $newStatus, string $note = null): void
    {
        $oldStatus = ProcurementRequestStatus::from($request->status);
        
        if (!$oldStatus->canTransitionTo($newStatus)) {
            return;
        }

        $request->status = $newStatus->value;
        $request->save();

        // Create status history
        $request->statusHistories()->create([
            'old_status' => $oldStatus->value,
            'new_status' => $newStatus->value,
            'note' => $note,
            'changed_by' => auth()->id()
        ]);

        // Create system comment
        $request->comments()->create([
            'id_user' => auth()->id(),
            'message' => "Request status changed from {$oldStatus->label()} to {$newStatus->label()}" . 
                        ($note ? " - {$note}" : ""),
            'is_system' => true
        ]);
    }
}