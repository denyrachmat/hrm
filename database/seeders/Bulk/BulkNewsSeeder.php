<?php

namespace Database\Seeders\Bulk;

use App\Models\News;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            News::create([
                'categorynews_id' => 1,
                'thumbnail' => null,
                'user_id' => 1,
                'date' => date('Y-m-d H:i:s'),
                'title' => $faker->sentence(4),
                'description' => $faker->paragraph(),
            ]);
        }
    }
}
