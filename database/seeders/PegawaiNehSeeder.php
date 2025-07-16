<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiNehSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::create(['nama' => 'Siti', 'unit_id' => 1, 'jabatan_id' => 1]);
        Pegawai::create(['nama' => 'Ibu Lestari', 'unit_id' => 1, 'jabatan_id' => 2]);

        Pegawai::create(['nama' => 'Fajar', 'unit_id' => 2, 'jabatan_id' => 3]);
        Pegawai::create(['nama' => 'Dian', 'unit_id' => 2, 'jabatan_id' => 4]);
    }
}
