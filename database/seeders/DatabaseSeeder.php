<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(SettingCompanySeeder::class);
        $this->call(GpslocationSeeder::class);
        $this->call(CategorynewsSeeder::class);
        $this->call(BranchOfficeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EmployeeHasEarningTableSeeder::class);
        $this->call(EmployeeHasDeductionTableSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(IzinsakitSeeder::class);
    }
}
