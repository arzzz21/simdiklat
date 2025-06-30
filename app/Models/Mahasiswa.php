<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['user_id', 'kampus_id', 'nama', 'nim', 'prodi', 'no_hp'];

    public function kampus() {
        return $this->belongsTo(Kampus::class);
    }
    public function pengajuans()
    {
        return $this->belongsToMany(Pengajuan::class, 'pengajuan_mahasiswa');
    }

}
