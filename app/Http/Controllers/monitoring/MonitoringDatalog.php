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
        $allData = monitoring_acuvim::all();
        // dd($allData);

        return view('content.digitize.monitoring.monitoring-datalog', compact('allData'));
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

    public function filterData(Request $request)
    {
        $selectedNodes = $request->input('selectedNodes', []);

        if (empty($selectedNodes)) {
            // If no filters are applied, return all data
            return response()->json(monitoring_acuvim::all());
        }

        // Filter the data based on the selected nodes
        $serials = array_map(function ($node) {
            $parts = explode('_', $node); // Assuming nodes are in the format 'model_Model_DeviceSerial'
            return end($parts); // Get the serial
        }, $selectedNodes);

        $filteredData = monitoring_acuvim::whereIn('device_serial', $serials)->get();

        return response()->json($filteredData);
    }
}
