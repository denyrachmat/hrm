<?php

namespace Database\Seeders\Bulk;

use App\Models\Attendance;
use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            Attendance::create([
                'employee_id' => 1,
                'date' => $i > 0 && $i < 30 ? date('Y-m-') . ($i > 9 ? $i : '0' . $i) : $faker->date(),
                'clock_in' => $faker->date('H:i'),
                'clock_out' => $faker->date('H:i'),
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude(),
                'file_attachment' => null,
                'image_clock_out' => null,
                'is_present' => $faker->randomElement(['Yes', 'No']),
                'description' => $faker->randomElement(['Tepat Waktu', 'Terlambat']),
                'activity' => null,
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            Attendance::create([
                'employee_id' => Employee::inRandomOrder()->first()->id,
                'date' => date('Y-m-d'),
                'clock_in' => $faker->date('H:i'),
                'clock_out' => $faker->date('H:i'),
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude(),
                'file_attachment' => null,
                'image_clock_out' => null,
                'is_present' => $faker->randomElement(['Yes', 'No']),
                'description' => $faker->randomElement(['Tepat Waktu', 'Terlambat']),
                'activity' => null,
            ]);
        }
    }
}
