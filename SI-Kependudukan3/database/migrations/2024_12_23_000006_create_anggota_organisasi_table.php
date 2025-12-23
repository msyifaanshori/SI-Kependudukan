<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('id_organisasi', 20);
            $table->string('nik', 20);
            $table->timestamps();

            $table->foreign('id_organisasi')->references('id_organisasi')->on('organisasi_masyarakat')->onDelete('cascade');
            $table->foreign('nik')->references('nik')->on('penduduk')->onDelete('cascade');
            
            $table->unique(['id_organisasi', 'nik']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_organisasi');
    }
};
