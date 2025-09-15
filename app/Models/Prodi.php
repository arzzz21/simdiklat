<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';
    protected $fillable = ['jenjang','nama', 'fakultas_id'];
    
    public function fakultas() {
        return $this->belongsTo(Fakultas::class);
    }
}
