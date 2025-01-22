<?php

namespace App\Http\Controllers\monitoring;

use App\Http\Controllers\Controller;
use App\Models\monitoring\monitoring_datalog;
use App\Models\monitoring\monitoring_acuvim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringDatalog extends Controller
{
    public function index()
    {
        // Retrieve the devices passed in the session
        $selectedDevices = session('devices', []);

        // Check if any devices were selected
        if (!empty($selectedDevices)) {
            // Fetch data for the selected devices
            $allData = monitoring_acuvim::whereIn(
                DB::raw("CONCAT(device_model, ' (', device_serial, ')')"),
                $selectedDevices
            )->get();
        } else {
            // If no devices were selected, fetch all data
            $allData = collect(); // or simply $allData = [];
        }

        // Pass the filtered data to the view
        return view('content.digitize.monitoring.monitoring-datalog', compact('allData', 'selectedDevices'));
    }

    public function datalog_getMonitoringTree()
    {
        // Fetch data from the monitoring_acuvim table
        $data = DB::table('monitoring_acuvim')->get();

        // Initialize tree structure
        $tree = [];

        foreach ($data as $row) {
            // Find or create gateway node
            if (!isset($tree[$row->gateway_name])) {
                $tree[$row->gateway_name] = [
                    'id' => 'gateway_' . $row->gateway_name,
                    'text' => $row->gateway_name,
                    'state' => ['opened' => true], // Opened by default
                    'children' => []
                ];
            }

            // Find or create device node under gateway
            $deviceKey = $row->gateway_name . '_' . $row->device_name;
            if (!isset($tree[$row->gateway_name]['children'][$deviceKey])) {
                $tree[$row->gateway_name]['children'][$deviceKey] = [
                    'id' => 'device_' . $deviceKey,
                    'text' => $row->device_name,
                    'state' => ['opened' => true], // Opened by default
                    'children' => []
                ];
            }

            // Avoid duplicate leaf nodes by checking if it already exists
            $leafNodeId = 'model_' . $row->device_model . '_' . $row->device_serial;
            $existingLeafNodes = collect($tree[$row->gateway_name]['children'][$deviceKey]['children'])
                ->pluck('id')
                ->toArray();

            if (!in_array($leafNodeId, $existingLeafNodes)) {
                // Add device_model(device_serial) as a unique leaf node
                $tree[$row->gateway_name]['children'][$deviceKey]['children'][] = [
                    'id' => $leafNodeId,
                    'text' => $row->device_model . ' (' . $row->device_serial . ')',
                    'state' => ['opened' => true], // Opened by default
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

    public function datalog_selectdata(Request $request)
    {
        // Decode the selected devices JSON from the hidden input

        $selectedDevices = $request->input('selectedDevices', '[]');
        // dd($selectedDevices);

        // Decode JSON into PHP array
        $devices = json_decode($selectedDevices, true);

        return redirect()->route('monitoring-datalog')->with('devices', $devices);
    }
}
