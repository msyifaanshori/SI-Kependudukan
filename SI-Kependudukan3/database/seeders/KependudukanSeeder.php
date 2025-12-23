<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KependudukanSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Pendidikan
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

        // Seed Pekerjaan
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

        // Seed Kartu Keluarga
        $kartuKeluarga = [
            ['no_kk' => '3201231010100001', 'kepala_keluarga_nik' => null, 'alamat' => 'Jl. Merdeka No. 1', 'rt' => '001', 'rw' => '001'],
            ['no_kk' => '3201230101120002', 'kepala_keluarga_nik' => null, 'alamat' => 'Jl. Pahlawan No. 10', 'rt' => '002', 'rw' => '001'],
            ['no_kk' => '3201231506150003', 'kepala_keluarga_nik' => null, 'alamat' => 'Jl. Tani Makmur No. 5', 'rt' => '003', 'rw' => '002'],
        ];
        DB::table('kartu_keluarga')->insert($kartuKeluarga);

        // Seed Penduduk
        $penduduk = [
            ['nik' => '3201231010800001', 'no_kk' => '3201231010100001', 'id_pekerjaan' => 'J05', 'id_pendidikan' => 'P06', 'nama_lengkap' => 'Budi Santoso', 'tgl_lahir' => '1980-10-10', 'jenis_kelamin' => 'L', 'status_hidup' => 'Hidup', 'alamat_ktp' => 'Jl. Merdeka No. 1', 'rt_ktp' => '001', 'rw_ktp' => '001'],
            ['nik' => '3201235505820002', 'no_kk' => '3201231010100001', 'id_pekerjaan' => 'J07', 'id_pendidikan' => 'P04', 'nama_lengkap' => 'Siti Aminah', 'tgl_lahir' => '1982-05-15', 'jenis_kelamin' => 'P', 'status_hidup' => 'Hidup', 'alamat_ktp' => 'Jl. Merdeka No. 1', 'rt_ktp' => '001', 'rw_ktp' => '001'],
            ['nik' => '3201232008050001', 'no_kk' => '3201231010100001', 'id_pekerjaan' => 'J02', 'id_pendidikan' => 'P03', 'nama_lengkap' => 'Rian Santoso', 'tgl_lahir' => '2005-08-20', 'jenis_kelamin' => 'L', 'status_hidup' => 'Hidup', 'alamat_ktp' => 'Jl. Merdeka No. 1', 'rt_ktp' => '001', 'rw_ktp' => '001'],
            ['nik' => '3201230101750003', 'no_kk' => '3201230101120002', 'id_pekerjaan' => 'J03', 'id_pendidikan' => 'P07', 'nama_lengkap' => 'Agus Wijaya', 'tgl_lahir' => '1975-01-01', 'jenis_kelamin' => 'L', 'status_hidup' => 'Hidup', 'alamat_ktp' => 'Jl. Pahlawan No. 10', 'rt_ktp' => '002', 'rw_ktp' => '001'],
            ['nik' => '3201234502780004', 'no_kk' => '3201230101120002', 'id_pekerjaan' => 'J04', 'id_pendidikan' => 'P06', 'nama_lengkap' => 'Dewi Lestari', 'tgl_lahir' => '1978-02-05', 'jenis_kelamin' => 'P', 'status_hidup' => 'Hidup', 'alamat_ktp' => 'Jl. Pahlawan No. 10', 'rt_ktp' => '002', 'rw_ktp' => '001'],
            ['nik' => '3201231506900005', 'no_kk' => '3201231506150003', 'id_pekerjaan' => 'J06', 'id_pendidikan' => 'P02', 'nama_lengkap' => 'Joko Susilo', 'tgl_lahir' => '1990-06-15', 'jenis_kelamin' => 'L', 'status_hidup' => 'Hidup', 'alamat_ktp' => 'Jl. Tani Makmur No. 5', 'rt_ktp' => '003', 'rw_ktp' => '002'],
        ];
        DB::table('penduduk')->insert($penduduk);

        // Update kepala keluarga
        DB::table('kartu_keluarga')->where('no_kk', '3201231010100001')->update(['kepala_keluarga_nik' => '3201231010800001']);
        DB::table('kartu_keluarga')->where('no_kk', '3201230101120002')->update(['kepala_keluarga_nik' => '3201230101750003']);
        DB::table('kartu_keluarga')->where('no_kk', '3201231506150003')->update(['kepala_keluarga_nik' => '3201231506900005']);

        // Seed Organisasi Masyarakat
        $organisasi = [
            ['id_organisasi' => 'ORG01', 'nama_organisasi' => 'Karang Taruna'],
            ['id_organisasi' => 'ORG02', 'nama_organisasi' => 'PKK Desa'],
            ['id_organisasi' => 'ORG03', 'nama_organisasi' => 'Kelompok Tani Jaya'],
        ];
        DB::table('organisasi_masyarakat')->insert($organisasi);

        // Seed Anggota Organisasi
        $anggotaOrganisasi = [
            ['id_organisasi' => 'ORG01', 'nik' => '3201232008050001'],
            ['id_organisasi' => 'ORG02', 'nik' => '3201235505820002'],
            ['id_organisasi' => 'ORG02', 'nik' => '3201234502780004'],
            ['id_organisasi' => 'ORG03', 'nik' => '3201231010800001'],
            ['id_organisasi' => 'ORG03', 'nik' => '3201231506900005'],
        ];
        DB::table('anggota_organisasi')->insert($anggotaOrganisasi);
    }
}
