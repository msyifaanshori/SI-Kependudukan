<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::all();
        $pendudukHidup = $penduduk->where('status_hidup', 'Hidup');

        $stats = [
            'totalHidup' => $pendudukHidup->count(),
            'totalMeninggal' => $penduduk->count() - $pendudukHidup->count(),
            'lakiLaki' => $pendudukHidup->where('jenis_kelamin', 'L')->count(),
            'perempuan' => $pendudukHidup->where('jenis_kelamin', 'P')->count(),
        ];

        $ageGroups = [
            '0-5 (Balita)' => 0,
            '6-17 (Anak/Remaja)' => 0,
            '18-55 (Dewasa)' => 0,
            '> 55 (Lansia)' => 0,
        ];

        foreach ($pendudukHidup as $p) {
            $age = $p->umur;
            
            if ($age <= 5) $ageGroups['0-5 (Balita)']++;
            elseif ($age <= 17) $ageGroups['6-17 (Anak/Remaja)']++;
            elseif ($age <= 55) $ageGroups['18-55 (Dewasa)']++;
            else $ageGroups['> 55 (Lansia)']++;
        }

        return view('laporan.index', compact('stats', 'ageGroups'));
    }
}
