<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
             [
                'nis' => '20251001',
                'name' => 'Alya Putri',
                'gender' => 'Female',
                'class' => 5,
                'birthdate' => '2013-04-12',
                'parent_name' => 'Siti Rahma',
                'contact_number' => '081234567890',
                'address' => 'Jl. Melati Raya No. 12, Jakarta',
                'status' => 'Active',
            ],
            [
                'nis' => '20251002',
                'name' => 'Bagas Pratama',
                'gender' => 'Male',
                'class' => 6,
                'birthdate' => '2012-11-03',
                'parent_name' => 'Budi Santoso',
                'contact_number' => '081298765432',
                'address' => 'Jl. Anggrek No. 5, Depok',
                'status' => 'Active',
            ],
            [
                'nis' => '20251003',
                'name' => 'Citra Ayu',
                'gender' => 'Female',
                'class' => 4,
                'birthdate' => '2014-06-20',
                'parent_name' => 'Nur Aisyah',
                'contact_number' => '082112345678',
                'address' => 'Jl. Dahlia No. 33, Bekasi',
                'status' => 'Transferred',
            ],
            [
                'nis' => '20251004',
                'name' => 'Davin Putra',
                'gender' => 'Male',
                'class' => 6,
                'birthdate' => '2012-09-18',
                'parent_name' => 'Hendra Putra',
                'contact_number' => '081345678912',
                'address' => 'Jl. Kenanga No. 22, Tangerang',
                'status' => 'Active',
            ],
            [
                'nis' => '20251005',
                'name' => 'Eka Wulandari',
                'gender' => 'Female',
                'class' => 6,
                'birthdate' => '2012-02-07',
                'parent_name' => 'Lina Wulandari',
                'contact_number' => '082134567891',
                'address' => 'Jl. Cemara No. 8, Jakarta Barat',
                'status' => 'Graduated',
            ],
        ];

        DB::table('students')->insert($students);
    }
}
