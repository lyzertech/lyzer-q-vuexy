<?php

namespace App\Http\Controllers\modbus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Device: Accuenergy AcuDC240
class ModbusAccuenergy extends Controller
{
    /**
     * AJAX endpoint — read data and return JSON for live refresh.
     */
    public function read_data($address, $count)
    {
        $folder     = base_path('resources/views/content/digitize/modbus/accuenergy/Modbus');
        $folderArg  = escapeshellarg($folder);
        $addressArg = escapeshellarg((string) $address);
        $countArg   = escapeshellarg((string) $count);

        $cmd    = "cd $folderArg && python modbus_read_accuenergy.py $addressArg $countArg 2>&1";
        $output = shell_exec($cmd);
        $data   = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON from python script', 'raw' => $output], 500);
        }

        return response()->json($data ?: []);
    }

    /**
     * Page load — run Python, render Blade view with grouped results.
     */
    public function accuenergy_read()
    {
        // Date/Time registers: 644 (Year) through 649 (Second) = 6 × 16-bit integers
        $cards = [
            ['title' => 'AcuDC240 — Date & Time (Registers 644–649)', 'address' => 644, 'count' => 6],
        ];

        $results = [];

        foreach ($cards as $card) {
            $address = $card['address'];
            $count   = $card['count'];

            $folder     = base_path('resources/views/content/digitize/modbus/accuenergy/Modbus');
            $folderArg  = escapeshellarg($folder);
            $addressArg = escapeshellarg((string) $address);
            $countArg   = escapeshellarg((string) $count);

            $cmd    = "cd $folderArg && python modbus_read_accuenergy.py $addressArg $countArg 2>&1";
            $output = shell_exec($cmd);

            $json = json_decode($output, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($json)) {
                $json = ['__error' => ['message' => 'Invalid JSON from python script', 'raw' => $output]];
            }

            $results[] = [
                'title' => $card['title'],
                'data'  => $json,
            ];
        }

        return view('content.digitize.modbus.accuenergy.read', compact('results'));
    }

    /**
     * Write a float value to a Modbus register via Python script.
     */
    public function accuenergy_write(Request $request)
    {
        $request->validate([
            'address' => 'required|integer',
            'value'   => 'required|numeric',
        ]);

        $address = $request->address;
        $value   = $request->value;

        $folder     = base_path('resources/views/content/digitize/modbus/accuenergy/Modbus');
        $addressArg = escapeshellarg((string) $address);
        $valueArg   = escapeshellarg((string) $value);
        $folderArg  = escapeshellarg($folder);

        $cmd    = "cd $folderArg && python modbus_write_accuenergy.py $addressArg $valueArg 2>&1";
        $output = shell_exec($cmd);

        $data = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            $data = ['status' => 'error', 'message' => 'Invalid JSON from python script', 'raw' => $output];
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($data);
        }

        return back()->with('result', $data);
    }

    /**
     * Sync PC server time → write Year/Month/Day/Hour/Minute/Second to registers 644–649.
     */
    public function sync_time()
    {
        $now = now('Asia/Jakarta'); // hardcoded GMT+7 — avoids any config/env cache issues

        $registers = [
            644 => (int) $now->year,
            645 => (int) $now->month,
            646 => (int) $now->day,
            647 => (int) $now->hour,
            648 => (int) $now->minute,
            649 => (int) $now->second,
        ];

        $folder    = base_path('resources/views/content/digitize/modbus/accuenergy/Modbus');
        $folderArg = escapeshellarg($folder);

        $results = [];
        $allOk   = true;

        foreach ($registers as $address => $value) {
            $addressArg = escapeshellarg((string) $address);
            $valueArg   = escapeshellarg((string) $value);

            $cmd    = "cd $folderArg && python modbus_write_accuenergy.py $addressArg $valueArg 2>&1";
            $output = shell_exec($cmd);

            $data = json_decode($output, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
                $data = ['status' => 'error', 'message' => 'Invalid JSON', 'raw' => $output];
            }

            $results[$address] = $data;
            if (!isset($data['status']) || $data['status'] !== 'ok') {
                $allOk = false;
            }
        }

        return response()->json([
            'status'    => $allOk ? 'ok' : 'partial',
            'message'   => $allOk
                ? 'Time synced: ' . $now->format('Y-m-d H:i:s')
                : 'Partial write — check device connection',
            'synced_to' => $now->format('Y-m-d H:i:s'),
            'details'   => $results,
        ]);
    }
}
