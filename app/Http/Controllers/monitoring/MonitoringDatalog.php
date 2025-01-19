<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_datalog;
use App\Models\monitoring\monitoring_acuvim;
use Illuminate\Http\Request;

class MonitoringDatalog extends Controller
{
    public function index()
    {
        $allData = monitoring_acuvim::all();
        // dd($allData);

        return view('content.digitize.monitoring.monitoring-datalog', compact('allData'));
    }
}
