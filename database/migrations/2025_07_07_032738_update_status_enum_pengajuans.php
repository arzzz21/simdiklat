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
        DB::statement("ALTER TABLE pengajuans MODIFY status ENUM(
            'diajukan',
            'diterima',
            'berkas_tidak_sesuai',
            'terverifikasi',
            'invoice_diterbitkan',
            'menunggu_verifikasi_pembayaran',
            'selesai',
            'ditolak'
        ) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
