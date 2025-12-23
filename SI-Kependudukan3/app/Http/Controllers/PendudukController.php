<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $penduduk = Penduduk::with(['pekerjaan', 'pendidikan', 'kartuKeluarga'])
            ->when($search, function($query) use ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('no_kk', 'like', "%{$search}%");
            })
            ->orderBy('nama_lengkap')
            ->paginate(20);

        return view('penduduk.index', compact('penduduk', 'search'));
    }

    public function create()
    {
        $kartuKeluarga = KartuKeluarga::all();
        $pekerjaan = Pekerjaan::all();
        $pendidikan = Pendidikan::all();
        
        return view('penduduk.create', compact('kartuKeluarga', 'pekerjaan', 'pendidikan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_kk' => 'required|exists:kartu_keluarga,no_kk',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status_hidup' => 'required|in:Hidup,Meninggal',
            'alamat_ktp' => 'required|string',
            'rt_ktp' => 'required|string|max:10',
            'rw_ktp' => 'required|string|max:10',
            'id_pendidikan' => 'required|exists:pendidikan,id_pendidikan',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
        ]);

        // Generate NIK
        $validated['nik'] = '320123' . rand(1000000000, 9999999999);

        $penduduk = Penduduk::create($validated);

        HistoryLog::logAction('Tambah Penduduk', "Menambahkan data baru untuk {$penduduk->nama_lengkap}.");

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show($nik)
    {
        $penduduk = Penduduk::with(['pekerjaan', 'pendidikan', 'kartuKeluarga'])->findOrFail($nik);
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit($nik)
    {
        $penduduk = Penduduk::findOrFail($nik);
        $kartuKeluarga = KartuKeluarga::all();
        $pekerjaan = Pekerjaan::all();
        $pendidikan = Pendidikan::all();
        
        return view('penduduk.edit', compact('penduduk', 'kartuKeluarga', 'pekerjaan', 'pendidikan'));
    }

    public function update(Request $request, $nik)
    {
        $penduduk = Penduduk::findOrFail($nik);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_kk' => 'required|exists:kartu_keluarga,no_kk',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status_hidup' => 'required|in:Hidup,Meninggal',
            'alamat_ktp' => 'required|string',
            'rt_ktp' => 'required|string|max:10',
            'rw_ktp' => 'required|string|max:10',
            'id_pendidikan' => 'required|exists:pendidikan,id_pendidikan',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
        ]);

        $penduduk->update($validated);

        HistoryLog::logAction('Update Penduduk', "Memperbarui data untuk {$penduduk->nama_lengkap} (NIK: {$nik}).");

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy($nik)
    {
        $penduduk = Penduduk::findOrFail($nik);
        $nama = $penduduk->nama_lengkap;
        
        $penduduk->delete();

        HistoryLog::logAction('Hapus Penduduk', "Menghapus data untuk {$nama} (NIK: {$nik}).");

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}
