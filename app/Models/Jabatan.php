<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['nama', 'is_manajer'];
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
    public function getIsManajerAttribute()
    {
        return $this->attributes['is_manajer'] ?? false;
    }

}
