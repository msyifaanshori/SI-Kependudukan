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
        Schema::table('penduduk', function (Blueprint $table) {
            $table->enum('status_hubungan', ['KEPALA_KELUARGA', 'ISTRI', 'SUAMI', 'ANAK', 'CUCU', 'ORANG_TUA', 'MERTUA', 'MENANTU', 'LAINNYA'])->default('ANAK')->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn('status_hubungan');
        });
    }
};
