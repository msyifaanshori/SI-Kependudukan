@extends('layouts.app')

@section('title', 'Tambah Penduduk - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Penduduk</h1>

    <form action="{{ route('penduduk.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- NIK Input Manual -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">NIK (Nomor Induk Kependudukan) - 16 Digit</label>
                <input type="text" name="nik" value="{{ old('nik') }}" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nik') border-red-500 @enderror" 
                       placeholder="Contoh: 3201231234567890" 
                       maxlength="16" 
                       pattern="[0-9]{16}"
                       title="Masukkan 16 digit angka NIK">
                <p class="text-gray-500 text-sm mt-1">Masukkan 16 digit angka NIK</p>
                @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror">
                @error('nama_lengkap')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- No. KK Input Manual -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium mb-2">Nomor Kartu Keluarga (KK) - 16 Digit</label>
                <input type="hidden" name="no_kk_input_type" value="manual">
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_kk') border-red-500 @enderror" 
                       placeholder="Contoh: 3201241234567890" 
                       maxlength="16" 
                       pattern="[0-9]{16}"
                       title="Masukkan 16 digit angka No. KK">
                <p class="text-gray-500 text-sm mt-1">Masukkan 16 digit angka No. KK (akan dibuat otomatis jika belum ada)</p>
                @error('no_kk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" max="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tgl_lahir') border-red-500 @enderror">
                @error('tgl_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Status Hubungan dalam Keluarga</label>
                <select name="status_hubungan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_hubungan') border-red-500 @enderror">
                    <option value="">Pilih Status Hubungan</option>
                    <option value="KEPALA_KELUARGA" {{ old('status_hubungan') == 'KEPALA_KELUARGA' ? 'selected' : '' }}>Kepala Keluarga</option>
                    <option value="ISTRI" {{ old('status_hubungan') == 'ISTRI' ? 'selected' : '' }}>Istri</option>
                    <option value="SUAMI" {{ old('status_hubungan') == 'SUAMI' ? 'selected' : '' }}>Suami</option>
                    <option value="ANAK" {{ old('status_hubungan', 'ANAK') == 'ANAK' ? 'selected' : '' }}>Anak</option>
                    <option value="CUCU" {{ old('status_hubungan') == 'CUCU' ? 'selected' : '' }}>Cucu</option>
                    <option value="ORANG_TUA" {{ old('status_hubungan') == 'ORANG_TUA' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="MERTUA" {{ old('status_hubungan') == 'MERTUA' ? 'selected' : '' }}>Mertua</option>
                    <option value="MENANTU" {{ old('status_hubungan') == 'MENANTU' ? 'selected' : '' }}>Menantu</option>
                    <option value="LAINNYA" {{ old('status_hubungan') == 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('status_hubungan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Pendidikan Terakhir</label>
                <select name="id_pendidikan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_pendidikan') border-red-500 @enderror">
                    <option value="">Pilih Pendidikan</option>
                    @foreach($pendidikan as $p)
                        <option value="{{ $p->id_pendidikan }}" {{ old('id_pendidikan') == $p->id_pendidikan ? 'selected' : '' }}>{{ $p->jenjang }}</option>
                    @endforeach
                </select>
                @error('id_pendidikan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Pekerjaan</label>
                <select name="id_pekerjaan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_pekerjaan') border-red-500 @enderror">
                    <option value="">Pilih Pekerjaan</option>
                    @foreach($pekerjaan as $p)
                        <option value="{{ $p->id_pekerjaan }}" {{ old('id_pekerjaan') == $p->id_pekerjaan ? 'selected' : '' }}>{{ $p->nama_pekerjaan }}</option>
                    @endforeach
                </select>
                @error('id_pekerjaan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium mb-2">Alamat KTP <span class="text-gray-500 text-sm font-normal">(Opsional - Kosongkan untuk menggunakan alamat KK)</span></label>
                <input type="text" name="alamat_ktp" value="{{ old('alamat_ktp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat_ktp') border-red-500 @enderror" placeholder="Kosongkan jika sama dengan alamat KK">
                @error('alamat_ktp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">RT <span class="text-gray-500 text-sm font-normal">(Opsional)</span></label>
                <input type="text" name="rt_ktp" value="{{ old('rt_ktp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rt_ktp') border-red-500 @enderror" placeholder="Kosongkan untuk menggunakan RT KK">
                @error('rt_ktp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">RW <span class="text-gray-500 text-sm font-normal">(Opsional)</span></label>
                <input type="text" name="rw_ktp" value="{{ old('rw_ktp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rw_ktp') border-red-500 @enderror" placeholder="Kosongkan untuk menggunakan RW KK">
                @error('rw_ktp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Status Hidup</label>
                <select name="status_hidup" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_hidup') border-red-500 @enderror">
                    <option value="Hidup" {{ old('status_hidup', 'Hidup') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="Meninggal" {{ old('status_hidup') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
                @error('status_hidup')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('penduduk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Tambah Data</button>
        </div>
    </form>
</div>
@endsection
