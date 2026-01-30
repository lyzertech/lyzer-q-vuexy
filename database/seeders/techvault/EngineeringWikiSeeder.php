<?php

namespace Database\Seeders\techvault;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EngineeringWikiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('engineering_wikis')->insert([
            [
                'title' => 'Device Overheating Issue',
                'category' => 'issue',
                'brand' => 'Siemens',
                'device_type' => 'PLC',
                'model' => 'S7-1200',
                'serial_number' => 'SN123456',
                'firmware_version' => '1.2.3',
                'hardware_version' => 'A1',
                'symptom' => 'Device overheats after 2 hours of operation.',
                'root_cause' => 'Insufficient cooling in panel.',
                'solution' => 'Install additional cooling fan.',
                'action_taken' => 'Fan installed, temperature monitored.',
                'status' => 'monitoring',
                'priority' => 'high',
                'reference_doc' => 'cooling_guidelines.pdf',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Firmware Update Notice',
                'category' => 'update',
                'brand' => 'Schneider',
                'device_type' => 'HMI',
                'model' => 'Magelis',
                'serial_number' => 'SN654321',
                'firmware_version' => '2.0.0',
                'hardware_version' => 'B2',
                'symptom' => null,
                'root_cause' => null,
                'solution' => 'Update firmware to latest version.',
                'action_taken' => 'Firmware updated successfully.',
                'status' => 'solved',
                'priority' => 'medium',
                'reference_doc' => 'firmware_update_2026.pdf',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Routine Maintenance Note',
                'category' => 'note',
                'brand' => 'ABB',
                'device_type' => 'Drive',
                'model' => 'ACS880',
                'serial_number' => null,
                'firmware_version' => null,
                'hardware_version' => null,
                'symptom' => null,
                'root_cause' => null,
                'solution' => null,
                'action_taken' => 'Checked and cleaned air filters.',
                'status' => 'closed',
                'priority' => 'low',
                'reference_doc' => null,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
