<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'jenis_program_id',
        'program_studi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan_admin',
    ];
    public function dosen()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisProgram()
    {
        return $this->belongsTo(JenisProgram::class, 'jenis_program_id');
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'pengajuan_mahasiswa');
    }

}
