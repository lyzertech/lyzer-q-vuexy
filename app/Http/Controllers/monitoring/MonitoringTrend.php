<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_trend;
use Illuminate\Http\Request;

class MonitoringTrend extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function realtime()
    {
        $pageConfigs = ['menuCollapsed' => true];

        // Retrieve the devices passed in the session
        $selectedDevices = session('devices', []);

        // Check if any devices were selected
        if (!empty($selectedDevices)) {
            // Fetch data for the selected devices
            $allData = monitoring_acuvim::whereIn('device_name', $selectedDevices)->get();
        } else {
            // If no devices were selected, fetch all data
            $allData = collect(); // or $allData = [];
        }

        // Pass the filtered data to the view
        return view('content.digitize.monitoring.monitoring-trend', [
          'allData' => $allData,
          'selectedDevices' => $selectedDevices,
          'pageConfigs' => $pageConfigs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(monitoring_trend $monitoring_trend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(monitoring_trend $monitoring_trend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, monitoring_trend $monitoring_trend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(monitoring_trend $monitoring_trend)
    {
        //
    }
}
