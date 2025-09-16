<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    public function user()
    {
        return $this->belongsTo(User::class)->with('kampus');
    }

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

    public function prodi()
    {
        return $this->belongsToMany(Prodi::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPengajuan::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }


}
