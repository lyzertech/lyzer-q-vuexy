<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_project;
use Illuminate\Http\Request;

class CrmProject extends Controller
{
  public function index()
  {
    return view('content.digitize.crm.crm-project');
  }
}
