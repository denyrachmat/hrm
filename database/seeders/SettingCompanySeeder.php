<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'company_name' => 'Jaya Abadi Teknik',
            'app_name' => 'Application HRM',
            'phone' => '021-29126198',
            'address' => 'jl 123',
            'email_remainder_first' => 'saepulramdan244@gmail.com',
            'email_remainder_second' => 'saepulramdan244@gmail.com',
            'logo' => null,
            'start_clock_in' => '06:00',
            'start_clock_out_saturday' => '16:00',
            'start_clock_out' => '17:00',
            'late_absence' => 123,
        ]);
    }
}
