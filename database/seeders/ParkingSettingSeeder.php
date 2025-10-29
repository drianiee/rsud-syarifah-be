<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingSetting;

class ParkingSettingSeeder extends Seeder
{
    public function run(): void
    {
        ParkingSetting::query()->firstOrCreate(
            ['id' => 1],
            ['r2_price' => 2000, 'r4_price' => 5000] 
        );
    }
}