<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class CrmDashboard extends Controller
{
    public function index()
    {
        return view('content.digitize.crm.crm-dashboard');
    }
}
