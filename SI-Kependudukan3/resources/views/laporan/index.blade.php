@extends('layouts.app')

@section('title', 'Laporan Kependudukan - SI Kependudukan')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Laporan Kependudukan Tahunan</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ringkasan Populasi -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Ringkasan Populasi</h3>
            <div class="space-y-3 text-gray-600">
                <p class="flex justify-between">
                    <span>Total Penduduk (Hidup):</span> 
                    <span class="font-bold">{{ $stats['totalHidup'] }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Total Penduduk (Meninggal):</span> 
                    <span class="font-bold">{{ $stats['totalMeninggal'] }}</span>
                </p>
            </div>
        </div>

        <!-- Berdasarkan Jenis Kelamin -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Berdasarkan Jenis Kelamin</h3>
            <div class="space-y-3 text-gray-600">
                <p class="flex justify-between">
                    <span>Laki-laki:</span> 
                    <span class="font-bold">{{ $stats['lakiLaki'] }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Perempuan:</span> 
                    <span class="font-bold">{{ $stats['perempuan'] }}</span>
                </p>
            </div>
        </div>

        <!-- Berdasarkan Kelompok Usia -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Berdasarkan Kelompok Usia</h3>
            <div class="space-y-3 text-gray-600">
                @foreach($ageGroups as $group => $count)
                <p class="flex justify-between">
                    <span>{{ $group }}:</span> 
                    <span class="font-bold">{{ $count }}</span>
                </p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
