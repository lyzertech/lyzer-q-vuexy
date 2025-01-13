<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CrmCustomer extends Controller
{
  public function index()
  {
    $total_customers = crm_customer::distinct('company')->count('company');
    // $new_customers = crm_customer::where('created_at', '>=', now()->subMonth())->count();
    $total_purchasing = crm_customer::count();
    $sales_distribution = crm_customer::select('sales', DB::raw('count(*) as total_customers'))
      ->groupBy('sales')
      ->get();
    $area_distribution = crm_customer::select('area', DB::raw('count(*) as total_customers'))
      ->groupBy('area')
      ->get();
    $area_distribution = DB::table('crm_customer')
      ->select('area', DB::raw('COUNT(*) as value'))
      ->groupBy('area')
      ->get()
      ->toArray();
    $sales_list = User::whereIn('role_id', [4, 5])->get();

    return view('content.digitize.crm.crm-customer', compact('total_customers', 'total_purchasing', 'sales_distribution', 'area_distribution', 'sales_list'));
  }
  public function customer_data()
  {
    $customer = crm_customer::all();

    // dd($customer);

    return DataTables::of($customer)
      ->editColumn('created_at', function ($customer) {
        return $customer->created_at->format('Y-m-d H:i');
      })
      ->addColumn('action', function ($customer) {
        // Define the action URLs for View, Edit, and Delete
        $showUrl = route('crm-customer-view', $customer->id_customer);
        $editUrl = route('crm-customer-edit', $customer->id_customer);
        $deleteUrl = route('crm-customer-destroy', $customer->id_customer);

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
                      <a href="' . $deleteUrl . '" class="dropdown-item text-danger delete-record">Delete</a>
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
    // dd($request->all());

    // Handle form submission logic here
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'sales' => 'required|string|max:255',
      // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed file types and size as needed
      'area' => 'required|max:255',
      'address' => 'required|max:255',
      'phonenumber' => 'required|max:255',
      'mobilephone' => 'required|max:255',
      'company' => 'required|max:255',
      'position' => 'required|max:255',
    ]);

    $yearOfJoin = Carbon::now()->year;
    $validatedData['id_customer'] = $yearOfJoin . 1234;

    // $validatedData['company'] = $request->input('company', "PT. LyZer-Tech");
    $validatedData['status'] = $request->input('status', 1);

    // Handle file upload
    // if ($request->hasFile('image')) {
    //     $imagePath = $request->file('image')->store('images', 'public');
    //     $validatedData['image'] = $imagePath;
    // } else {
    //     return redirect()->back()->withErrors(['image' => 'Image upload failed'])->withInput();
    // }

    // Create a new Customer instance
    $customer = new crm_customer([
      'id_customer' => $validatedData['id_customer'],
      'name' => $validatedData['name'],
      'email' => $validatedData['email'],
      'sales' => $validatedData['sales'],
      // 'image' => $validatedData['image'],
      'area' => $validatedData['area'],
      'address' => $validatedData['address'],
      'phonenumber' => $validatedData['phonenumber'],
      'mobilephone' => $validatedData['mobilephone'],
      'company' => $validatedData['company'],
      'position' => $validatedData['position'],
      'status' => $validatedData['status'],
    ]);

    $customer->save();

    return redirect('/crm/customer')->with('success', 'Form submitted successfully!');
  }
  public function customer_view(Request $request, $id_customer)
  {
    // dd($request);

    $customer = crm_customer::findOrFail($id_customer);

    // $crm_customer = crm_customer::findOrFail($crm_customer);

    return view('content.digitize.crm.crm-customer-view', compact('customer'));
  }
  public function customer_edit(Request $request, $id_customer)
  {
    // dd($request);

    $customer = crm_customer::findOrFail($id_customer);

    // $crm_customer = crm_customer::findOrFail($crm_customer);

    return view('content.digitize.crm.crm-customer-edit', compact('customer'));
  }
  public function destroy()
  {
    //
  }
}
