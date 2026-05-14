<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BanksTableSeeder extends Seeder
{
    private $banks = [
        'BCA',
        'BRI',
        'SEABANK',
        'MANDIRI'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->banks as $bank) {
            Bank::create([
                'name' => $bank,
                'logo' => 'logo.png'
            ]);
        }
    }
}
