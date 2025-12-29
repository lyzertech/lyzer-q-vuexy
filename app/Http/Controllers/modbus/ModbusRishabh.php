<?php

namespace App\Http\Controllers\modbus;

use App\Http\Controllers\Controller;
use App\Models\modbus\modbus_rishabh;
use Illuminate\Http\Request;

class ModbusRishabh extends Controller
{
    public function read_data($address, $count)
    {
        // Securely call the Python script and return JSON for AJAX use
        $folder = base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');
        $folderArg = escapeshellarg($folder);
        $addressArg = escapeshellarg((string)$address);
        $countArg = escapeshellarg((string)$count);

        $cmd = "cd $folderArg && python modbus_read_conMplus.py $addressArg $countArg 2>&1";
        $output = shell_exec($cmd);
        $data = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON from python script', 'raw' => $output], 500);
        }

        return response()->json($data ?: []);
    }

    public function rish_con_m_plus()
    {

      $cards = [
          ['title' => 'Parameter', 'address' => 6002, 'count' => 40],
          ['title' => 'Analog Output 1', 'address' => 6248, 'count' => 18],
          ['title' => 'Analog Output 2', 'address' => 6266, 'count' => 18],
          ['title' => 'Analog Output 3', 'address' => 6284, 'count' => 18],
          ['title' => 'Analog Output 4', 'address' => 6302, 'count' => 18],
      ];

      $results = [];

      foreach ($cards as $card) {
          $address = $card['address'];
          $count   = $card['count'];

          $folder = base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');
          $folderArg = escapeshellarg($folder);
          $addressArg = escapeshellarg((string)$address);
          $countArg = escapeshellarg((string)$count);

          $cmd = "cd $folderArg && python modbus_read_conMplus.py $addressArg $countArg 2>&1";

          $output = shell_exec($cmd);

          // Decode Python JSON (your Python script MUST return JSON)
          $json = json_decode($output, true);
          if (json_last_error() !== JSON_ERROR_NONE || !is_array($json)) {
              // Preserve `raw` output so we can surface it to user if needed
              $json = ['__error' => ['message' => 'Invalid JSON from python script', 'raw' => $output]];
          }

          $results[] = [
              'title' => $card['title'],
              'data'  => $json,
            ];
      }

      return view('content.digitize.modbus.rishabh.con-m-plus.read', compact('results'));
    }

    public function AO1()
    {
        $address = 6248;   // <-- add here
        $count   = 40;     // <-- add here

        $folder = base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');
        $folderArg = escapeshellarg($folder);
        $addressArg = escapeshellarg((string)$address);
        $countArg = escapeshellarg((string)$count);

        $cmd = "cd $folderArg && python modbus_read_conMplusAO1.py $addressArg $countArg 2>&1";

        $output = shell_exec($cmd);

        $data = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            $data = ['__error' => ['message' => 'Invalid JSON from python script', 'raw' => $output]];
        }

        return view('content.digitize.modbus.rishabh.con-m-plus.read', compact('data'));
    }

    public function rish_con_m_plus_write(Request $request)
    {
        // Base validation
        $rules = [
            'address' => 'required|integer',
            'value' => 'required'
        ];

        // If writing System Type (address 6002), require an integer selection 1..8
        if ((int)$request->address === 6002) {
            $rules['value'] = ['required', 'integer', 'in:1,2,3,4,5,6,7,8'];
        }
        // If writing Parameter Select fields, allow only keys defined in PARAM_SELECT_MAP
        elseif (in_array((int)$request->address, [6250,6268,6286,6304])) {
            // Allowed keys from PARAM_SELECT_MAP
            $allowed = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,23,26,28,30,31,33,35,84,85,86,87,89,90,91,92,100,101,102,127,128,129,131,150,151,152,153,154,156,158,159,160,161,162,164,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,184,185,186,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,208,209,210];
            $rules['value'] = ['required', 'integer', 'in:' . implode(',', $allowed)];
        }

        $request->validate($rules);

        $address = $request->address;
        $value   = $request->value;

        // Path to the script folder
        $folder = base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');

        // Escape shell args
        $addressArg = escapeshellarg((string)$address);
        $valueArg = escapeshellarg((string)$value);
        $folderArg = escapeshellarg($folder);

        // Build the command properly
        $cmd = "cd $folderArg && python modbus_write_conMplus.py $addressArg $valueArg 2>&1";

        // Execute
        $output = shell_exec($cmd);

        // Decode JSON
        $data = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            $data = ['status' => 'error', 'message' => 'Invalid JSON from python script', 'raw' => $output];
        }

        return back()->with('result', $data);
    }
}
