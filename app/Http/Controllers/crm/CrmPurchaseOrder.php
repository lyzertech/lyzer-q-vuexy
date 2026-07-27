<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_purchase_request;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CrmPurchaseOrder extends Controller
{
    public function index()
    {
        return view('content.digitize.crm.crm-purchase-order');
    }

    public function purchase_order_data()
    {
        $purchase_requests = crm_purchase_request::orderBy('id_purchase_request', 'desc')->get();

        return DataTables::of($purchase_requests)
            ->editColumn('created_at', function ($pr) {
                return $pr->created_at ? $pr->created_at->format('Y-m-d H:i') : '-';
            })
            ->addColumn('action', function ($pr) {
                $showUrl = route('crm-purchase-request-view', $pr->id_purchase_request);

                return '
                <a href="' . $showUrl . '" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
                    <i class="ti ti-eye ti-md"></i>
                </a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function update_principal_po(Request $request)
    {
        $validatedData = $request->validate([
            'principal_po_number' => 'required|string|max:255',
            'pr_ids' => 'required|array|min:1',
            'pr_ids.*' => 'required|exists:crm_purchase_request,id_purchase_request',
        ]);

        try {
            crm_purchase_request::whereIn('id_purchase_request', $validatedData['pr_ids'])
                ->update(['principal_po_number' => $validatedData['principal_po_number']]);

            return response()->json([
                'success' => true,
                'message' => 'Principal PO Number updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_delivery_date(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:crm_purchase_request,id_purchase_request',
            'items.*.delivery_date' => 'required|date',
        ]);

        try {
            foreach ($validatedData['items'] as $item) {
                $pr = crm_purchase_request::findOrFail($item['id']);
                $oldStatus = $pr->status;

                $pr->update([
                    'principal_delivery_date' => $item['delivery_date'],
                    'status' => 'Supplier Production'
                ]);

                \App\Models\StatusHistory::create([
                    'user_id' => auth()->id(),
                    'reference_type' => get_class($pr),
                    'reference_id' => $pr->id_purchase_request,
                    'from_status' => $oldStatus,
                    'to_status' => 'Supplier Production',
                    'comment_id' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Principal Delivery Date updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_status(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:crm_purchase_request,id_purchase_request',
            'items.*.delivery_date' => 'nullable|date',
        ]);

        try {
            foreach ($validatedData['items'] as $item) {
                $pr = crm_purchase_request::findOrFail($item['id']);
                $oldStatus = $pr->status;

                $updateData = ['status' => $validatedData['status']];

                if (!empty($item['delivery_date'])) {
                    $updateData['principal_delivery_date'] = $item['delivery_date'];
                }

                $pr->update($updateData);

                \App\Models\StatusHistory::create([
                    'user_id' => auth()->id(),
                    'reference_type' => get_class($pr),
                    'reference_id' => $pr->id_purchase_request,
                    'from_status' => $oldStatus,
                    'to_status' => $validatedData['status'],
                    'comment_id' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_status_bulk(Request $request)
    {
        $validatedData = $request->validate([
            'updates' => 'required|array|min:1',
            'updates.*.id' => 'required|exists:crm_purchase_request,id_purchase_request',
            'updates.*.status' => 'required|string',
            'updates.*.delivery_date' => 'nullable|date',
        ]);

        try {
            foreach ($validatedData['updates'] as $update) {
                $pr = crm_purchase_request::findOrFail($update['id']);
                $oldStatus = $pr->status;

                $updateData = ['status' => $update['status']];

                if (!empty($update['delivery_date'])) {
                    $updateData['principal_delivery_date'] = $update['delivery_date'];
                }

                $pr->update($updateData);

                \App\Models\StatusHistory::create([
                    'user_id' => auth()->id(),
                    'reference_type' => get_class($pr),
                    'reference_id' => $pr->id_purchase_request,
                    'from_status' => $oldStatus,
                    'to_status' => $update['status'],
                    'comment_id' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
