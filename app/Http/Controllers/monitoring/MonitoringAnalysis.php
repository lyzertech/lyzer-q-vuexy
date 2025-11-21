<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_analysis;
use App\Models\monitoring\monitoring_acuvim;
use App\Models\monitoring\monitoring_device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringAnalysis extends Controller
{
  public function index()
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
      return view('content.digitize.monitoring.monitoring-analysis', [
        'allData' => $allData,
        'selectedDevices' => $selectedDevices,
        'pageConfigs' => $pageConfigs
      ]);
  }

  public function energy()
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
      return view('content.digitize.monitoring.monitoring-analysis-energy', [
        'allData' => $allData,
        'selectedDevices' => $selectedDevices,
        'pageConfigs' => $pageConfigs
      ]);
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
      return view('content.digitize.monitoring.monitoring-analysis-realtime', [
        'allData' => $allData,
        'selectedDevices' => $selectedDevices,
        'pageConfigs' => $pageConfigs
      ]);
  }

  public function powerquality()
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
      return view('content.digitize.monitoring.monitoring-analysis-powerquality', [
        'allData' => $allData,
        'selectedDevices' => $selectedDevices,
        'pageConfigs' => $pageConfigs
      ]);
  }

  public function analysis_getMonitoringTree()
  {
      // Fetch data from the monitoring_acuvim table
      // $data = DB::table('monitoring_devices')->get();
      $data = DB::table('monitoring_devices')
        ->orderBy('device_serial', 'asc')
        ->get();

      // Initialize tree structure
      $tree = [];

      foreach ($data as $row) {
          // Find or create gateway node
          if (!isset($tree[$row->facility])) {
              $tree[$row->facility] = [
                  'id' => 'facility' . $row->facility,
                  'text' => $row->facility,
                  'state' => ['opened' => false],
                  'type' => 'facility',
                  'children' => []
              ];
          }

          $deviceKey = $row->facility . '_' . $row->location;
          if (!isset($tree[$row->facility]['children'][$deviceKey])) {
              $tree[$row->facility]['children'][$deviceKey] = [
                  'id' => 'location' . $deviceKey,
                  'text' => $row->location,
                  'state' => ['opened' => false],
                  'type' => 'location',
                  'children' => []
              ];
          }

          // $leafNodeId = 'model_' . $row->device_name;
          $leafNodeId = 'model_' . $row->id_devices;
          // $leafNodeId = 'model_' . $row->facility . '_' . $row->location . '_' . $row->device_name;

          $existingLeafNodes = collect($tree[$row->facility]['children'][$deviceKey]['children'])
              ->pluck('id')
              ->toArray();

          if (!in_array($leafNodeId, $existingLeafNodes)) {
              $tree[$row->facility]['children'][$deviceKey]['children'][] = [
                  'id' => $leafNodeId,
                  'text' => $row->device_name . ' (' . $row->device_serial . ')',
                  'state' => ['opened' => false],
                  'type' => 'file'
              ];
          }
      }

      // Convert tree structure to jsTree-compatible JSON
      $treeJson = [];
      foreach ($tree as $gateway) {
          $gateway['children'] = array_values($gateway['children']); // Flatten children
          $treeJson[] = $gateway;
      }

      return response()->json($treeJson);
  }

  public function analysis_selectdata(Request $request)
  {
      // Decode the selected devices JSON from the hidden input

      $selectedDevices = $request->input('selectedDevices', '[]');
      // dd($selectedDevices);

      // Decode JSON into PHP array
      $devices = json_decode($selectedDevices, true);

      return redirect()->route('monitoring-datalog')->with('devices', $devices);
  }
}
