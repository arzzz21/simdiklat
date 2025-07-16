<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Jabatan;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unit1 = Unit::create(['nama' => 'Keperawatan']);
        $unit2 = Unit::create(['nama' => 'Keuangan']);

        $j1 = Jabatan::create(['nama' => 'Perawat', 'is_manajer' => false]);
        $j2 = Jabatan::create(['nama' => 'Manajer Keperawatan', 'is_manajer' => true]);

        $j3 = Jabatan::create(['nama' => 'Staf Keuangan', 'is_manajer' => false]);
        $j4 = Jabatan::create(['nama' => 'Manajer Keuangan', 'is_manajer' => true]);

        Pegawai::create(['nama' => 'Siti', 'unit_id' => $unit1->id, 'jabatan_id' => $j1->id]);
        Pegawai::create(['nama' => 'Ibu Lestari', 'unit_id' => $unit1->id, 'jabatan_id' => $j2->id]);

        Pegawai::create(['nama' => 'Fajar', 'unit_id' => $unit2->id, 'jabatan_id' => $j3->id]);
        Pegawai::create(['nama' => 'Dian', 'unit_id' => $unit2->id, 'jabatan_id' => $j4->id]);
    }
}
