<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('berkas_pengajuans', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['menunggu', 'valid', 'invalid'])->default('menunggu');
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_pengajuans', function (Blueprint $table) {
            //
        });
    }
};
