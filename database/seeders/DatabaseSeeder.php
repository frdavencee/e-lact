<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@telkom.co.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nik' => 'ADMIN001',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@telkom.co.id'],
            [
                'name' => 'Petugas Telkom',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'nik' => 'PTG001',
                'email_verified_at' => now(),
            ]
        );
    }
}
