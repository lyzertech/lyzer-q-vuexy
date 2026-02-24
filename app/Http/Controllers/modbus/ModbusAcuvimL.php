<?php

namespace App\Http\Controllers\modbus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Device: Accuenergy Acuvim L-V4
class ModbusAcuvimL extends Controller
{
    /**
     * AJAX endpoint — read data and return JSON for live refresh.
     */
    public function read_data($address, $count)
    {
        $folder     = base_path('resources/views/content/digitize/modbus/acuviml-v4/Modbus');
        $folderArg  = escapeshellarg($folder);
        $addressArg = escapeshellarg((string) $address);
        $countArg   = escapeshellarg((string) $count);

        $cmd    = "cd $folderArg && python modbus_read_acuviml_v4.py $addressArg $countArg 2>&1";
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
    public function acuviml_read()
    {
        // Populate cards from the Acuvim L-V4 datasheet.
        // Example placeholder — update address & count once register map is known.
        $cards = [
            ['title' => 'Acuvim L-V4 — Date & Time (Registers 4159–4165)', 'address' => 4159, 'count' => 7],
        ];

        $results = [];

        foreach ($cards as $card) {
            $address = $card['address'];
            $count   = $card['count'];

            $folder     = base_path('resources/views/content/digitize/modbus/acuviml-v4/Modbus');
            $folderArg  = escapeshellarg($folder);
            $addressArg = escapeshellarg((string) $address);
            $countArg   = escapeshellarg((string) $count);

            $cmd    = "cd $folderArg && python modbus_read_acuviml_v4.py $addressArg $countArg 2>&1";
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

        return view('content.digitize.modbus.acuviml-v4.read', compact('results'));
    }

    /**
     * Write a value to a Modbus register via Python script.
     */
    public function acuviml_write(Request $request)
    {
        $request->validate([
            'address' => 'required|integer',
            'value'   => 'required|numeric',
        ]);

        $address = $request->address;
        $value   = $request->value;

        $folder     = base_path('resources/views/content/digitize/modbus/acuviml-v4/Modbus');
        $addressArg = escapeshellarg((string) $address);
        $valueArg   = escapeshellarg((string) $value);
        $folderArg  = escapeshellarg($folder);

        $cmd    = "cd $folderArg && python modbus_write_acuviml_v4.py $addressArg $valueArg 2>&1";
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
     * Sync PC server time → write Week/Year/Month/Day/Hour/Minute/Second to registers 4159–4165.
     */
    public function sync_time()
    {
        $now = now('Asia/Jakarta');

        $registers = [
            // 4159 (Week) is read-only — device auto-calculates it from date
            4160 => (int) $now->year,
            4161 => (int) $now->month,
            4162 => (int) $now->day,
            4163 => (int) $now->hour,
            4164 => (int) $now->minute,
            4165 => (int) $now->second,
        ];

        $folder    = base_path('resources/views/content/digitize/modbus/acuviml-v4/Modbus');
        $folderArg = escapeshellarg($folder);

        $results = [];
        $allOk   = true;

        foreach ($registers as $address => $value) {
            $addressArg = escapeshellarg((string) $address);
            $valueArg   = escapeshellarg((string) $value);

            $cmd    = "cd $folderArg && python modbus_write_acuviml_v4.py $addressArg $valueArg 2>&1";
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
