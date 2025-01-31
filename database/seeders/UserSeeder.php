<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dokter',
            'email' => 'dokter@example.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        User::create([
            'name' => 'Pasien',
            'email' => 'pasien@example.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        User::create([
            'name' => 'Pasien',
            'email' => 'pasien2@example.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);
    }
}
