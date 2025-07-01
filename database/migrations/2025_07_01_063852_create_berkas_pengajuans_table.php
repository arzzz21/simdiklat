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
        Schema::create('berkas_pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained()->onDelete('cascade');
            $table->string('nama_berkas'); // misalnya: "Surat Pengantar"
            $table->string('file'); // path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_pengajuans');
    }
};
