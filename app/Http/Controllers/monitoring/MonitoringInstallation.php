<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_installation;
use App\Models\monitoring\monitoring_facility;
use App\Models\monitoring\monitoring_device;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MonitoringInstallation extends Controller
{
  public function index()
  {
    $facility_list = monitoring_facility::pluck('facilities');

    return view('content.digitize.monitoring.monitoring-installation', compact('facility_list'));
  }

  public function installation_facility_data()
  {
    $monitoring_facility = monitoring_facility::all();
    // dd($monitoring_facility);
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

  public function installation_device_data()
  {
    $monitoring_device = monitoring_device::all();
    // dd($monitoring_device);
    return DataTables::of($monitoring_device)->make(true);
  }

  public function installation_device_create(Request $request)
  {
    // Validate the request data
    $validatedData = $request->validate([
      'facility' => 'required',
      'device_name' => 'required',
      'device_model' => 'required',
      'device_serial' => 'required',
      'location' => 'required',
    ]);

    // Save the data to the database
    monitoring_device::create($validatedData);

    // Redirect with success message
    return redirect('/monitoring/installation')->with('success', 'Form submitted successfully!');
  }
}
