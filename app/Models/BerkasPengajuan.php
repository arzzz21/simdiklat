<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPengajuan extends Model
{
    protected $fillable = ['pengajuan_id', 'nama_berkas', 'file'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
