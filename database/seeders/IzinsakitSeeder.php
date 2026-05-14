<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IzinsakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('izinsakits')->insert([
            'employee_id' => 1,
            'date' => date('Y-m-d'),
            'description' => 'Izin',
            'detailed_description' => 'Ada keperluan keluarga mendesak',
            'status' => 'Waiting',
            'file_attachment' => null,
            'note_review' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
