<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $month = date('m');
        $year = date('Y');
        for ($i = 1; $i <= 25; $i++) {
            if (checkdate(date('m'), $i, 2024)) {
                DB::table('attendances')->insert([
                    'employee_id' => 1,
                    'date' => $year . '-' . $month . '-' . ($i >= 10 ? $i : '0' . $i),
                    'clock_in' => '08:00',
                    'clock_istirahat' => '12:50',
                    'clock_out' => '17:00',
                    'latitude' => null,
                    'longitude' => null,
                    'file_attachment' => null,
                    'image_istirahat' => null,
                    'image_clock_out' => null,
                    'is_present' => 'Yes',
                    'description' => 'Tepat Waktu',
                    'activity' => null,
                    'point' => 5,
                    'meal_allowance' => 10000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
