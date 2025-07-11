<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'lama_magang',
        'biaya_per_lama',
        'total',
        'status',
        'bukti_pembayaran',
    ];
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
