<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;

class Pegawai extends Model
{
    protected $fillable = ['nama', 'nip', 'unit_id', 'jabatan_id', 'user_id'];
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isManajer()
    {
        return $this->jabatan && $this->jabatan->is_manajer;
    }

    public function pelatihans()
    {
        return $this->belongsToMany(Pelatihan::class, 'pelatihan_pegawai')->withTimestamps();
    }

    public function ihtParticipants()
    {
        return $this->hasMany(IhtParticipant::class);
    }

    public function ihts()
    {
        return $this->hasMany(IhtParticipant::class);
    }
    
}
