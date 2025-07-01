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
        DB::statement("ALTER TABLE pengajuans MODIFY COLUMN status ENUM('diajukan', 'diterima', 'ditolak', 'terverifikasi', 'berkas_tidak_sesuai', 'selesai') NOT NULL DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pengajuans MODIFY COLUMN status ENUM('draft', 'diajukan', 'diterima', 'ditolak') NOT NULL DEFAULT 'draft'");
    }
};
