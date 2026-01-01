<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $kartuKeluarga = KartuKeluarga::with('kepalaKeluarga')
            ->when($search, function($query) use ($search) {
                $query->where('no_kk', 'like', "%{$search}%")
                      ->orWhereHas('kepalaKeluarga', function($q) use ($search) {
                          $q->where('nama_lengkap', 'like', "%{$search}%");
                      });
            })
            ->orderBy('no_kk')
            ->paginate(20);

        return view('kartu-keluarga.index', compact('kartuKeluarga', 'search'));
    }

    public function create()
    {
        return view('kartu-keluarga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alamat' => 'required|string',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
        ]);

        // Generate No KK
        $validated['no_kk'] = '320124' . rand(1000000000, 9999999999);
        $validated['kepala_keluarga_nik'] = null; // Set null dulu, akan diisi otomatis saat tambah penduduk

        $kartuKeluarga = KartuKeluarga::create($validated);

        HistoryLog::logAction('Tambah KK', "Menambahkan KK baru dengan No. {$kartuKeluarga->no_kk}.");

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data Kartu Keluarga berhasil ditambahkan. Silakan tambahkan data penduduk untuk KK ini.');
    }

    public function show($no_kk)
    {
        $kartuKeluarga = KartuKeluarga::with(['kepalaKeluarga', 'anggotaKeluarga'])->findOrFail($no_kk);
        return view('kartu-keluarga.show', compact('kartuKeluarga'));
    }

    public function edit($no_kk)
    {
        $kartuKeluarga = KartuKeluarga::findOrFail($no_kk);
        $penduduk = Penduduk::where('status_hidup', 'Hidup')->get();
        return view('kartu-keluarga.edit', compact('kartuKeluarga', 'penduduk'));
    }

    public function update(Request $request, $no_kk)
    {
        $kartuKeluarga = KartuKeluarga::findOrFail($no_kk);

        $validated = $request->validate([
            'kepala_keluarga_nik' => 'required|exists:penduduk,nik',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
        ]);

        $kartuKeluarga->update($validated);
        $kepalaKeluarga = Penduduk::find($validated['kepala_keluarga_nik']);

        HistoryLog::logAction('Update KK', "Memperbarui data KK No. {$no_kk} (Kepala Keluarga: {$kepalaKeluarga->nama_lengkap}).");

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data Kartu Keluarga berhasil diperbarui.');
    }

    public function destroy($no_kk)
    {
        $kartuKeluarga = KartuKeluarga::findOrFail($no_kk);
        
        // Cek apakah masih ada penduduk yang terikat
        if ($kartuKeluarga->anggotaKeluarga()->count() > 0) {
            return redirect()->route('kartu-keluarga.index')
                ->with('error', 'Tidak dapat menghapus Kartu Keluarga karena masih terikat pada data penduduk.');
        }

        $kepalaKeluarga = $kartuKeluarga->kepalaKeluarga;
        $kartuKeluarga->delete();

        HistoryLog::logAction('Hapus KK', "Menghapus KK No. {$no_kk} (Kepala Keluarga: {$kepalaKeluarga->nama_lengkap}).");

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data Kartu Keluarga berhasil dihapus.');
    }
}
