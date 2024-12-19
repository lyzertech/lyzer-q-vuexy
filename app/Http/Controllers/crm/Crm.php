<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Crm extends Controller
{
  public function dashboard()
  {
    return view('content.digitize.crm-dashboard');
  }
  public function customer()
  {
    return view('content.digitize.crm-customer');
  }
}
