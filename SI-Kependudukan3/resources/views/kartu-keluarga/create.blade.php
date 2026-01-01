@extends('layouts.app')

@section('title', 'Tambah Kartu Keluarga - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Kartu Keluarga</h1>

    <div class="mb-4 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700">
        <p class="font-medium">📝 Petunjuk:</p>
        <p class="text-sm mt-1">Buat Kartu Keluarga terlebih dahulu dengan mengisi alamat. Setelah itu, Anda dapat menambahkan anggota keluarga termasuk Kepala Keluarga melalui menu "Tambah Penduduk".</p>
    </div>

    <form action="{{ route('kartu-keluarga.store') }}" method="POST">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror" placeholder="Contoh: Jl. Merdeka No. 123">
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">RT</label>
                    <input type="text" name="rt" value="{{ old('rt') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rt') border-red-500 @enderror" placeholder="Contoh: 001">
                    @error('rt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">RW</label>
                    <input type="text" name="rw" value="{{ old('rw') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rw') border-red-500 @enderror" placeholder="Contoh: 001">
                    @error('rw')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('kartu-keluarga.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Tambah Data</button>
        </div>
    </form>
</div>
@endsection
