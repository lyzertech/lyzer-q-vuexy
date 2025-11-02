<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataController extends Controller
{
    public function latest()
    {
        // Fetch latest 10 rows (or adjust as you wish)
        $data = DB::table('monitoring_acuvim')
            ->orderBy('Timestamp', 'desc')
            ->limit(1)
            ->get();

        // Optionally clean/transform field names before sending
        return response()->json($data);
    }

    public function getTodayVoltage()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Fetch data for today only
        $data = DB::table('monitoring_acuvim')
          ->select('Timestamp', 'V12')
          ->where('device_name', 'MAINT. BUILDING')
          ->whereBetween('Timestamp', [$today, $tomorrow])
          ->orderBy('Timestamp', 'asc')
          ->get();

        // Convert to proper format for ECharts
        $result = $data->map(function ($row) {
            return [
                'time' => Carbon::parse($row->Timestamp)->format('Y-m-d H:i'),
                'voltage' => (float) $row->V12,
            ];
        });

        return response()->json($result);
    }

    public function getTodayData(Request $request)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Parameters to fetch (default to voltage if none provided)
        $parameters = $request->input('parameters', ['V12']);

        // Validate allowed columns to prevent SQL injection
        $allowed = [
          'Vnavg_V', 'Vlavg_V', 'Iavg_A', 'Psum_kW', 'Qsum_kvar', 'Ssum_kVA', 'PF',

          'V1', 'V2', 'V3',
          'V12', 'V23', 'V31',
          'I1', 'I2', 'I3',
          'P1', 'P2', 'P3',
          'Q1', 'Q2', 'Q3',
          'S1', 'S2', 'S3',
          'PF1', 'PF2', 'PF3',
        ];
        $columns = array_intersect($parameters, $allowed);

        if (empty($columns)) {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }

        // Always include timestamp
        $select = array_merge(['Timestamp'], $columns);

        // Fetch data
        $data = DB::table('monitoring_acuvim')
            ->select($select)
            ->where('device_name', 'Device-01')
            ->whereBetween('Timestamp', [$today, $tomorrow])
            ->orderBy('Timestamp', 'asc')
            ->get();

        // Format data
        $result = $data->map(function ($row) use ($columns) {
            $entry = ['time' => Carbon::parse($row->Timestamp)->format('Y-m-d H:i')];
            foreach ($columns as $col) {
                $entry[$col] = (float) $row->$col;
            }
            return $entry;
        });

        return response()->json($result);
    }
}
