<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_customer;
use App\Models\crm\crm_visit_report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\DataTables\Facades\DataTables;

class CrmVisitReport extends Controller
{
  use SoftDeletes;

  public function index()
  {
    $customer = crm_customer::all();

    return view('content.digitize.crm-visit-report', compact('customer'));
  }
  public function visit_report_data()
  {
    $visit_report = crm_visit_report::all();

    // dd($visit_report);

    return DataTables::of($visit_report)
      ->editColumn('created_at', function ($visit_report) {
        return $visit_report->created_at->format('Y-m-d H:i');
      })
      ->addColumn('action', function ($visit_report) {
        // Define the action URLs for View, Edit, and Delete
        $showUrl = route('crm-visit-report-view', $visit_report->id_visit_report);
        $editUrl = route('crm-visit-report-edit', $visit_report->id_visit_report);
        $deleteUrl = route('crm-visit-report-destroy', $visit_report->id_visit_report);

        // Return the action buttons HTML
        return '
              <div class="d-inline-block">
                  <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="ti ti-dots-vertical ti-md"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end m-0">
                      <li><a href="' . $showUrl . '" class="dropdown-item">Details</a></li>
                      <div class="dropdown-divider"></div>
                      <li>
                          <a href="javascript:;" 
                            data-url="' . $deleteUrl . '" 
                            class="dropdown-item text-danger delete-record"
                            data-csrf-token="' . csrf_token() . '">
                            Delete
                          </a>
                      </li>
                  </ul>
              </div>
              <a href="' . $editUrl . '" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
                  <i class="ti ti-pencil ti-md"></i>
              </a>
          ';
      })
      ->rawColumns(['action']) // Allow raw HTML in the action column
      ->make(true);
  }
  public function create(Request $request)
  {
    // $request['status'] = $request->input('status', 'Planned');
    $request['contact_number'] = $request->input('password', '12345');

    crm_visit_report::create($request->only([
      'customer_name',
      'location',
      'contact_person',
      'contact_number',
      'visit_date',
      'visit_time',
      'purpose',
    ]));

    return back()->with('success', 'CRMVisit added successfully!');
  }
  public function visit_report_view($crm_visit_report)
  {
    // dd($crm_visit_report);
    $crm_visit_report = crm_visit_report::findOrFail($crm_visit_report);

    // dd($crm_visit_report);
    return view('content.digitize.crm-visit-report-view', compact('crm_visit_report'));
  }
  public function edit()
  {
    //
  }
  public function visit_report_destroy($id_visit_report)
  {
    $delete = crm_visit_report::find($id_visit_report);
    dd($id_visit_report);

    if ($delete) {
      $delete->delete();
      return redirect()->back()->with('success', 'User deleted successfully.');
    }

    return redirect()->back()->with('error', 'User not found.');
  }
}
