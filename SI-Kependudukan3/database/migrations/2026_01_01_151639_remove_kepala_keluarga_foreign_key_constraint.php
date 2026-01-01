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
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['kepala_keluarga_nik']);
        });

        // Recreate foreign key without restrict, making it nullable-friendly
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            $table->foreign('kepala_keluarga_nik')
                  ->references('nik')
                  ->on('penduduk')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            // Drop the new foreign key
            $table->dropForeign(['kepala_keluarga_nik']);
        });

        // Restore original foreign key with restrict
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            $table->foreign('kepala_keluarga_nik')
                  ->references('nik')
                  ->on('penduduk')
                  ->onDelete('restrict');
        });
    }
};
