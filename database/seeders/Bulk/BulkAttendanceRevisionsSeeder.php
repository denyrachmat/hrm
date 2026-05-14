<?php

namespace Database\Seeders\Bulk;

use App\Models\AttendanceRevision;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkAttendanceRevisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            AttendanceRevision::create([
                'employee_id' => 1,
                'date' => $i > 0 && $i < 30 ? date('Y-m-') . ($i > 9 ? $i : '0' . $i) : $faker->date(),
                'clock_in' => $faker->date('H:i'),
                'clock_out' => $faker->date('H:i'),
                'reason' => $faker->sentence(),
                'status' => $faker->randomElement(['Waiting', 'Approved', 'Rejected']),
                'note_review' => $faker->sentence(),
            ]);
        }
    }
}
