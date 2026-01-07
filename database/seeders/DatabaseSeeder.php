<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN IT
        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@laporit.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'unit_kerja' => 'Tim IT',
        ]);

        // 2. Buat Akun TEKNISI
        User::create([
            'name' => 'Mas Teknisi',
            'email' => 'teknisi@laporit.com',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
            'unit_kerja' => 'Support Hardware',
        ]);

        // 3. Buat Akun USER BIASA (Karyawan)
        User::create([
            'name' => 'Mba Karyawan',
            'email' => 'user@laporit.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'unit_kerja' => 'Keuangan',
        ]);
    }
}