<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KependudukanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

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

        // Array untuk menyimpan data
        $kartuKeluargaData = [];
        $pendudukData = [];
        $kepalaKeluargaUpdates = [];

        // Generate 100 Kartu Keluarga dengan masing-masing 5 anggota = 500 penduduk
        $rtOptions = ['001', '002', '003', '004', '005', '006', '007', '008', '009', '010'];
        $rwOptions = ['001', '002', '003', '004', '005'];
        
        $streets = [
            'Jl. Merdeka', 'Jl. Pahlawan', 'Jl. Sudirman', 'Jl. Ahmad Yani', 'Jl. Diponegoro',
            'Jl. Gatot Subroto', 'Jl. Imam Bonjol', 'Jl. Veteran', 'Jl. Raya', 'Jl. Mawar',
            'Jl. Melati', 'Jl. Anggrek', 'Jl. Kenanga', 'Jl. Dahlia', 'Jl. Cempaka'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $rt = $faker->randomElement($rtOptions);
            $rw = $faker->randomElement($rwOptions);
            $street = $faker->randomElement($streets);
            $streetNumber = $faker->numberBetween(1, 200);
            $alamat = "{$street} No. {$streetNumber}";
            
            $no_kk = '320123' . str_pad($i, 10, '0', STR_PAD_LEFT);
            
            // Buat Kartu Keluarga
            $kartuKeluargaData[] = [
                'no_kk' => $no_kk,
                'kepala_keluarga_nik' => null,
                'alamat' => $alamat,
                'rt' => $rt,
                'rw' => $rw,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Buat 5 anggota keluarga per KK
            $kepalaKeluargaNik = null;
            
            for ($j = 1; $j <= 5; $j++) {
                $gender = $faker->randomElement(['L', 'P']);
                
                // Tentukan umur berdasarkan urutan
                if ($j == 1) {
                    // Kepala keluarga (35-60 tahun)
                    $age = $faker->numberBetween(35, 60);
                    $nama = $gender === 'L' ? $faker->firstNameMale() : $faker->firstNameFemale();
                    $pekerjaan = $faker->randomElement(['J03', 'J04', 'J05', 'J06']);
                    $pendidikan = $faker->randomElement(['P04', 'P05', 'P06', 'P07']);
                } elseif ($j == 2) {
                    // Pasangan (30-55 tahun)
                    $age = $faker->numberBetween(30, 55);
                    $gender = $gender === 'L' ? 'P' : 'L'; // Berlawanan dengan kepala keluarga
                    $nama = $gender === 'L' ? $faker->firstNameMale() : $faker->firstNameFemale();
                    $pekerjaan = $gender === 'P' ? $faker->randomElement(['J04', 'J07']) : $faker->randomElement(['J03', 'J04', 'J05']);
                    $pendidikan = $faker->randomElement(['P03', 'P04', 'P05', 'P06']);
                } else {
                    // Anak (5-25 tahun)
                    $age = $faker->numberBetween(5, 25);
                    $nama = $gender === 'L' ? $faker->firstNameMale() : $faker->firstNameFemale();
                    if ($age < 18) {
                        $pekerjaan = 'J02';
                        $pendidikan = $age < 12 ? 'P02' : ($age < 16 ? 'P03' : 'P04');
                    } else {
                        $pekerjaan = $faker->randomElement(['J02', 'J04', 'J05']);
                        $pendidikan = $faker->randomElement(['P04', 'P05', 'P06']);
                    }
                }

                $tglLahir = now()->subYears($age)->subDays($faker->numberBetween(1, 365))->format('Y-m-d');
                $nik = '320123' . str_pad(($i * 10 + $j), 10, '0', STR_PAD_LEFT);
                
                if ($j == 1) {
                    $kepalaKeluargaNik = $nik;
                }

                $pendudukData[] = [
                    'nik' => $nik,
                    'no_kk' => $no_kk,
                    'id_pekerjaan' => $pekerjaan,
                    'id_pendidikan' => $pendidikan,
                    'nama_lengkap' => $nama . ' ' . $faker->lastName(),
                    'tgl_lahir' => $tglLahir,
                    'jenis_kelamin' => $gender,
                    'status_hidup' => $faker->randomElement(['Hidup', 'Hidup', 'Hidup', 'Hidup', 'Hidup', 'Hidup', 'Hidup', 'Hidup', 'Hidup', 'Meninggal']),
                    'alamat_ktp' => $alamat,
                    'rt_ktp' => $rt,
                    'rw_ktp' => $rw,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $kepalaKeluargaUpdates[] = [
                'no_kk' => $no_kk,
                'kepala_keluarga_nik' => $kepalaKeluargaNik
            ];
        }

        // Insert data dalam batch
        foreach (array_chunk($kartuKeluargaData, 50) as $chunk) {
            DB::table('kartu_keluarga')->insert($chunk);
        }

        foreach (array_chunk($pendudukData, 100) as $chunk) {
            DB::table('penduduk')->insert($chunk);
        }

        // Update kepala keluarga
        foreach ($kepalaKeluargaUpdates as $update) {
            DB::table('kartu_keluarga')
                ->where('no_kk', $update['no_kk'])
                ->update(['kepala_keluarga_nik' => $update['kepala_keluarga_nik']]);
        }

        // Seed Organisasi Masyarakat
        $organisasi = [
            ['id_organisasi' => 'ORG01', 'nama_organisasi' => 'Karang Taruna', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG02', 'nama_organisasi' => 'PKK Desa', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG03', 'nama_organisasi' => 'Kelompok Tani Jaya', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG04', 'nama_organisasi' => 'Posyandu Melati', 'created_at' => now(), 'updated_at' => now()],
            ['id_organisasi' => 'ORG05', 'nama_organisasi' => 'Paguyuban RT', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('organisasi_masyarakat')->insert($organisasi);

        // Seed Anggota Organisasi (random dari penduduk yang hidup)
        $pendudukHidup = DB::table('penduduk')->where('status_hidup', 'Hidup')->pluck('nik')->toArray();
        $anggotaOrganisasi = [];
        
        foreach (['ORG01', 'ORG02', 'ORG03', 'ORG04', 'ORG05'] as $orgId) {
            $randomMembers = $faker->randomElements($pendudukHidup, $faker->numberBetween(10, 30));
            foreach ($randomMembers as $nik) {
                $anggotaOrganisasi[] = [
                    'id_organisasi' => $orgId,
                    'nik' => $nik,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('anggota_organisasi')->insert($anggotaOrganisasi);

        $this->command->info('Seeder berhasil! 500 penduduk dalam 100 keluarga telah dibuat.');
    }
}
