<?php

namespace Database\Seeders;

use Database\Seeders\Bulk\BulkAttendanceRevisionsSeeder;
use Database\Seeders\Bulk\BulkAttendanceSeeder;
use Database\Seeders\Bulk\BulkDepartmentSeeder;
use Database\Seeders\Bulk\BulkEmployeeSeeder;
use Database\Seeders\Bulk\BulkIzinSakitSeeder;
use Database\Seeders\Bulk\BulkLeaveRequestSeeder;
use Database\Seeders\Bulk\BulkNewsSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            BulkDepartmentSeeder::class,
            BulkEmployeeSeeder::class,
            BulkAttendanceSeeder::class,
            BulkAttendanceRevisionsSeeder::class,
            BulkIzinSakitSeeder::class,
            BulkLeaveRequestSeeder::class,
            BulkNewsSeeder::class,
        ]);
    }
}
