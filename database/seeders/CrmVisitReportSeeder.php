<?php

namespace Database\Seeders;

use App\Models\crm\crm_visit_report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrmVisitReportSeeder extends Seeder
{
    public function run(): void
    {
        crm_visit_report::factory(100)->create();
    }
}
