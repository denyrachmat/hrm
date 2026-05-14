<?php

namespace Database\Seeders\Bulk;

use App\Models\Izinsakit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkIzinSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            Izinsakit::create([
                'employee_id' => 1,
                'date' => $i > 0 && $i < 30 ? date('Y-m-') . ($i > 9 ? $i : '0' . $i) : $faker->date(),
                'description' => $faker->randomElement(['Izin', 'Sakit']),
                'detailed_description' => $faker->sentence(),
                'status' => $faker->randomElement(['Waiting', 'Approved', 'Rejected']),
                'note_review' => $faker->sentence(),
            ]);
        }
    }
}
