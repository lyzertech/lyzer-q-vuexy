<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_purchase_request;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CrmPurchaseOrder extends Controller
{
    public function index()
    {
        return view('content.digitize.crm.crm-purchase-order');
    }

    public function purchase_order_data()
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
}
