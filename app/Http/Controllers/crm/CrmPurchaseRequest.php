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
        $total_pr = crm_purchase_request::count();

        // Purchasing (PR Created, Waiting Approval, Approved, DP Received)
        $total_purchasing = crm_purchase_request::whereIn('status', [
            'PR Created',
            'Waiting Director Approval',
            'Approved',
            'DP Received'
        ])->count();

        // Rejected
        $total_rejected = crm_purchase_request::where('status', 'Rejected')->count();

        // Production (Supplier Production, Goods Ready)
        $total_production = crm_purchase_request::whereIn('status', [
            'Supplier Production',
            'Supplier Inform Goods Ready for Pick Up'
        ])->count();

        // Shipment (Pick Up, In Transit, Delivery)
        $total_shipment = crm_purchase_request::whereIn('status', [
            'Pick Up Arrangement',
            'In Transit',
            'Shipment Delivery'
        ])->count();

        // Customs (All customs related)
        $total_customs = crm_purchase_request::whereIn('status', [
            'Customs Clearance',
            'PIB Draft',
            'ID Billing Request',
            'Payment to Kas Negara',
            'Custom Response (Red/Green/Yellow)',
            'Shipment Release'
        ])->count();

        // Internal (Warehouse, Lab Check, Dispatch)
        $total_internal = crm_purchase_request::whereIn('status', [
            'Warehouse Received',
            'Lab Check',
            'Dispatch to End Customer/Buyer'
        ])->count();

        // Delays (Delay Production, Delay Shipment)
        $total_delays = crm_purchase_request::whereIn('status', [
            'Delay Production',
            'Delay Shipment'
        ])->count();

        // Delivered
        $total_delivered = crm_purchase_request::where('status', 'Delivered')->count();

        // Complete
        $total_complete = crm_purchase_request::where('status', 'Complete')->count();

        return view('content.digitize.crm.crm-purchase-request', compact(
            'total_pr',
            'total_purchasing',
            'total_rejected',
            'total_production',
            'total_shipment',
            'total_customs',
            'total_internal',
            'total_delays',
            'total_delivered',
            'total_complete'
        ));
    }

    public function purchase_request_data()
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

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_name'           => 'required|string|max:255',
                'customer_po_number'      => 'required|string|max:255',
                'project_name'            => 'required|string|max:255',
                'term_of_payment'         => 'required|string|max:255',
                'down_payment'            => 'required|string|in:ON,OFF',
                'pr_number'               => 'required|string|max:255',
                'items'                   => 'required|array|min:1',
                'items.*.brand'           => 'required|string|max:255',
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
            $createdCount = 0;

            // Indonesian month names for date formatting
            $indonesianMonths = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            // English month abbreviations (3 letters)
            $monthsShort = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
                9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
            ];

            foreach ($validatedData['items'] as $item) {
                // Use PR number from form input (shared by all items)
                $prNumber = $validatedData['pr_number'];

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

                    // Format: "25 Oct - 15 Nov 2026"
                    $minDay = $minDate->day;
                    $minMonth = $monthsShort[$minDate->month];
                    $maxDay = $maxDate->day;
                    $maxMonth = $monthsShort[$maxDate->month];
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
                    'brand'                  => $item['brand'],
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

        // English month abbreviations (3 letters)
        $monthsShort = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
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

                // Format: "25 Oct - 15 Nov 2026"
                $minDay = $minDate->day;
                $minMonth = $monthsShort[$minDate->month];
                $maxDay = $maxDate->day;
                $maxMonth = $monthsShort[$maxDate->month];
                $year = $maxDate->year;

                $expectedDelivery = "{$minDay} {$minMonth} - {$maxDay} {$maxMonth} {$year}";
            } else {
                $expectedDelivery = '-';
            }

            $oldStatus = $pr->status;

            $pr->update([
                'dp_received_date' => $validatedData['dp_received_date'],
                'expected_delivery_date' => $expectedDelivery,
                'status' => 'DP Received',
            ]);

            // Create status history record
            \App\Models\StatusHistory::create([
                'user_id' => auth()->id(),
                'reference_type' => get_class($pr),
                'reference_id' => $pr->id_purchase_request,
                'from_status' => $oldStatus,
                'to_status' => 'DP Received',
                'comment_id' => null,
            ]);
        }

        return redirect()->back()->with('success', 'DP received date updated and status changed to DP Received!');
    }

    public function update_principal_po(Request $request, $id_purchase_request)
    {
        $validatedData = $request->validate([
            'principal_po_number' => 'required|string|max:255',
        ]);

        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);

        // Get all related PRs with same project and PO
        $related_prs = crm_purchase_request::where('project_name', $purchase_request->project_name)
            ->where('customer_po_number', $purchase_request->customer_po_number)
            ->get();

        // Update all related PRs
        foreach ($related_prs as $pr) {
            $pr->update([
                'principal_po_number' => $validatedData['principal_po_number'],
            ]);
        }

        return redirect()->back()->with('success', 'Principal PO Number updated successfully!');
    }

    public function update_principal_delivery(Request $request, $id_purchase_request)
    {
        $validatedData = $request->validate([
            'principal_delivery_date' => 'required|date',
        ]);

        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);

        $oldDate = $purchase_request->principal_delivery_date;

        $purchase_request->update([
            'principal_delivery_date' => $validatedData['principal_delivery_date'],
        ]);

        // Create status history record for principal delivery date change
        \App\Models\StatusHistory::create([
            'user_id' => auth()->id(),
            'reference_type' => get_class($purchase_request),
            'reference_id' => $purchase_request->id_purchase_request,
            'from_status' => $oldDate ? 'Principal Delivery: ' . \Carbon\Carbon::parse($oldDate)->format('d M Y') : 'Principal Delivery: Not Set',
            'to_status' => 'Principal Delivery: ' . \Carbon\Carbon::parse($validatedData['principal_delivery_date'])->format('d M Y'),
            'comment_id' => null,
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

        // Update all related PRs and log status history
        foreach ($related_prs as $pr) {
            $oldStatus = $pr->status;

            $pr->update([
                'status' => $validatedData['status'],
            ]);

            // Create status history record
            \App\Models\StatusHistory::create([
                'user_id' => auth()->id(),
                'reference_type' => get_class($pr),
                'reference_id' => $pr->id_purchase_request,
                'from_status' => $oldStatus,
                'to_status' => $validatedData['status'],
                'comment_id' => null,
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

    public function get_brands()
    {
        $brands = crm_purchase_request::select('brand')
            ->distinct()
            ->whereNotNull('brand')
            ->orderBy('brand', 'asc')
            ->pluck('brand');

        return response()->json($brands);
    }

    // Add comment to purchase request
    public function add_comment(Request $request, $id_purchase_request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);

        $comment = \App\Models\Comment::create([
            'user_id' => auth()->id(),
            'parent_id' => $validatedData['parent_id'] ?? null,
            'commentable_type' => get_class($purchase_request),
            'commentable_id' => $purchase_request->id_purchase_request,
            'content' => $validatedData['content'],
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    // Get comments for purchase request
    public function get_comments($id_purchase_request)
    {
        $purchase_request = crm_purchase_request::findOrFail($id_purchase_request);

        $comments = \App\Models\Comment::where('commentable_type', get_class($purchase_request))
            ->where('commentable_id', $purchase_request->id_purchase_request)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user', 'replies.replies'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    // Delete comment (soft delete)
    public function delete_comment($id_comment)
    {
        $comment = \App\Models\Comment::findOrFail($id_comment);

        // Check if user owns the comment
        if ($comment->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized to delete this comment!');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }

    public function destroy()
    {
        //
    }
}
