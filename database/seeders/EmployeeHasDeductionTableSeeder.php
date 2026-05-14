<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeHasDeduction;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeHasDeductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 2; $i++) {
            $faker = Factory::create();
            EmployeeHasDeduction::create([
                'employee_id' => Employee::first()->id,
                'name' => $faker->word(),
                'amount' => $faker->randomElement([100000, 150000, 200000, 50000]),
            ]);
        }
    }
}
