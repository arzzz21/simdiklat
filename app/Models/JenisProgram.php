<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisProgram extends Model
{
    protected $table = 'jenis_programs';
    protected $fillable = ['nama', 'metode_biaya', 'biaya'];
}
