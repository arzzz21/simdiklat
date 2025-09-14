<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    protected $fillable = ['nama', 'kampus_id'];
    
    public function kampus() {
        return $this->belongsTo(Kampus::class);
    }
}
