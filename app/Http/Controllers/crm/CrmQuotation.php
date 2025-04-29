<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrmQuotation extends Controller
{
  public function index()
  {


    return view('content.digitize.crm.crm-quotation'
      // , compact(
      //   'customer',
      //   'visit_reports',
      //   'sales_list',
      //   'total_visit_reports',
      //   'prospek_yes',
      //   'prospek_no',
      //   'companies'
      // )
    );
  }
}
