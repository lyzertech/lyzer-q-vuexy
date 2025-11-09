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

    public function getData(Request $request)
    {
        // $deviceName = $request->input('device_name', 'MCC 5 SS1');
        $deviceName = $request->input('device_name'); // ✅ no default fallback

        // ✅ 1. Default: Today
        $startDate = Carbon::today();
        $endDate = Carbon::tomorrow();

        // ✅ 2. If ?date=YYYY-MM-DD (single date)
        if ($request->has('date')) {
            $startDate = Carbon::parse($request->date)->startOfDay();
            $endDate = Carbon::parse($request->date)->endOfDay();
        }

        // ✅ 3. If custom range: ?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
        }

        // ✅ 4. If ?range=7days or ?range=this_week
        if ($request->range === '7days' || $request->range === 'this_week') {
            $startDate = Carbon::today()->subDays(6)->startOfDay(); // last 7 days including today
            $endDate = Carbon::today()->endOfDay();
        }

        // ✅ 5. Parameters (keep your existing logic)
        $parameters = $request->input('parameters', ['V12']);
            $allowed = [
                'Vnavg_V', 'Vlavg_V', 'Iavg_A', 'Psum_kW', 'Qsum_kvar', 'Ssum_kVA', 'PF',
                'V1', 'V2', 'V3', 'V12', 'V23', 'V31',
                'I1', 'I2', 'I3',
                'P1', 'P2', 'P3',
                'Q1', 'Q2', 'Q3',
                'S1', 'S2', 'S3',
                'PF1', 'PF2', 'PF3',
            ];
            $columns = array_intersect($parameters, $allowed);

        $select = array_merge(['Timestamp'], $columns);

        // ✅ 6. Dynamic query using selected date(s)
        $data = DB::table('monitoring_acuvim')
            ->select($select)
            ->where('device_name', $deviceName)
            ->whereBetween('Timestamp', [$startDate, $endDate])
            ->orderBy('Timestamp', 'asc')
            ->get();

        // ✅ 7. Format output
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
