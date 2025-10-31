<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringDashboard extends Controller
{
    public function index()
    {
        // $data = DB::table('monitoring_acuvim')
        //       ->orderBy('Timestamp', 'desc')
        //       ->limit(6)
        //       ->get();
        $pageConfigs = ['menuCollapsed' => true];
        // $pageConfigs = ['myLayout' => 'front'];

        // Pass the filtered data to the view
        return view('content.digitize.monitoring.monitoring-dashboard', compact(
          // 'data',
          'pageConfigs'
        ));
    }

    public function dashboard()
    {
        $data = DB::table('monitoring_acuvim')
            ->orderBy('Timestamp', 'desc')
            ->limit(6)
            ->get();

        return view('dashboard', compact('data'));
    }

}
