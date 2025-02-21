<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringDashboard extends Controller
{
    public function index()
    {
        $pageConfigs = ['menuCollapsed' => true];
        // $pageConfigs = ['myLayout' => 'front'];

        // Pass the filtered data to the view
        return view('content.digitize.monitoring.monitoring-dashboard', [
          'pageConfigs' => $pageConfigs
        ]);
    }
}
