<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\crm_calendar;
use App\Models\crm\crm_visit_report;
use App\Models\crm\crm_visit_report_sep;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CrmCalendar extends Controller
{
    public function calendar_index()
    {
        return view(
            'content.digitize.crm.crm-calendar',
            // compact('total_customers', 'total_purchasing_aii', 'total_purchasing_sep', 'sales_distribution', 'area_distribution', 'sales_list', 'company_list')
        );
    }
    public function calendar_data()
    {
        $events = crm_visit_report::select(
            'id_visit_report as id',
            'sales',
            'customer_name',
            'purpose',
            DB::raw("CONCAT(visit_date, ' ', visit_time) as start") // Merging date and time
        )
            ->union(
                crm_visit_report_sep::select(
                    'id_visit_report as id',
                    'sales',
                    'customer_name',
                    'purpose',
                    DB::raw("CONCAT(visit_date, ' ', visit_time) as start") // Merging date and time
                )
            )
            ->get()
            ->map(function ($event) {
                return [
                    'id'    => $event->id,
                    'title' => $event->sales . ' - ' . $event->customer_name . ' (' . $event->purpose . ')',
                    'start' => Carbon::parse($event->start)->toDateTimeString() // Ensuring proper timestamp format
                    // 'color' => '#08FFFF'
                ];
            });

        return response()->json($events);
    }
}
