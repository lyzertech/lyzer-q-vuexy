<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_installation;
use App\Models\monitoring\monitoring_facility;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MonitoringInstallation extends Controller
{
  public function index()
  {

    return view('content.digitize.monitoring.monitoring-installation');
  }

  public function installation_facility_data()
  {
      $monitoring_facility = monitoring_facility::all();

      return DataTables::of($monitoring_facility)->make(true);
  }

  public function installation_facility_create(Request $request)
  {
    // dd($request->all());

    // Handle form submission logic here
    $validatedData = $request->validate([
      // 'organization' => 'required',
      'facilities' => 'required',
      'type' => 'required',
      'description' => 'required',
      'street_address' => 'required',
      'city' => 'required',
      'province' => 'required',
      'country' => 'required',
      'postal_code' => 'required',
      'timezone' => 'required',
    ]);

    // Create a new Facility instance
    $facility = new monitoring_facility([
      // 'organization' => $validatedData['organization'],
      'facilities' => $validatedData['facilities'],
      'type' => ucfirst(strtolower($validatedData['type'])),
      'description' => $validatedData['description'],
      'street_address' => $validatedData['street_address'],
      'city' => $validatedData['city'],
      'province' => $validatedData['province'],
      'country' => $validatedData['country'],
      'postal_code' => $validatedData['postal_code'],
      'timezone' => $validatedData['timezone'],
    ]);

    $facility->save();

    return redirect('/monitoring/installation')->with('success', 'Form submitted successfully!');
  }
}
