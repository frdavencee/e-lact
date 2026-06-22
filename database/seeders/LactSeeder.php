<?php

namespace Database\Seeders;

use App\Models\Personel;
use Illuminate\Database\Seeder;

class LactSeeder extends Seeder
{
    public function run(): void
    {
        Personel::create([
            'nama' => 'Budi Santoso',
            'nik' => '19900101001',
            'jabatan' => 'WASPANG',
        ]);

        Personel::create([
            'nama' => 'Siti Rahayu',
            'nik' => '19900202002',
            'jabatan' => 'WASPANG',
        ]);
    }
}
