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
        Schema::table('laporan_pelatihans', function (Blueprint $table) {
            $table->string('catatan')->nullable()->before('status');
            $table->foreignId('diverifikasi_oleh')->nullable()->after('status')->constrained('users');
            $table->timestamp('tanggal_verifikasi')->nullable()->after('diverifikasi_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
