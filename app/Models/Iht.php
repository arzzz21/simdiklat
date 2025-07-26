<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iht extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'deskripsi',
        'tempat',
        'instruktur',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_materi',
        'file_dokumentasi',
    ];

    public function participants()
    {
        return $this->hasMany(IhtParticipant::class);
    }
    public function pesertas()
    {
        return $this->hasMany(IhtParticipant::class);
    }

}
