@extends('layouts.app')

@section('title', 'Detail Penduduk - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Penduduk</h1>
        <a href="{{ route('penduduk.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">NIK</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->nik }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">No. Kartu Keluarga</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->no_kk }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->nama_lengkap }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->tgl_lahir->format('d F Y') }} ({{ $penduduk->umur }} tahun)</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Status Hidup</dt>
            <dd class="col-span-2 text-sm text-gray-900">
                <span class="py-1 px-3 rounded-full text-xs font-semibold {{ $penduduk->status_hidup == 'Hidup' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ $penduduk->status_hidup }}
                </span>
            </dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Alamat KTP</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->alamat_ktp }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">RT / RW</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->rt_ktp }} / {{ $penduduk->rw_ktp }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Pendidikan Terakhir</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->pendidikan->jenjang ?? 'N/A' }}</dd>
        </div>

        <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-200">
            <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
            <dd class="col-span-2 text-sm text-gray-900">{{ $penduduk->pekerjaan->nama_pekerjaan ?? 'N/A' }}</dd>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('penduduk.edit', $penduduk->nik) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Edit</a>
        <form action="{{ route('penduduk.destroy', $penduduk->nik) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Hapus</button>
        </form>
    </div>
</div>
@endsection
