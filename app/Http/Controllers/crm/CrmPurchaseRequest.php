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
        $total_pr_created = crm_purchase_request::where('status', 'PR Created')->count();
        $total_waiting_approval = crm_purchase_request::where('status', 'Waiting Director Approval')->count();
        $total_approved = crm_purchase_request::where('status', 'Approved')->count();
        $total_rejected = crm_purchase_request::where('status', 'Rejected')->count();

        return view('content.digitize.crm.crm-purchase-request', compact(
            'total_pr',
            'total_pr_created',
            'total_waiting_approval',
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
        try {
            $validatedData = $request->validate([
                'customer_name'           => 'required|string|max:255',
                'customer_po_number'      => 'required|string|max:255',
                'project_name'            => 'required|string|max:255',
                'items'                   => 'required|array|min:1',
                'items.*.name'            => 'required|string|max:255',
                'items.*.quantity'        => 'required|integer|min:1',
                'items.*.selling_price'   => 'required|string',
                'items.*.expected_delivery_date' => 'required|date',
                'items.*.lead_time'       => 'required|string|max:255',
                'attachment_customer_po'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
                'status'                  => 'required|string|max:255',
                'notes'                   => 'nullable|string',
            ]);

            // Handle file upload once
            $attachmentFilename = null;
            if ($request->hasFile('attachment_customer_po')) {
                $file = $request->file('attachment_customer_po');
                $attachmentFilename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/customer_po'), $attachmentFilename);
            }

            // Create multiple PR records - one per item
            $year = date('y');
            $month = date('m');
            $createdCount = 0;

            foreach ($validatedData['items'] as $item) {
                // Generate unique PR number for each item
                $lastPR = crm_purchase_request::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))
                    ->orderBy('id_purchase_request', 'desc')
                    ->first();
                
                $nextId = $lastPR ? (intval(substr($lastPR->pr_number, -3)) + 1) : 1;
                $prNumber = sprintf('PR-%s-%s-%03d', $year, $month, $nextId);

                // Parse formatted selling price (remove spaces)
                $sellingPrice = str_replace(' ', '', $item['selling_price']);

                // Create PR record
                $purchase_request = new crm_purchase_request([
                    'pr_number'              => $prNumber,
                    'customer_name'          => $validatedData['customer_name'],
                    'customer_po_number'     => $validatedData['customer_po_number'],
                    'project_name'           => $validatedData['project_name'],
                    'item_list'              => $item['name'],
                    'quantity'               => $item['quantity'],
                    'selling_price'          => $sellingPrice,
                    'expected_delivery_date' => $item['expected_delivery_date'],
                    'lead_time'              => $item['lead_time'],
                    'attachment_customer_po' => $attachmentFilename,
                    'status'                 => $validatedData['status'],
                    'notes'                  => $validatedData['notes'],
                ]);
                $purchase_request->save();
                $createdCount++;
            }

            return redirect('/crm/purchase-request')->with('success', "{$createdCount} Purchase Request(s) created successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
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
