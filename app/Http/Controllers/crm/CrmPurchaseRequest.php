<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_purchase_request;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CrmPurchaseRequest extends Controller
{
    public function index()
    {
        $total_pr     = crm_purchase_request::count();
        $total_pending = crm_purchase_request::where('status', 'Pending')->count();
        $total_approved = crm_purchase_request::where('status', 'Approved')->count();
        $total_rejected = crm_purchase_request::where('status', 'Rejected')->count();

        return view('content.digitize.crm.crm-purchase-request', compact(
            'total_pr',
            'total_pending',
            'total_approved',
            'total_rejected'
        ));
    }

    public function purchase_request_data()
    {
        $purchase_requests = crm_purchase_request::all();

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

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'pr_number'    => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'requested_by' => 'required|string|max:255',
            'department'   => 'required|string|max:255',
            'priority'     => 'required|string|max:255',
            'notes'        => 'nullable|string',
        ]);

        $validatedData['status'] = $request->input('status', 'Pending');

        $purchase_request = new crm_purchase_request($validatedData);
        $purchase_request->save();

        return redirect('/crm/purchase-request')->with('success', 'Purchase Request created successfully!');
    }

    public function purchase_request_view(Request $request, $id_purchase_request)
    {
        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);

        return view('content.digitize.crm.crm-purchase-request-view', compact('purchase_request'));
    }

    public function purchase_request_edit(Request $request, $id_purchase_request)
    {
        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);

        $validatedData = $request->validate([
            'pr_number'    => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'requested_by' => 'required|string|max:255',
            'department'   => 'required|string|max:255',
            'priority'     => 'required|string|max:255',
            'status'       => 'required|string|max:255',
            'notes'        => 'nullable|string',
        ]);

        $purchase_request->update($validatedData);

        return redirect()->route('crm-purchase-request-view', ['id_purchase_request' => $id_purchase_request])
            ->with('success', 'Purchase Request updated successfully!');
    }

    public function destroy()
    {
        //
    }
}
