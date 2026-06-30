<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementItem;
use App\Models\procurement\ProcurementArrivalHistory;
use App\Enums\procurement\ProcurementItemStatus;
use App\Enums\procurement\ProcurementRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProcurementArrivalController extends Controller
{
    public function index()
    {
        $pageConfigs = [
            'pageHeader' => true,
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'procurement-arrivals-page'
        ];

        return view('content.digitize.procurement.arrivals.index', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function data(Request $request)
    {
        $query = ProcurementArrivalHistory::with([
            'item.request.salesUser',
            'item.request.customer', 
            'createdBy'
        ])->select('procurement_arrival_histories.*');

        // Apply filters
        if ($request->filled('warehouse')) {
            $query->where('warehouse', $request->warehouse);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('arrival_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('arrival_date', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('request_number', function ($arrival) {
                return $arrival->item->request->request_number ?? '';
            })
            ->addColumn('product_name', function ($arrival) {
                return $arrival->item->product_name ?? '';
            })
            ->addColumn('customer_name', function ($arrival) {
                return $arrival->item->request->customer->customer_name ?? 'Internal';
            })
            ->addColumn('sales_name', function ($arrival) {
                return $arrival->item->request->salesUser->name ?? '';
            })
            ->addColumn('recorded_by', function ($arrival) {
                return $arrival->createdBy->name ?? '';
            })
            ->addColumn('actions', function ($arrival) {
                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>';
                $actions .= '<ul class="dropdown-menu">';
                $actions .= '<li><a class="dropdown-item" href="' . route('procurement.arrivals.show', $arrival->id_arrival_history) . '">View</a></li>';
                
                if ($this->userCanDeleteArrival($arrival)) {
                    $actions .= '<li><a class="dropdown-item text-danger" onclick="deleteArrival(' . $arrival->id_arrival_history . ')">Delete</a></li>';
                }
                
                $actions .= '</ul></div>';
                return $actions;
            })
            ->editColumn('arrival_date', function ($arrival) {
                return $arrival->arrival_date->format('M d, Y');
            })
            ->editColumn('qty', function ($arrival) {
                return number_format($arrival->qty, 2) . ' ' . $arrival->item->unit;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function show(ProcurementArrivalHistory $arrival)
    {
        $arrival->load([
            'item.request.salesUser',
            'item.request.customer',
            'item.arrivalHistories',
            'createdBy'
        ]);

        return view('content.digitize.procurement.arrivals.show', compact('arrival'));
    }

    public function record(Request $request)
    {
        $request->validate([
            'id_procurement_item' => 'required|exists:procurement_items,id_procurement_item',
            'qty' => 'required|numeric|min:0.01',
            'arrival_date' => 'required|date|before_or_equal:today',
            'warehouse' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000'
        ]);

        $item = ProcurementItem::with('request')->findOrFail($request->id_procurement_item);

        // Check if item can receive arrivals
        if (!$item->canReceiveArrival()) {
            return response()->json([
                'success' => false,
                'message' => 'Item cannot receive arrivals in current status'
            ]);
        }

        // Check if arrival quantity is valid
        if ($request->qty > $item->remaining_qty) {
            return response()->json([
                'success' => false,
                'message' => 'Arrival quantity exceeds remaining quantity (' . $item->remaining_qty . ' ' . $item->unit . ')'
            ]);
        }

        try {
            DB::transaction(function () use ($request, $item) {
                // Create arrival history record
                $arrival = $item->arrivalHistories()->create([
                    'qty' => $request->qty,
                    'arrival_date' => $request->arrival_date,
                    'warehouse' => $request->warehouse,
                    'note' => $request->note,
                    'created_by' => auth()->id()
                ]);

                // Update item quantities
                $oldArrivedQty = $item->arrived_qty;
                $item->arrived_qty += $request->qty;

                // Update item status based on arrival
                $oldStatus = ProcurementItemStatus::from($item->status);
                if ($item->remaining_qty <= 0.01) { // Using small epsilon for float comparison
                    $newStatus = ProcurementItemStatus::ARRIVAL;
                } else {
                    $newStatus = ProcurementItemStatus::PARTIAL_ARRIVAL;
                }

                if ($oldStatus !== $newStatus) {
                    $item->status = $newStatus->value;

                    // Create item status history
                    $item->statusHistories()->create([
                        'id_procurement_request' => $item->id_procurement_request,
                        'old_status' => $oldStatus->value,
                        'new_status' => $newStatus->value,
                        'note' => "Arrival recorded: {$request->qty} {$item->unit}",
                        'changed_by' => auth()->id()
                    ]);
                }

                $item->save();

                // Update request status if needed
                $this->updateRequestStatusBasedOnItems($item->request);

                // Create system comment
                $message = "Arrival recorded for {$item->product_name}: {$request->qty} {$item->unit}";
                if ($request->warehouse) {
                    $message .= " at {$request->warehouse}";
                }
                if ($request->note) {
                    $message .= " - Note: {$request->note}";
                }

                $item->request->comments()->create([
                    'id_user' => auth()->id(),
                    'message' => $message,
                    'is_system' => true
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Arrival recorded successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record arrival: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(ProcurementArrivalHistory $arrival)
    {
        if (!$this->userCanDeleteArrival($arrival)) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $item = $arrival->item;
        $request = $item->request;

        if ($request->isReadOnly()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete arrival from completed request'
            ]);
        }

        try {
            DB::transaction(function () use ($arrival, $item, $request) {
                // Store arrival info for system comment
                $arrivalInfo = [
                    'qty' => $arrival->qty,
                    'unit' => $item->unit,
                    'product_name' => $item->product_name,
                    'arrival_date' => $arrival->arrival_date->format('M d, Y')
                ];

                // Remove arrival quantity from item
                $item->arrived_qty -= $arrival->qty;
                
                // Recalculate item status
                $oldStatus = ProcurementItemStatus::from($item->status);
                
                if ($item->arrived_qty <= 0) {
                    $newStatus = ProcurementItemStatus::ORDERED; // or previous appropriate status
                } elseif ($item->remaining_qty > 0.01) {
                    $newStatus = ProcurementItemStatus::PARTIAL_ARRIVAL;
                } else {
                    $newStatus = ProcurementItemStatus::ARRIVAL;
                }

                if ($oldStatus !== $newStatus) {
                    $item->status = $newStatus->value;

                    // Create status history
                    $item->statusHistories()->create([
                        'id_procurement_request' => $item->id_procurement_request,
                        'old_status' => $oldStatus->value,
                        'new_status' => $newStatus->value,
                        'note' => "Arrival deleted: {$arrivalInfo['qty']} {$arrivalInfo['unit']}",
                        'changed_by' => auth()->id()
                    ]);
                }

                $item->save();

                // Delete arrival record
                $arrival->delete();

                // Update request status
                $this->updateRequestStatusBasedOnItems($request);

                // Create system comment
                $request->comments()->create([
                    'id_user' => auth()->id(),
                    'message' => "Arrival deleted for {$arrivalInfo['product_name']}: {$arrivalInfo['qty']} {$arrivalInfo['unit']} ({$arrivalInfo['arrival_date']})",
                    'is_system' => true
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Arrival deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete arrival: ' . $e->getMessage()
            ]);
        }
    }

    public function getItemArrivals(ProcurementItem $item)
    {
        $arrivals = $item->arrivalHistories()
                         ->with('createdBy')
                         ->orderBy('arrival_date', 'desc')
                         ->get();

        return response()->json([
            'item' => [
                'id' => $item->id_procurement_item,
                'product_name' => $item->product_name,
                'requested_qty' => $item->requested_qty,
                'arrived_qty' => $item->arrived_qty,
                'remaining_qty' => $item->remaining_qty,
                'unit' => $item->unit,
                'status' => $item->status,
                'can_receive_arrival' => $item->canReceiveArrival()
            ],
            'arrivals' => $arrivals->map(function ($arrival) {
                return [
                    'id' => $arrival->id_arrival_history,
                    'qty' => $arrival->qty,
                    'arrival_date' => $arrival->arrival_date->format('M d, Y'),
                    'warehouse' => $arrival->warehouse,
                    'note' => $arrival->note,
                    'recorded_by' => $arrival->createdBy->name,
                    'recorded_at' => $arrival->created_at->format('M d, Y H:i'),
                    'can_delete' => $this->userCanDeleteArrival($arrival)
                ];
            })
        ]);
    }

    public function getWarehouses()
    {
        // Get distinct warehouses from arrival history
        $warehouses = ProcurementArrivalHistory::whereNotNull('warehouse')
                                              ->distinct()
                                              ->pluck('warehouse')
                                              ->filter()
                                              ->sort()
                                              ->values();

        return response()->json($warehouses);
    }

    public function bulkRecord(Request $request)
    {
        $request->validate([
            'arrivals' => 'required|array|min:1|max:50',
            'arrivals.*.id_procurement_item' => 'required|exists:procurement_items,id_procurement_item',
            'arrivals.*.qty' => 'required|numeric|min:0.01',
            'arrivals.*.arrival_date' => 'required|date|before_or_equal:today',
            'arrivals.*.warehouse' => 'nullable|string|max:255',
            'arrivals.*.note' => 'nullable|string|max:500'
        ]);

        $results = [];
        $successCount = 0;

        DB::transaction(function () use ($request, &$results, &$successCount) {
            foreach ($request->arrivals as $arrivalData) {
                try {
                    $item = ProcurementItem::with('request')->findOrFail($arrivalData['id_procurement_item']);

                    if (!$item->canReceiveArrival()) {
                        $results[] = [
                            'product' => $item->product_name,
                            'success' => false,
                            'message' => 'Cannot receive arrivals in current status'
                        ];
                        continue;
                    }

                    if ($arrivalData['qty'] > $item->remaining_qty) {
                        $results[] = [
                            'product' => $item->product_name,
                            'success' => false,
                            'message' => 'Quantity exceeds remaining: ' . $item->remaining_qty
                        ];
                        continue;
                    }

                    // Record arrival (simplified version of single record logic)
                    $item->arrivalHistories()->create([
                        'qty' => $arrivalData['qty'],
                        'arrival_date' => $arrivalData['arrival_date'],
                        'warehouse' => $arrivalData['warehouse'] ?? null,
                        'note' => $arrivalData['note'] ?? null,
                        'created_by' => auth()->id()
                    ]);

                    $item->arrived_qty += $arrivalData['qty'];
                    
                    // Update status
                    if ($item->remaining_qty <= 0.01) {
                        $item->status = ProcurementItemStatus::ARRIVAL->value;
                    } else {
                        $item->status = ProcurementItemStatus::PARTIAL_ARRIVAL->value;
                    }
                    
                    $item->save();

                    $results[] = [
                        'product' => $item->product_name,
                        'success' => true,
                        'message' => 'Arrival recorded successfully'
                    ];
                    
                    $successCount++;

                } catch (\Exception $e) {
                    $results[] = [
                        'product' => $arrivalData['product_name'] ?? 'Unknown',
                        'success' => false,
                        'message' => $e->getMessage()
                    ];
                }
            }
        });

        return response()->json([
            'success' => $successCount > 0,
            'message' => "{$successCount} arrivals recorded successfully",
            'results' => $results
        ]);
    }

    private function updateRequestStatusBasedOnItems(ProcurementRequest $request): void
    {
        $items = $request->items;
        $totalItems = $items->count();
        
        if ($totalItems === 0) return;

        $arrivedItems = $items->where('status', ProcurementItemStatus::ARRIVAL->value)->count();
        $partialItems = $items->where('status', ProcurementItemStatus::PARTIAL_ARRIVAL->value)->count();

        $oldStatus = ProcurementRequestStatus::from($request->status);
        $newStatus = null;

        // All items fully arrived
        if ($arrivedItems === $totalItems) {
            $newStatus = ProcurementRequestStatus::ARRIVAL;
        }
        // Some items arrived (partial or full)
        elseif ($arrivedItems > 0 || $partialItems > 0) {
            $newStatus = ProcurementRequestStatus::PARTIAL_ARRIVAL;
        }

        if ($newStatus && $oldStatus !== $newStatus && $oldStatus->canTransitionTo($newStatus)) {
            $request->status = $newStatus->value;
            $request->save();

            // Create status history
            $request->statusHistories()->create([
                'old_status' => $oldStatus->value,
                'new_status' => $newStatus->value,
                'note' => 'Auto-updated based on item arrivals',
                'changed_by' => auth()->id()
            ]);

            // Create system comment
            $request->comments()->create([
                'id_user' => auth()->id(),
                'message' => "Request status changed from {$oldStatus->label()} to {$newStatus->label()} (auto-updated)",
                'is_system' => true
            ]);
        }
    }

    private function userCanDeleteArrival(ProcurementArrivalHistory $arrival): bool
    {
        $user = auth()->user();

        // Admin can delete anything
        if ($user->role === 1) {
            return true;
        }

        // User can delete their own arrivals within 24 hours if request is not completed
        if ($arrival->created_by === $user->id && 
            $arrival->created_at->diffInHours(now()) <= 24 &&
            !$arrival->item->request->isReadOnly()) {
            return true;
        }

        return false;
    }
}