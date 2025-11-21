<?php

namespace App\Http\Controllers\modbus;

use App\Http\Controllers\Controller;
use App\Models\modbus\modbus_rishabh;
use Illuminate\Http\Request;

class ModbusRishabh extends Controller
{
    public function read_data()
    {


        return view('content.digitize.modbus.rishabh.con-m-plus.read', ['data' => $output]);
    }

    public function read()
    {
        $address = 6002;   // <-- add here
        $count   = 40;     // <-- add here

        // Full path to python (important!)
        $folder  = 'cd ' . base_path('resources/views/content/digitize/modbus/rishabh/con-m-plus/Modbus');

        $cmd = "$folder && python modbus_read_conMplus.py $address $count 2>&1";

        $output = shell_exec($cmd);
        // dd($output);

        // Decode JSON from Python
        $data = json_decode($output, true);

        return view('content.digitize.modbus.rishabh.con-m-plus.read', compact('data'));
    }

    public function write(Request $request)
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
