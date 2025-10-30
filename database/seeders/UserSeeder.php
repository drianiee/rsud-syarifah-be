<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin RSUD Syarifah',
            'email' => 'admin@rsudsyarifah.test',
            'password' => Hash::make('password'), 
        ]);

        User::create([
            'name' => 'Petugas Parkir',
            'email' => 'petugas@rsudsyarifah.test',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Operator SKM',
            'email' => 'skm@rsudsyarifah.test',
            'password' => Hash::make('12345678'),
        ]);
    }
}
