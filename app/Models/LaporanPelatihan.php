<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPelatihan extends Model
{
    protected $fillable = [
        'pelatihan_id', 'pegawai_id', 'ringkasan', 'rtl', 'file_laporan', 'file_surat_tugas'
    ];

    protected $casts = [
        'rtl' => 'array',
    ];

    public function pelatihan() {
        return $this->belongsTo(Pelatihan::class);
    }

    public function pegawai() {
        return $this->belongsTo(Pegawai::class);
    }
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
