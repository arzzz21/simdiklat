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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->foreignId('diverifikasi_oleh')->nullable()->after('status')->constrained('users');
            $table->timestamp('tanggal_verifikasi')->nullable()->after('diverifikasi_oleh');
            $table->text('alasan_ditolak')->nullable()->after('tanggal_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            //
        });
    }
};
