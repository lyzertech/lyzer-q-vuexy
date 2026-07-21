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
        $purchase_requests = crm_purchase_request::orderBy('pr_number', 'desc')->get();

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
                'term_of_payment'         => 'required|string|max:255',
                'down_payment'            => 'required|string|in:ON,OFF',
                'items'                   => 'required|array|min:1',
                'items.*.name'            => 'required|string|max:255',
                'items.*.quantity'        => 'required|integer|min:1',
                'items.*.selling_price'   => 'required|string',
                'items.*.min_lead_time'   => 'required|integer|min:0',
                'items.*.max_lead_time'   => 'required|integer|min:0',
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

            // Indonesian month names for date formatting
            $indonesianMonths = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

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
                
                // Combine min and max lead time
                $leadTime = $item['min_lead_time'] . '-' . $item['max_lead_time'] . ' weeks';

                // Calculate expected delivery date based on DP status
                if ($validatedData['down_payment'] === 'OFF') {
                    // Calculate expected delivery from today + lead time
                    $creationDate = \Carbon\Carbon::now();
                    $minWeeks = (int)$item['min_lead_time'];
                    $maxWeeks = (int)$item['max_lead_time'];
                    
                    $minDate = $creationDate->copy()->addWeeks($minWeeks);
                    $maxDate = $creationDate->copy()->addWeeks($maxWeeks);
                    
                    // Format in Indonesian: "30 Juli - 5 Agustus 2026"
                    $minDay = $minDate->day;
                    $minMonth = $indonesianMonths[$minDate->month];
                    $maxDay = $maxDate->day;
                    $maxMonth = $indonesianMonths[$maxDate->month];
                    $year_full = $maxDate->year;
                    
                    $expectedDelivery = "{$minDay} {$minMonth} - {$maxDay} {$maxMonth} {$year_full}";
                } else {
                    // DP is ON, wait for DP received date
                    $expectedDelivery = '-';
                }

                // Create PR record
                $purchase_request = new crm_purchase_request([
                    'pr_number'              => $prNumber,
                    'customer_name'          => $validatedData['customer_name'],
                    'customer_po_number'     => $validatedData['customer_po_number'],
                    'project_name'           => $validatedData['project_name'],
                    'term_of_payment'        => $validatedData['term_of_payment'],
                    'down_payment'           => $validatedData['down_payment'],
                    'item_list'              => $item['name'],
                    'quantity'               => $item['quantity'],
                    'selling_price'          => $sellingPrice,
                    'expected_delivery_date' => $expectedDelivery,
                    'lead_time'              => $leadTime,
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
        
        // Get all purchase requests with the same project_name and customer_po_number
        $related_prs = crm_purchase_request::where('project_name', $purchase_request->project_name)
            ->where('customer_po_number', $purchase_request->customer_po_number)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('content.digitize.crm.crm-purchase-request-view', compact('purchase_request', 'related_prs'));
    }

    public function update_dp_date(Request $request, $id_purchase_request)
    {
        $validatedData = $request->validate([
            'dp_received_date' => 'required|date',
        ]);

        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);
        
        // Get all related PRs with same project and PO
        $related_prs = crm_purchase_request::where('project_name', $purchase_request->project_name)
            ->where('customer_po_number', $purchase_request->customer_po_number)
            ->get();

        $dpDate = \Carbon\Carbon::parse($validatedData['dp_received_date']);

        // Indonesian month names
        $indonesianMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Update all related PRs
        foreach ($related_prs as $pr) {
            // Parse lead time (e.g., "10-12 weeks")
            preg_match('/(\d+)\s*-\s*(\d+)\s*weeks?/i', $pr->lead_time, $matches);
            
            if (count($matches) === 3) {
                $minWeeks = (int)$matches[1];
                $maxWeeks = (int)$matches[2];
                
                // Calculate expected delivery dates
                $minDate = $dpDate->copy()->addWeeks($minWeeks);
                $maxDate = $dpDate->copy()->addWeeks($maxWeeks);
                
                // Format in Indonesian: "30 Juli - 5 Agustus 2026"
                $minDay = $minDate->day;
                $minMonth = $indonesianMonths[$minDate->month];
                $maxDay = $maxDate->day;
                $maxMonth = $indonesianMonths[$maxDate->month];
                $year = $maxDate->year;
                
                $expectedDelivery = "{$minDay} {$minMonth} - {$maxDay} {$maxMonth} {$year}";
            } else {
                $expectedDelivery = '-';
            }

            $pr->update([
                'dp_received_date' => $validatedData['dp_received_date'],
                'expected_delivery_date' => $expectedDelivery,
                'status' => 'DP Received',
            ]);
        }

        return redirect()->back()->with('success', 'DP received date updated and status changed to DP Received!');
    }

    public function update_principal_delivery(Request $request, $id_purchase_request)
    {
        $validatedData = $request->validate([
            'principal_delivery_date' => 'required|date',
        ]);

        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);
        
        $purchase_request->update([
            'principal_delivery_date' => $validatedData['principal_delivery_date'],
        ]);

        return redirect()->back()->with('success', 'Principal delivery date updated successfully!');
    }

    public function update_status(Request $request, $id_purchase_request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);
        
        // Get all related PRs with same project and PO
        $related_prs = crm_purchase_request::where('project_name', $purchase_request->project_name)
            ->where('customer_po_number', $purchase_request->customer_po_number)
            ->get();

        // Update all related PRs
        foreach ($related_prs as $pr) {
            $pr->update([
                'status' => $validatedData['status'],
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully!');
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

    public function get_items()
    {
        $items = crm_purchase_request::select('item_list')
            ->distinct()
            ->whereNotNull('item_list')
            ->orderBy('item_list', 'asc')
            ->pluck('item_list');
        
        return response()->json($items);
    }

    public function destroy()
    {
        //
    }
}
