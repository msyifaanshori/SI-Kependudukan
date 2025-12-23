@extends('layouts.app')

@section('title', 'Edit Kartu Keluarga - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Kartu Keluarga</h1>

    <form action="{{ route('kartu-keluarga.update', $kartuKeluarga->no_kk) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nomor Kartu Keluarga (KK)</label>
                <input type="text" value="{{ $kartuKeluarga->no_kk }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Kepala Keluarga</label>
                <select name="kepala_keluarga_nik" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kepala_keluarga_nik') border-red-500 @enderror">
                    <option value="">Pilih Kepala Keluarga</option>
                    @foreach($penduduk as $p)
                        <option value="{{ $p->nik }}" {{ (old('kepala_keluarga_nik', $kartuKeluarga->kepala_keluarga_nik) == $p->nik) ? 'selected' : '' }}>
                            {{ $p->nama_lengkap }} - {{ $p->nik }}
                        </option>
                    @endforeach
                </select>
                @error('kepala_keluarga_nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $kartuKeluarga->alamat) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror">
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">RT</label>
                    <input type="text" name="rt" value="{{ old('rt', $kartuKeluarga->rt) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rt') border-red-500 @enderror">
                    @error('rt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">RW</label>
                    <input type="text" name="rw" value="{{ old('rw', $kartuKeluarga->rw) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rw') border-red-500 @enderror">
                    @error('rw')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('kartu-keluarga.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
