<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\crm_customer;
use Yajra\DataTables\Facades\DataTables;

class CrmCustomer extends Controller
{
  public function index()
  {
    return view('content.digitize.crm-customer');
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
        $showUrl = route('crm-customer-view', $customer->id_customer);
        $editUrl = route('crm-customer-edit', $customer->id_customer);
        $deleteUrl = route('crm-customer-destroy', $customer->id_customer);
        return '
                  <a href="' . $showUrl . '" class="btn btn-xs btn-primary">View</a>
                  ';
        // <a href="' . $editUrl . '" class="btn btn-xs btn-primary">Edit</a>
        // <form action="' . $deleteUrl . '" method="POST" style="display: inline-block;">
        //     ' . csrf_field() . '
        //     ' . method_field('DELETE') . '
        //     <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
        // </form>
      })
      ->rawColumns(['action']) // Allow raw HTML in the action column
      ->make(true);
  }
  public function view()
  {
    // 
  }
  public function edit()
  {
    // 
  }
  public function destroy()
  {
    // 
  }
}
