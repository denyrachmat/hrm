<?php

namespace Database\Seeders\Bulk;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BulkDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $faler = Factory::create();

            DB::table('departments')->insert([
                'department_name' => $faler->title(),
            ]);
        }
    }
}
