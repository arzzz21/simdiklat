<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $fillable = ['nama', 'tempat', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'file_info'];

    public function peserta()
    {
        return $this->belongsToMany(Pegawai::class, 'pelatihan_pegawai')->withTimestamps();
    }
}
