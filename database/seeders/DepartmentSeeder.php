<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    private $departments = [
        [
            'code' => 'DEP-001',
            'department_name' => 'HRD&GA',
            'default_payroll_type' => 'monthly'
        ],
        [
            'code' => 'DEP-002',
            'department_name' => 'Finance & Accounting',
            'default_payroll_type' => 'monthly'
        ],
        [
            'code' => 'DEP-003',
            'department_name' => 'Marketing',
            'default_payroll_type' => 'monthly'
        ],
        [
            'code' => 'DEP-004',
            'department_name' => 'Sparepart & Service',
            'default_payroll_type' => 'monthly'
        ],
        [
            'code' => 'DEP-005',
            'department_name' => 'Genset',
            'default_payroll_type' => 'monthly'
        ],
        [
            'code' => 'DEP-006',
            'department_name' => 'Forklift',
            'default_payroll_type' => 'daily'
        ],
        [
            'code' => 'DEP-007',
            'department_name' => 'Alat Berat',
            'default_payroll_type' => 'monthly'
        ],
        [
            'code' => 'DEP-008',
            'department_name' => 'Supir',
            'default_payroll_type' => 'Daily'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->departments as $department) {
            Department::create($department);
        }
    }
}
