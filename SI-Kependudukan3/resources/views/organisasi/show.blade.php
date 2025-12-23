@extends('layouts.app')

@section('title', 'Manajemen Anggota Organisasi - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Anggota Organisasi</h1>
            <p class="text-gray-600">{{ $organisasi->nama_organisasi }}</p>
        </div>
        <a href="{{ route('organisasi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <!-- Form Tambah Anggota -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 mb-2">Tambah Anggota Baru:</h3>
        <form action="{{ route('organisasi.addAnggota', $organisasi->id_organisasi) }}" method="POST" class="flex space-x-2">
            @csrf
            <select name="nik" required class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih penduduk...</option>
                @foreach($pendudukNonAnggota as $p)
                    <option value="{{ $p->nik }}">{{ $p->nama_lengkap }} ({{ $p->nik }})</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Tambah
            </button>
        </form>
    </div>

    <!-- Daftar Anggota -->
    <h3 class="font-semibold text-gray-700 mb-2">Daftar Anggota:</h3>
    <div class="overflow-x-auto border rounded-lg">
        <table class="min-w-full">
            <thead class="bg-gray-100 text-sm">
                <tr>
                    <th class="py-2 px-4 text-left font-medium text-gray-600">NIK</th>
                    <th class="py-2 px-4 text-left font-medium text-gray-600">Nama Lengkap</th>
                    <th class="py-2 px-4 text-center font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($organisasi->anggota as $anggota)
                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $anggota->nik }}</td>
                    <td class="py-2 px-4">{{ $anggota->nama_lengkap }}</td>
                    <td class="py-2 px-4 text-center">
                        <form action="{{ route('organisasi.removeAnggota', [$organisasi->id_organisasi, $anggota->nik]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">Belum ada anggota.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('organisasi.edit', $organisasi->id_organisasi) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Edit Organisasi</a>
    </div>
</div>
@endsection
