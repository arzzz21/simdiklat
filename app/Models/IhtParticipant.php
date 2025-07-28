<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IhtParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'iht_id',
        'pegawai_id',
        'hadir',
        'evaluasi',
        'sertifikat_path',
    ];

    public function iht()
    {
        return $this->belongsTo(Iht::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

}
