<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KependudukanSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Pendidikan (Data Master)
        $pendidikan = [
            ['id_pendidikan' => 'P01', 'jenjang' => 'Tidak Sekolah'],
            ['id_pendidikan' => 'P02', 'jenjang' => 'SD Sederajat'],
            ['id_pendidikan' => 'P03', 'jenjang' => 'SMP Sederajat'],
            ['id_pendidikan' => 'P04', 'jenjang' => 'SMA Sederajat'],
            ['id_pendidikan' => 'P05', 'jenjang' => 'Diploma'],
            ['id_pendidikan' => 'P06', 'jenjang' => 'S1'],
            ['id_pendidikan' => 'P07', 'jenjang' => 'S2'],
            ['id_pendidikan' => 'P08', 'jenjang' => 'S3'],
        ];
        DB::table('pendidikan')->insert($pendidikan);

        // Seed Pekerjaan (Data Master)
        $pekerjaan = [
            ['id_pekerjaan' => 'J01', 'nama_pekerjaan' => 'Belum/Tidak Bekerja'],
            ['id_pekerjaan' => 'J02', 'nama_pekerjaan' => 'Pelajar/Mahasiswa'],
            ['id_pekerjaan' => 'J03', 'nama_pekerjaan' => 'Pegawai Negeri Sipil'],
            ['id_pekerjaan' => 'J04', 'nama_pekerjaan' => 'Karyawan Swasta'],
            ['id_pekerjaan' => 'J05', 'nama_pekerjaan' => 'Wiraswasta'],
            ['id_pekerjaan' => 'J06', 'nama_pekerjaan' => 'Petani'],
            ['id_pekerjaan' => 'J07', 'nama_pekerjaan' => 'Ibu Rumah Tangga'],
        ];
        DB::table('pekerjaan')->insert($pekerjaan);

        // Seed Organisasi Masyarakat (Data Master)
        $organisasi = [
            ['id_organisasi' => 'ORG01', 'nama_organisasi' => 'Karang Taruna', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG02', 'nama_organisasi' => 'PKK Desa', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG03', 'nama_organisasi' => 'Kelompok Tani Jaya', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG04', 'nama_organisasi' => 'Posyandu Melati', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG05', 'nama_organisasi' => 'Paguyuban RT', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('organisasi_masyarakat')->insert($organisasi);

        $this->command->info('Data master berhasil ditambahkan. Database siap digunakan tanpa data dummy.');
    }
}
