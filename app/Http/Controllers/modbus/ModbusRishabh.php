<?php

namespace App\Http\Controllers\modbus;

use App\Http\Controllers\Controller;
use App\Models\modbus\modbus_rishabh;
use Illuminate\Http\Request;

class ModbusRishabh extends Controller
{
    public function read_data()
    {

        return view('content.digitize.modbus.rishabh.con-m-plus.read');
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


        // Full path to python (important!)
        $folder  = 'cd ' . base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');

        $cmd = "$folder && python modbus_read_conMplus.py $address $count 2>&1";

        $output = shell_exec($cmd);
        // dd($output);

        // Decode Python JSON (your Python script MUST return JSON)
        $json = json_decode($output, true);

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

        // Full path to python (important!)
        $folder  = 'cd ' . base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');

        $cmd = "$folder && python modbus_read_conMplusAO1.py $address $count 2>&1";

        $output = shell_exec($cmd);
        // dd($output);

        // Decode JSON from Python
        $data = json_decode($output, true);

        return view('content.digitize.modbus.rishabh.con-m-plus.read', compact('data'));
    }

    public function rish_con_m_plus_write(Request $request)
    {
        $address = $request->address;
        $value   = $request->value;

        // Path to the script folder
        $folder = base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');

        // Build the command properly
        $cmd = "cd \"$folder\" && python modbus_write_conMplus.py $address $value 2>&1";

        // Execute
        $output = shell_exec($cmd);

        // Decode JSON
        $data = json_decode($output, true);

        return back()->with('result', $data);
    }
}
