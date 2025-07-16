<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama'];
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class);
    }
}
