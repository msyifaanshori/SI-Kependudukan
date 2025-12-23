<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\OrganisasiMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalPenduduk = Penduduk::count();
        $totalKeluarga = KartuKeluarga::count();
        $totalOrganisasi = OrganisasiMasyarakat::count();
        $totalLakiLaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Penduduk::where('jenis_kelamin', 'P')->count();

        // Penduduk per RT/RW
        $pendudukPerRtRw = Penduduk::where('status_hidup', 'Hidup')
            ->select('rt_ktp', 'rw_ktp', DB::raw('count(*) as total'))
            ->groupBy('rt_ktp', 'rw_ktp')
            ->get()
            ->map(function($item) {
                return [
                    'label' => "RT {$item->rt_ktp}/{$item->rw_ktp}",
                    'value' => $item->total
                ];
            });

        // Age groups
        $pendudukHidup = Penduduk::where('status_hidup', 'Hidup')->get();
        $ageGroups = [
            '0-5 (Balita)' => ['L' => 0, 'P' => 0],
            '6-17 (Anak/Remaja)' => ['L' => 0, 'P' => 0],
            '18-55 (Dewasa)' => ['L' => 0, 'P' => 0],
            '> 55 (Lansia)' => ['L' => 0, 'P' => 0],
        ];

        foreach ($pendudukHidup as $p) {
            $age = $p->umur;
            $gender = $p->jenis_kelamin;
            
            if ($age <= 5) $ageGroups['0-5 (Balita)'][$gender]++;
            elseif ($age <= 17) $ageGroups['6-17 (Anak/Remaja)'][$gender]++;
            elseif ($age <= 55) $ageGroups['18-55 (Dewasa)'][$gender]++;
            else $ageGroups['> 55 (Lansia)'][$gender]++;
        }

        // Anggota per organisasi
        $anggotaPerOrganisasi = OrganisasiMasyarakat::withCount('anggota')
            ->get()
            ->map(function($org) {
                return [
                    'label' => $org->nama_organisasi,
                    'value' => $org->anggota_count
                ];
            });

        return view('dashboard', compact(
            'totalPenduduk',
            'totalKeluarga',
            'totalOrganisasi',
            'totalLakiLaki',
            'totalPerempuan',
            'pendudukPerRtRw',
            'ageGroups',
            'anggotaPerOrganisasi'
        ));
    }
}
