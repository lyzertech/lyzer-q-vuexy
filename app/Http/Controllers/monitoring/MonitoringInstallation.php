<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_installation;
use App\Models\monitoring\monitoring_facility;
use App\Models\monitoring\monitoring_device;
use App\Models\monitoring\monitoring_acuvim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MonitoringInstallation extends Controller
{
  public function index()
  {
      $pageConfigs = ['menuCollapsed' => true];

      // Ensure facility_list is an array if needed
      $facility_list = monitoring_facility::pluck('facilities')->toArray();
      $device_list = Monitoring_Device::whereNull('facility')->get();

      return view('content.digitize.monitoring.monitoring-installation', [
          'facility_list' => $facility_list,
          'device_list' => $device_list,
          'pageConfigs' => $pageConfigs
      ]);
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

  public function installation_device_data_not_listed()
  {
    $devices = monitoring_acuvim::select(
                'monitoring_acuvim.device_name',
                'monitoring_acuvim.gateway_serial',
                'monitoring_acuvim.device_model',
                'monitoring_acuvim.device_serial',
                'monitoring_acuvim.device_online'
            )
            ->join(DB::raw('(SELECT device_name, device_serial, MAX(Timestamp) as latest
                            FROM monitoring_acuvim
                            GROUP BY device_name, device_serial) as latest_data'),
                function($join) {
                    $join->on('monitoring_acuvim.device_name', '=', 'latest_data.device_name')
                        ->on('monitoring_acuvim.device_serial', '=', 'latest_data.device_serial')
                        ->on('monitoring_acuvim.Timestamp', '=', 'latest_data.latest');
                })
            ->whereNotIn('monitoring_acuvim.device_serial', function($query) {
                $query->select('device_serial')->from('monitoring_devices');
            });
            // ->get();

    return DataTables::of($devices)->make(true);
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

  public function installation_device_bulkFacility(Request $request)
  {
      $validated = $request->validate([
          'facility' => 'required|string',
          'location' => 'required|string',
          'devices'  => 'required|array|min:1',
      ]);

      $facility = $validated['facility'];
      $location = $validated['location'];
      $devices  = $validated['devices'];

      // Example: update each device's facility & location
      foreach ($devices as $deviceName) {
          monitoring_device::where('device_name', $deviceName)
              ->update([
                  'facility' => $facility,
                  'location' => $location,
                  'updated_at' => now(),
              ]);
      }

      return redirect()->back()->with('success', 'Devices updated successfully!');
  }
}
