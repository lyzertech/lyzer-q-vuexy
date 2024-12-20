<?php

namespace Database\Seeders;

use App\Models\crm\crm_customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrmCustomerSeeder extends Seeder
{
    public function run(): void
    {
        crm_customer::factory(100)->create();
    }
}
