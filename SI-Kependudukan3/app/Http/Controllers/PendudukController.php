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
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|in:L,P',
            'status_hubungan' => 'required|in:KEPALA_KELUARGA,ISTRI,SUAMI,ANAK,CUCU,ORANG_TUA,MERTUA,MENANTU,LAINNYA',
            'status_hidup' => 'required|in:Hidup,Meninggal',
            'alamat_ktp' => 'nullable|string',
            'rt_ktp' => 'nullable|string|max:10',
            'rw_ktp' => 'nullable|string|max:10',
            'id_pendidikan' => 'required|exists:pendidikan,id_pendidikan',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
        ]);

        // Generate NIK
        $validated['nik'] = '320123' . rand(1000000000, 9999999999);

        // Auto-fill alamat_ktp dari kartu keluarga jika kosong
        if (empty($validated['alamat_ktp']) || empty($validated['rt_ktp']) || empty($validated['rw_ktp'])) {
            $kartuKeluarga = KartuKeluarga::where('no_kk', $validated['no_kk'])->first();
            if ($kartuKeluarga) {
                if (empty($validated['alamat_ktp'])) {
                    $validated['alamat_ktp'] = $kartuKeluarga->alamat;
                }
                if (empty($validated['rt_ktp'])) {
                    $validated['rt_ktp'] = $kartuKeluarga->rt;
                }
                if (empty($validated['rw_ktp'])) {
                    $validated['rw_ktp'] = $kartuKeluarga->rw;
                }
            }
        }

        $penduduk = Penduduk::create($validated);

        // Jika status_hubungan adalah KEPALA_KELUARGA, update tabel kartu_keluarga
        if ($validated['status_hubungan'] === 'KEPALA_KELUARGA') {
            $kartuKeluarga = KartuKeluarga::where('no_kk', $validated['no_kk'])->first();
            
            if ($kartuKeluarga) {
                // Cek apakah KK ini sudah memiliki kepala keluarga
                if ($kartuKeluarga->kepala_keluarga_nik !== null) {
                    // Jika sudah ada kepala keluarga, ubah status penduduk lama menjadi LAINNYA
                    $kepalaKeluargaLama = Penduduk::find($kartuKeluarga->kepala_keluarga_nik);
                    if ($kepalaKeluargaLama) {
                        $kepalaKeluargaLama->update(['status_hubungan' => 'LAINNYA']);
                    }
                }
                
                // Update kepala keluarga baru
                $kartuKeluarga->update(['kepala_keluarga_nik' => $penduduk->nik]);
                
                HistoryLog::logAction('Tambah Penduduk', "Menambahkan data baru untuk {$penduduk->nama_lengkap} sebagai Kepala Keluarga pada KK {$validated['no_kk']}.");
            }
        } else {
            HistoryLog::logAction('Tambah Penduduk', "Menambahkan data baru untuk {$penduduk->nama_lengkap}.");
        }

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
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|in:L,P',
            'status_hubungan' => 'required|in:KEPALA_KELUARGA,ISTRI,SUAMI,ANAK,CUCU,ORANG_TUA,MERTUA,MENANTU,LAINNYA',
            'status_hidup' => 'required|in:Hidup,Meninggal',
            'alamat_ktp' => 'nullable|string',
            'rt_ktp' => 'nullable|string|max:10',
            'rw_ktp' => 'nullable|string|max:10',
            'id_pendidikan' => 'required|exists:pendidikan,id_pendidikan',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
        ]);

        // Auto-fill alamat_ktp dari kartu keluarga jika kosong
        if (empty($validated['alamat_ktp']) || empty($validated['rt_ktp']) || empty($validated['rw_ktp'])) {
            $kartuKeluarga = KartuKeluarga::where('no_kk', $validated['no_kk'])->first();
            if ($kartuKeluarga) {
                if (empty($validated['alamat_ktp'])) {
                    $validated['alamat_ktp'] = $kartuKeluarga->alamat;
                }
                if (empty($validated['rt_ktp'])) {
                    $validated['rt_ktp'] = $kartuKeluarga->rt;
                }
                if (empty($validated['rw_ktp'])) {
                    $validated['rw_ktp'] = $kartuKeluarga->rw;
                }
            }
        }

        $oldStatusHubungan = $penduduk->status_hubungan;
        $oldNoKk = $penduduk->no_kk;
        
        $penduduk->update($validated);

        // Logic untuk handle perubahan status_hubungan
        // Jika status_hubungan berubah menjadi KEPALA_KELUARGA
        if ($validated['status_hubungan'] === 'KEPALA_KELUARGA' && $oldStatusHubungan !== 'KEPALA_KELUARGA') {
            $kartuKeluarga = KartuKeluarga::where('no_kk', $validated['no_kk'])->first();
            
            if ($kartuKeluarga) {
                // Jika KK sudah memiliki kepala keluarga lain, ubah statusnya
                if ($kartuKeluarga->kepala_keluarga_nik !== null && $kartuKeluarga->kepala_keluarga_nik !== $nik) {
                    $kepalaKeluargaLama = Penduduk::find($kartuKeluarga->kepala_keluarga_nik);
                    if ($kepalaKeluargaLama) {
                        $kepalaKeluargaLama->update(['status_hubungan' => 'LAINNYA']);
                    }
                }
                
                // Set penduduk ini sebagai kepala keluarga
                $kartuKeluarga->update(['kepala_keluarga_nik' => $nik]);
            }
        }
        // Jika status_hubungan berubah dari KEPALA_KELUARGA ke yang lain
        elseif ($validated['status_hubungan'] !== 'KEPALA_KELUARGA' && $oldStatusHubungan === 'KEPALA_KELUARGA') {
            $kartuKeluarga = KartuKeluarga::where('no_kk', $oldNoKk)->first();
            
            if ($kartuKeluarga && $kartuKeluarga->kepala_keluarga_nik === $nik) {
                // Set kepala keluarga menjadi null
                $kartuKeluarga->update(['kepala_keluarga_nik' => null]);
            }
        }

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
