<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->string('nik', 20)->primary();
            $table->string('no_kk', 20);
            $table->string('id_pekerjaan', 10);
            $table->string('id_pendidikan', 10);
            $table->string('nama_lengkap', 100);
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status_hidup', ['Hidup', 'Meninggal'])->default('Hidup');
            $table->text('alamat_ktp');
            $table->string('rt_ktp', 10);
            $table->string('rw_ktp', 10);
            $table->timestamps();

            $table->foreign('no_kk')->references('no_kk')->on('kartu_keluarga')->onDelete('restrict');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')->onDelete('restrict');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('pendidikan')->onDelete('restrict');
        });

        // Update foreign key untuk kepala keluarga setelah tabel penduduk dibuat
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            $table->foreign('kepala_keluarga_nik')->references('nik')->on('penduduk')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            $table->dropForeign(['kepala_keluarga_nik']);
        });
        Schema::dropIfExists('penduduk');
    }
};
