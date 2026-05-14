<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            'employee_id' => '123',
            'full_name' => 'Muhammad Saeful Ramdan',
            'email' => 'saepulramdan244@gmail.com',
            'gender' => 'Male',
            'date_of_birth' => '2023-03-23',
            'martial_status' => 'Single',
            'id_type' => 'KTP',
            'national_id_no' => '123456789',
            'start_contract_date' => '2023-03-23',
            'end_contract_date' => '2025-03-23',
            'job_position' => 'IT Manager',
            'branch_office_id' => 1,
            'bpjs_tk_no' => '1111111111111',
            'bpjs_health_no' => '222222222222',
            'tax_id' => '3333333333',
            'medical_insurance' => '9999999999999',
            'work_status' => 'Active',
            'currency' => 'IDR',
            'address' => 'Bogor',
            'department_id' => 1,
            'use_gps_location' => 'No',
            'bank_id' => Bank::first()->id,
            'bank_account_name' => 'Muhammad Saeful Ramdan',
            'bank_account_number' => '33033303',
            'payroll_type' => 'monthly_and_daily',
            'salary' => 2000000,
            'daily_salary' => 200000,
            'meal_allowance' => 50000,
            'craft_incentives' => 200000,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
