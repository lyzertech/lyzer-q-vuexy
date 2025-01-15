<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Analytics extends Controller
{
  public function index()
  {
    return Redirect::to('/crm/customer');
    // return view('content.dashboard.dashboards-analytics');
  }
}
