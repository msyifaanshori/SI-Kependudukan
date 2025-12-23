@extends('layouts.app')

@section('title', 'Detail Kartu Keluarga - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kartu Keluarga</h1>
        <a href="{{ route('kartu-keluarga.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <!-- KK Info -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 mb-2">Informasi Keluarga:</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">No. Kartu Keluarga</p>
                <p class="font-medium text-gray-800">{{ $kartuKeluarga->no_kk }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Kepala Keluarga</p>
                <p class="font-medium text-gray-800">{{ $kartuKeluarga->kepalaKeluarga->nama_lengkap ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600">Alamat</p>
                <p class="font-medium text-gray-800">{{ $kartuKeluarga->alamat }}, RT {{ $kartuKeluarga->rt }}/RW {{ $kartuKeluarga->rw }}</p>
            </div>
        </div>
    </div>

    <!-- Anggota Keluarga -->
    <h3 class="font-semibold text-gray-700 mb-2">Anggota Keluarga:</h3>
    <div class="overflow-x-auto border rounded-lg">
        <table class="min-w-full">
            <thead class="bg-gray-100 text-sm">
                <tr>
                    <th class="py-2 px-4 text-left font-medium text-gray-600">NIK</th>
                    <th class="py-2 px-4 text-left font-medium text-gray-600">Nama Lengkap</th>
                    <th class="py-2 px-4 text-left font-medium text-gray-600">Jenis Kelamin</th>
                    <th class="py-2 px-4 text-left font-medium text-gray-600">Tanggal Lahir</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($kartuKeluarga->anggotaKeluarga as $anggota)
                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $anggota->nik }}</td>
                    <td class="py-2 px-4">{{ $anggota->nama_lengkap }}</td>
                    <td class="py-2 px-4">{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="py-2 px-4">{{ $anggota->tgl_lahir->format('d F Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">Tidak ada anggota keluarga yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga->no_kk) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Edit</a>
        <form action="{{ route('kartu-keluarga.destroy', $kartuKeluarga->no_kk) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Hapus</button>
        </form>
    </div>
</div>
@endsection
