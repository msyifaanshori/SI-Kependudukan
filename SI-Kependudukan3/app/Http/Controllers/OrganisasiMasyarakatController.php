<?php

namespace App\Http\Controllers;

use App\Models\OrganisasiMasyarakat;
use App\Models\Penduduk;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganisasiMasyarakatController extends Controller
{
    public function index()
    {
        $organisasi = OrganisasiMasyarakat::withCount('anggota')->get();
        return view('organisasi.index', compact('organisasi'));
    }

    public function create()
    {
        return view('organisasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_organisasi' => 'required|string|max:100',
        ]);

        // Generate ID
        $validated['id_organisasi'] = 'ORG' . substr((string)time(), -4);

        $organisasi = OrganisasiMasyarakat::create($validated);

        HistoryLog::logAction('Tambah Organisasi', "Menambahkan organisasi baru: {$organisasi->nama_organisasi}.");

        return redirect()->route('organisasi.index')->with('success', 'Data Organisasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $organisasi = OrganisasiMasyarakat::with('anggota')->findOrFail($id);
        $pendudukNonAnggota = Penduduk::where('status_hidup', 'Hidup')
            ->whereNotIn('nik', $organisasi->anggota->pluck('nik'))
            ->get();
        
        return view('organisasi.show', compact('organisasi', 'pendudukNonAnggota'));
    }

    public function edit($id)
    {
        $organisasi = OrganisasiMasyarakat::findOrFail($id);
        return view('organisasi.edit', compact('organisasi'));
    }

    public function update(Request $request, $id)
    {
        $organisasi = OrganisasiMasyarakat::findOrFail($id);

        $validated = $request->validate([
            'nama_organisasi' => 'required|string|max:100',
        ]);

        $organisasi->update($validated);

        HistoryLog::logAction('Update Organisasi', "Memperbarui data organisasi: {$organisasi->nama_organisasi}.");

        return redirect()->route('organisasi.index')->with('success', 'Data Organisasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $organisasi = OrganisasiMasyarakat::findOrFail($id);
        $nama = $organisasi->nama_organisasi;
        
        $organisasi->delete();

        HistoryLog::logAction('Hapus Organisasi', "Menghapus organisasi: {$nama}.");

        return redirect()->route('organisasi.index')->with('success', 'Data Organisasi berhasil dihapus.');
    }

    public function addAnggota(Request $request, $id)
    {
        $validated = $request->validate([
            'nik' => 'required|exists:penduduk,nik',
        ]);

        $organisasi = OrganisasiMasyarakat::findOrFail($id);
        $penduduk = Penduduk::findOrFail($validated['nik']);

        $organisasi->anggota()->attach($validated['nik']);

        HistoryLog::logAction('Tambah Anggota', "Menambahkan {$penduduk->nama_lengkap} ke organisasi {$organisasi->nama_organisasi}.");

        return redirect()->route('organisasi.show', $id)->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function removeAnggota($id, $nik)
    {
        $organisasi = OrganisasiMasyarakat::findOrFail($id);
        $penduduk = Penduduk::findOrFail($nik);

        $organisasi->anggota()->detach($nik);

        HistoryLog::logAction('Hapus Anggota', "Menghapus {$penduduk->nama_lengkap} dari organisasi {$organisasi->nama_organisasi}.");

        return redirect()->route('organisasi.show', $id)->with('success', 'Anggota berhasil dihapus.');
    }
}
