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
        Schema::create('laporan_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained()->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->text('ringkasan')->nullable();
            $table->json('rtl')->nullable(); // array poin-poin rencana tindak lanjut
            $table->string('file_laporan')->nullable();
            $table->string('file_surat_tugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pelatihans');
    }
};
