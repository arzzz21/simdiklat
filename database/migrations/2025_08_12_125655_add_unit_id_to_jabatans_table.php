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
        Schema::table('jabatans', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->after('is_manajer');
            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jabatans', function (Blueprint $table) {
            //
        });
    }
};
