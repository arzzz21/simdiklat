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
            $table->string('unit_magang')->nullable();
            $table->string('pembimbing_rumah_sakit')->nullable();
            $table->string('nip_pembimbing')->nullable();
            $table->string('jabatan_pembimbing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn([
                'unit_magang',
                'pembimbing_rumah_sakit',
                'nip_pembimbing',
                'jabatan_pembimbing',
            ]);
        });
    }
};
