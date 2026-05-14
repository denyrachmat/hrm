<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert([
            'categorynews_id' => 1,
            'thumbnail' => null,
            'user_id' => 1,
            'date' => date('Y-m-d H:i:s'),
            'title' => 'ini title',
            'description' => 'ini description',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'file_attachment' => null,
        ]);
    }
}
