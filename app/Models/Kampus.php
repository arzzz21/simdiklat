<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    protected $table = 'kampus';
    public function up()
    {
        Schema::create('kampus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }
}
