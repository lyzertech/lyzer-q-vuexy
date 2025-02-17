<?php

namespace App\Http\Controllers\shield;

use App\Http\Controllers\Controller;
use App\Models\shield\shield_insightcrm;
use App\Models\crm\crm_customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShieldInsightcrm extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'horizontal'];

        return view('content.lyzer.shield.project-insight#crm', ['pageConfigs' => $pageConfigs]);
    }
    public function crm_customer_data()
    {
        $customer = crm_customer::all();

        // dd($customer);

        return DataTables::of($customer)
            ->editColumn('created_at', function ($customer) {
                return $customer->created_at->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($customer) {
                // Define the action URLs for View, Edit, and Delete
                $showUrl = route('insight#crm-customer-view', $customer->id_customer);
                $editUrl = route('crm-customer-edit', $customer->id_customer);
                $deleteUrl = route('crm-customer-destroy', $customer->id_customer);

                // Return the action buttons HTML
                return '
        <a href="' . $showUrl . '" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
        <i class="ti ti-eye ti-md"></i>
        </a>
        ';
            })
            ->rawColumns(['action']) // Allow raw HTML in the action column
            ->make(true);
    }
    public function crm_customer_view(Request $request, $id_customer)
    {
        $pageConfigs = ['myLayout' => 'horizontal'];

        $customer = crm_customer::findOrFail($id_customer);

        // $crm_customer = crm_customer::findOrFail($crm_customer);

        return view('content.lyzer.shield.project-insight#crm#customer-view', ['pageConfigs' => $pageConfigs], compact('customer'));
    }
}
