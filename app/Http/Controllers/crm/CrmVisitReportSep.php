<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_customer;
use App\Models\crm\crm_visit_report_sep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\DataTables\Facades\DataTables;

class CrmVisitReportSep extends Controller
{
  use SoftDeletes;

  public function index()
  {
    $customer = crm_customer::all();

    $selectedSales = request()->input('sales'); // e.g. 'John Doe'
    $monthFrom = request()->input('month_from');       // e.g. '04'
    $monthTo = request()->input('month_to');           // e.g. '07'
    $yearFrom = request()->input('year_from');
    $yearTo = request()->input('year_to');

    $startDate = null;
    $endDate = null;

    if ($monthFrom && $monthTo) {
      $startDate = Carbon::createFromDate($yearFrom, $monthFrom, 1)->startOfMonth();
      $endDate = Carbon::createFromDate($yearTo, $monthTo, 1)->endOfMonth();

      // Optional: swap if user selects From > To
      if ($startDate->gt($endDate)) {
          [$startDate, $endDate] = [$endDate, $startDate];
      }
    }

    $customOrder = ['Bambang Tri', 'Rizky', 'Eka', 'Setia'];
    $visit_reports = crm_visit_report_sep::select('sales', DB::raw('count(*) as total_visits'))
      ->whereNotIn('status', ['Cancelled', 'Deleted']) // Exclude both 'Cancelled' and 'Deleted' statuses
      ->when($selectedSales, function ($query, $selectedSales) {
        return $query->where('sales', $selectedSales);
      })
      ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
        return $query->whereBetween('visit_date', [$startDate, $endDate]);
      })
      ->groupBy('sales')
      ->get()
      ->sortBy(function ($item) use ($customOrder) {
          return array_search($item->sales, $customOrder);
      })
      ->values();

    $sales_list = User::where('role_id', 5)->get();
    $total_visit_reports = crm_visit_report_sep::whereNotIn('status', ['Cancelled', 'Deleted'])
    ->when($selectedSales, function ($query, $selectedSales) {
        return $query->where('sales', $selectedSales);
    })
    ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
        return $query->whereBetween('visit_date', [$startDate, $endDate]);
    })
    ->count(); // ← Use count here instead of get
    $prospek_yes = crm_visit_report_sep::where('prospek', 1)
    ->when($selectedSales, function ($query, $selectedSales) {
      return $query->where('sales', $selectedSales);
    })
    ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
        return $query->whereBetween('visit_date', [$startDate, $endDate]);
    })
    ->count();
    $prospek_no = crm_visit_report_sep::where('prospek', 0)->count();

    $statuses = ['completed', 'checked', 'reviewed', 'submitted', 'planned', 'cancelled'];
    $counts = [];

    foreach ($statuses as $status) {
        $counts[$status] = crm_visit_report_sep::where('status', $status)
            ->when($selectedSales, fn($query) => $query->where('sales', $selectedSales))
            ->when($startDate && $endDate, fn($query) => $query->whereBetween('visit_date', [$startDate, $endDate]))
            ->count();
    }

    // Access with:
    $completed = $counts['completed'];
    $checked = $counts['checked'];
    $reviewed = $counts['reviewed'];
    $submitted = $counts['submitted'];
    $planned = $counts['planned'];
    $cancelled = $counts['cancelled'];

    // dd($submitted);

    $companies = crm_customer::select('company')
      ->distinct()
      ->orderBy('company', 'asc') // Sort in ascending order
      ->pluck('company');

    return view('content.digitize.crm.crm-visit-report-sep', compact(
      'customer',
      'visit_reports',
      'sales_list',
      'total_visit_reports',
      'prospek_yes',
      'prospek_no',
      'companies',
      'completed',
      'checked',
      'reviewed',
      'submitted',
      'planned',
      'cancelled',
    ));
  }
  public function visit_report_dataa()
  {
    $visit_report = crm_visit_report_sep::where('status', '!=', 'deleted')->get();

    // dd($visit_report);

    return DataTables::of($visit_report)
      ->editColumn('created_at', function ($visit_report) {
        return $visit_report->created_at->format('Y-m-d H:i');
      })
      ->addColumn('action', function ($visit_report) {
        // Define the action URLs for View, Edit, and Delete
        $showUrl = route('crm-visit-report-sep-view', $visit_report->id_visit_report);
        $editUrl = route('crm-visit-report-sep-edit', $visit_report->id_visit_report);
        $deleteUrl = route('crm-visit-report-sep-destroy', $visit_report->id_visit_report);

        return '
              <a href="' . $showUrl . '" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
                  <i class="ti ti-pencil ti-md"></i>
              </a>
          ';
      })
      ->rawColumns(['action']) // Allow raw HTML in the action column
      ->make(true);
  }
  public function visit_report_data()
  {
    $selectedSales = request()->input('sales'); // e.g. 'John Doe'
    $monthFrom = request()->input('month_from');       // e.g. '04'
    $monthTo = request()->input('month_to');           // e.g. '07'
    $yearFrom = request()->input('year_from');
    $yearTo = request()->input('year_to');

    $startDate = null;
    $endDate = null;

    if ($monthFrom && $monthTo) {
      $startDate = Carbon::createFromDate($yearFrom, $monthFrom, 1)->startOfMonth();
      $endDate = Carbon::createFromDate($yearTo, $monthTo, 1)->endOfMonth();

      // Optional: swap if user selects From > To
      if ($startDate->gt($endDate)) {
          [$startDate, $endDate] = [$endDate, $startDate];
      }
    }

    $visit_report = crm_visit_report_sep::where('status', '!=', 'deleted')
    ->when($selectedSales, function ($query, $selectedSales) {
        return $query->where('sales', $selectedSales);
    })
    ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
      return $query->whereBetween('visit_date', [$startDate, $endDate]);
    })
    ->get();

    return DataTables::of($visit_report)
      ->editColumn('created_at', function ($visit_report) {
        return $visit_report->created_at->format('Y-m-d H:i');
      })
      ->addColumn('action', function ($visit_report) {
        // Define the action URLs for View, Edit, and Delete
        $showUrl = route('crm-visit-report-sep-view', $visit_report->id_visit_report);
        $editUrl = route('crm-visit-report-sep-edit', $visit_report->id_visit_report);
        $deleteUrl = route('crm-visit-report-sep-destroy', $visit_report->id_visit_report);

        return '
              <a href="' . $showUrl . '" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
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
    $request['contact_number'] = Auth::user()->name;

    crm_visit_report_sep::create($request->only([
      'customer_name',
      'sales',
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
    $crm_visit_report = crm_visit_report_sep::findOrFail($crm_visit_report);
    // dd($crm_visit_report);

    // dd($crm_visit_report);
    return view('content.digitize.crm.crm-visit-report-sep-view', compact('crm_visit_report'));
  }
  public function visit_report_edit(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      // 'customer_name' => 'required|string|max:255',
      // 'sales' => 'required|string|max:255',
      // 'location' => 'required|string|max:255',
      // 'contact_person' => 'required|string|max:255',
      // 'contact_number' => 'nullable|string|max:20',
      // 'visit_date' => 'required|date',
      // 'visit_time' => 'required|string|max:10',
      // 'purpose' => 'required|string|max:1000',
      'notes' => 'nullable|string|max:2000',
      'customer_feedback' => 'nullable|string|max:2000',
      'next_steps' => 'nullable|string|max:1000',
      'follow_up_date' => 'nullable|date',
      'status' => 'nullable|string|max:50',
      'prospek' => 'nullable|string|max:50',
      // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
    ]);


    // Set the status to "Completed"
    switch ($request->prospek) {
        case 0:
            $validatedData['status'] = 'Completed';
            break;
        case 1:
            $validatedData['status'] = 'In Progress';
            break;
        case 2:
            $validatedData['status'] = 'Cancelled';
            break;
        default:
            $validatedData['status'] = 'In Progress'; // Optional: Handle unexpected values
    }

    // Handle file upload
    // if ($request->hasFile('image')) {
    //     $imagePath = $request->file('image')->store('visit_reports', 'public');
    //     $validatedData['image'] = $imagePath;
    // } else {
    //     $validatedData['image'] = $visitReport->image; // Retain the existing image if no new one is uploaded
    // }

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return back()->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_cancel(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'status' => 'nullable|string|max:50',
      'prospek' => 'nullable|string|max:50',
    ]);

    // Set the status to "Cancelled"
    $validatedData['status'] = 'Cancelled';
    $validatedData['prospek'] = '2';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return redirect()->route('crm-visit-report-sep')->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_submit(Request $request, $id_visit_report)
  {
    // dd($request->prospek);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    // $validatedData = $request->validate([
    //   'notes' => 'nullable|string|max:2000',
    //   'customer_feedback' => 'nullable|string|max:2000',
    //   'next_steps' => 'nullable|string|max:1000',
    //   'follow_up_date' => 'nullable|date',
    //   'status' => 'nullable|string|max:50',
    //   'prospek' => 'nullable|string|max:50',
    // ]);

    // Set the status to "In Progress"
    $validatedData['status'] = ($request->prospek == 0) ? 'Submitted' : 'In Progress';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return back()->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_ackmanager(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'ack_manager' => 'nullable|string|max:2000',
    ]);

    // Set the status to "Submitted"
    $validatedData['status'] = 'Submitted';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return back()->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_ackdirector(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'ack_director' => 'nullable|string|max:2000',
    ]);

    // Set the status to "Checked"
    $validatedData['status'] = 'Checked';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return back()->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_ackpresdir(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'ack_presdir' => 'nullable|string|max:2000',
    ]);

    // Set the status to "Acknowledge"
    $validatedData['status'] = 'Acknowledge';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return back()->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_response(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'response' => 'nullable|string|max:2000',
    ]);

    // Set the status to "Completed"
    $validatedData['status'] = 'Completed';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return back()->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_followup(Request $request, $id_visit_report)
  {
    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'follow_up_date_status' => 'nullable|string|max:50',
    ]);

    // Set the follow_up_date_status to "Completed"
    $validatedData['follow_up_date_status'] = '1';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return redirect()->route('crm-visit-report-sep')->with('success', 'CRM Visit updated successfully!');
  }
  public function visit_report_destroy($id_visit_report)
  {
    $delete = crm_visit_report_sep::find($id_visit_report);
    dd($id_visit_report);

    if ($delete) {
      $delete->delete();
      return redirect()->back()->with('success', 'User deleted successfully.');
    }

    return redirect()->back()->with('error', 'User not found.');
  }
  public function visit_report_delete(Request $request, $id_visit_report)
  {
    // dd($request);

    // Find the existing visit report by ID
    $visitReport = crm_visit_report_sep::findOrFail($id_visit_report);

    // Validate incoming request data
    $validatedData = $request->validate([
      'status' => 'nullable|string|max:50',
      // 'prospek' => 'nullable|string|max:50',
    ]);

    // Set the status to "Cancelled"
    $validatedData['status'] = 'Deleted';
    // $validatedData['prospek'] = '2';

    // Update the visit report with validated data
    $visitReport->update($validatedData);

    // Redirect back with success message
    return redirect()->route('crm-visit-report-sep')->with('success', 'CRM Visit updated successfully!');
  }
}
