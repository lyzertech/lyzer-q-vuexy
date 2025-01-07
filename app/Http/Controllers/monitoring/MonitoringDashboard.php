<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringDashboard extends Controller
{
    public function index()
    {
        return view('content.digitize.monitoring.monitoring-dashboard');
    }
}
