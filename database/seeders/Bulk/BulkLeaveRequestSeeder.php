<?php

namespace Database\Seeders\Bulk;

use App\Models\LeaveRequest;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkLeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            LeaveRequest::create([
                'employee_id' => 1,
                'start_date' => $i > 0 && $i < 30 ? date('Y-m-') . ($i > 9 ? $i : '0' . $i) : $faker->date(),
                'end_date' => $i > 0 && $i < 30 ? date('Y-m-') . ($i > 9 ? $i : '0' . $i) : $faker->date(),
                'reason' => $faker->sentence(),
                'status' => $faker->randomElement(['Waiting', 'Approved', 'Rejected']),
                'note_review' => $faker->sentence(),
                'file_attachment' => 'file-attachment-BTCR-534682.pdf'
            ]);
        }
    }
}
