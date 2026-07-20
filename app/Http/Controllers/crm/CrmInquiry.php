<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CrmInquiry extends Controller
{
    public function index()
    {
        $total_inquiry = crm_inquiry::count();
        $total_waiting = crm_inquiry::where('status', 'Waiting Supplier Feedback')->count();
        $total_updated_by_purchasing = crm_inquiry::where('status', 'Updated by Purchasing')->count();
        $total_rejected = crm_inquiry::where('status', 'Rejected')->count();
        
        $product_types = crm_inquiry::select('product_type')
            ->distinct()
            ->whereNotNull('product_type')
            ->orderBy('product_type')
            ->pluck('product_type');

        return view('content.digitize.crm.crm-inquiry', compact(
            'total_inquiry',
            'total_waiting',
            'total_updated_by_purchasing',
            'total_rejected',
            'product_types'
        ));
    }

    public function inquiry_data()
    {
        $inquiries = crm_inquiry::all();

        return DataTables::of($inquiries)
            ->editColumn('created_at', function ($inquiry) {
                return $inquiry->created_at ? $inquiry->created_at->format('Y-m-d H:i') : '-';
            })
            ->addColumn('action', function ($inquiry) {
                $showUrl = route('crm-inquiry-view', $inquiry->id_inquiry);

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
                'title'                => 'required|string|max:255',
                'pic_sales'            => 'required|string|max:255',
                'priority'             => 'nullable|string|max:255',
                'product_types'        => 'required|array|min:1',
                'product_types.*'      => 'required|string|max:255',
                'notes'                => 'nullable|string',
            ]);

            // Generate inquiry number and create multiple records (one per product)
            $year = date('y');
            $month = date('m');
            $productTypes = $request->input('product_types', []);
            $createdCount = 0;
            
            foreach ($productTypes as $productType) {
                // Get the last inquiry number for this month
                $lastInquiry = crm_inquiry::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))
                    ->orderBy('id_inquiry', 'desc')
                    ->first();
                
                $nextId = $lastInquiry ? (intval(substr($lastInquiry->inquiry_number, -3)) + 1) : 1;
                $inquiryNumber = sprintf('INQ-%s-%s-%03d', $year, $month, $nextId);
                
                $inquiry = new crm_inquiry([
                    'inquiry_number'     => $inquiryNumber,
                    'title'              => $validatedData['title'],
                    'pic_sales'          => $validatedData['pic_sales'],
                    'priority'           => $validatedData['priority'] ?? 'Medium',
                    'product_type'       => $productType,
                    'status'             => 'Waiting Supplier Feedback',
                    'notes'              => $validatedData['notes'] ?? null,
                ]);
                $inquiry->save();
                $createdCount++;
            }

            return redirect('/crm/inquiry')->with('success', "{$createdCount} inquiry record(s) created successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function inquiry_view(Request $request, $id_inquiry)
    {
        $inquiry = crm_inquiry::findOrFail($id_inquiry);
        
        // Get all related inquiries with the same project (title)
        $relatedInquiries = crm_inquiry::where('title', $inquiry->title)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('content.digitize.crm.crm-inquiry-view', compact('inquiry', 'relatedInquiries'));
    }

    public function inquiry_edit(Request $request, $id_inquiry)
    {
        $inquiry = crm_inquiry::findOrFail($id_inquiry);

        $validatedData = $request->validate([
            'title'                => 'required|string|max:255',
            'pic_sales'            => 'required|string|max:255',
            'priority'             => 'required|string|max:255',
            'product_type'         => 'nullable|string|max:255',
            'price_information'    => 'nullable|string',
            'lead_time'            => 'nullable|string|max:255',
            'moq'                  => 'nullable|string|max:255',
            'availability_status'  => 'nullable|string|max:255',
            'shipping_terms'       => 'nullable|string|max:255',
            'validity_period'      => 'nullable|string|max:255',
            'notes'                => 'nullable|string',
        ]);

        $inquiry->update($validatedData);

        return redirect()->route('crm-inquiry-view', ['id_inquiry' => $id_inquiry])
            ->with('success', 'Inquiry updated successfully!');
    }

    public function inquiry_batch_update(Request $request)
    {
        try {
            $inquiries = $request->input('inquiries', []);
            $updatedCount = 0;

            foreach ($inquiries as $inquiryData) {
                $inquiry = crm_inquiry::findOrFail($inquiryData['id']);
                
                $inquiry->update([
                    'price_information'   => $inquiryData['price_information'] ?? null,
                    'lead_time'           => $inquiryData['lead_time'] ?? null,
                    'moq'                 => $inquiryData['moq'] ?? null,
                    'availability_status' => $inquiryData['availability_status'] ?? null,
                    'shipping_terms'      => $inquiryData['shipping_terms'] ?? null,
                    'validity_period'     => $inquiryData['validity_period'] ?? null,
                    'status'              => 'Updated by Purchasing',
                ]);
                
                $updatedCount++;
            }

            return redirect()->back()->with('success', "{$updatedCount} supplier information(s) updated successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function get_inquiry_projects()
    {
        $projects = crm_inquiry::select('title')
            ->distinct()
            ->orderBy('title')
            ->get()
            ->pluck('title');

        return response()->json($projects);
    }

    public function get_inquiry_by_project($project_title)
    {
        $inquiries = crm_inquiry::where('title', $project_title)
            ->get();

        return response()->json($inquiries);
    }

    public function destroy()
    {
        //
    }
}
