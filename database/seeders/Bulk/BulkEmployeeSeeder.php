<?php

namespace Database\Seeders\Bulk;

use App\Models\BranchOffice;
use App\Models\Department;
use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create('id_ID');

            Employee::create([
                'employee_id' => $faker->randomNumber(5),
                'employee_type' => $faker->randomElement(['Local', 'Expatriate']),
                'full_name' => $faker->name(),
                'email' => $faker->email(),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'date_of_birth' => $faker->date(),
                'martial_status' => $faker->randomElement(['TK0', 'TK1', 'TK2', 'TK3', 'K0', 'K1', 'K2', 'K3']),
                'id_type' => $faker->randomElement(['KTP', 'PASSPORT']),
                'national_id_no' => $faker->randomNumber(5),
                'start_contract_date' => $faker->date(),
                'end_contract_date' => $faker->date(),
                'job_position' => $faker->title(),
                'branch_office_id' => BranchOffice::inRandomOrder()->first()->id,
                'bpjs_tk_no' => $faker->randomNumber(5),
                'bpjs_health_no' => $faker->randomNumber(5),
                'tax_id' => $faker->randomNumber(5),
                'medical_insurance' => $faker->randomNumber(5),
                'work_status' => 'Active',
                'salary' => $faker->randomElement([1000000, 2000000, 3000000]),
                'kitas_no' => $faker->randomNumber(5),
                'kitas_validity' => $faker->date(),
                'address' => $faker->address(),
                'passport_no' => $faker->randomNumber(5),
                'passport_validity' => $faker->date(),
                'nationality' => $faker->countryCode(),
                'department_id' => Department::inRandomOrder()->first()->id,
                'use_gps_location' => 'No',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
