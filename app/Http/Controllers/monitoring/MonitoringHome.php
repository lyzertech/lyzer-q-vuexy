<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_home;
use Illuminate\Http\Request;

class MonitoringHome extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.digitize.monitoring.monitoring-home'
        // , compact(
          // 'data',
          // 'pageConfigs'
        // )
        );
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
    public function show(monitoring_home $monitoring_home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(monitoring_home $monitoring_home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, monitoring_home $monitoring_home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(monitoring_home $monitoring_home)
    {
        //
    }
}
