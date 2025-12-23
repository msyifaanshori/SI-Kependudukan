@extends('layouts.app')

@section('title', 'Dashboard - SI Kependudukan')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
        <!-- Total Penduduk -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between transition-shadow duration-300 hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase">Total Penduduk</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPenduduk }}</p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
        </div>

        <!-- Total KK -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between transition-shadow duration-300 hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase">Total Kartu Keluarga</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalKeluarga }}</p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z" /></svg>
            </div>
        </div>

        <!-- Total Organisasi -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between transition-shadow duration-300 hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase">Total Organisasi</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalOrganisasi }}</p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
        </div>

        <!-- Laki-laki -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between transition-shadow duration-300 hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase">Laki-laki</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalLakiLaki }}</p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
        </div>

        <!-- Perempuan -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between transition-shadow duration-300 hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase">Perempuan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPerempuan }}</p>
            </div>
            <div class="text-blue-500 bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-2a6 6 0 00-12 0v2" /></svg>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Penduduk per RT -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Jumlah Penduduk per RT</h3>
            <div class="space-y-3">
                @php
                    $maxValue = $pendudukPerRt->max('value') ?: 1;
                @endphp
                @foreach($pendudukPerRt as $item)
                <div class="flex items-center">
                    <div class="w-1/4 text-sm text-gray-600 truncate pr-2">{{ $item['label'] }}</div>
                    <div class="w-3/4 bg-gray-200 rounded-full h-6">
                        <div class="bg-blue-500 h-6 rounded-full flex items-center justify-end pr-2 text-white text-xs font-medium" 
                             style="width: {{ ($item['value'] / $maxValue) * 100 }}%">
                            {{ $item['value'] }} Orang
                        </div>
                    </div>
                </div>
                @endforeach
                @if($pendudukPerRt->isEmpty())
                <p class="text-center text-gray-400 text-sm py-4">Data tidak tersedia.</p>
                @endif
            </div>
        </div>

        <!-- Distribusi Usia & Jenis Kelamin -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Distribusi Usia & Jenis Kelamin</h3>
            <div class="flex justify-end space-x-4 mb-2 text-xs">
                <div class="flex items-center"><span class="w-3 h-3 bg-blue-500 mr-1 rounded-sm"></span>Laki-laki</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-pink-500 mr-1 rounded-sm"></span>Perempuan</div>
            </div>
            <div class="space-y-4">
                @foreach($ageGroups as $label => $values)
                <div>
                    <div class="text-sm text-gray-600 mb-1">{{ $label }}</div>
                    @php
                        $total = $values['L'] + $values['P'];
                        $percentL = $total > 0 ? ($values['L'] / $total) * 100 : 0;
                        $percentP = $total > 0 ? ($values['P'] / $total) * 100 : 0;
                    @endphp
                    <div class="flex items-center bg-gray-200 rounded-full h-6 w-full">
                        <div class="bg-blue-500 h-6 rounded-l-full flex items-center justify-end pr-2 text-white text-xs font-medium" 
                             style="width: {{ $percentL }}%">
                            {{ $values['L'] > 0 ? $values['L'] : '' }}
                        </div>
                        <div class="bg-pink-500 h-6 rounded-r-full flex items-center justify-start pl-2 text-white text-xs font-medium" 
                             style="width: {{ $percentP }}%">
                            {{ $values['P'] > 0 ? $values['P'] : '' }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Anggota per Organisasi -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Jumlah Anggota per Organisasi</h3>
            <div class="space-y-3">
                @php
                    $maxOrgValue = $anggotaPerOrganisasi->max('value') ?: 1;
                @endphp
                @foreach($anggotaPerOrganisasi as $item)
                <div class="flex items-center">
                    <div class="w-1/3 text-sm text-gray-600 truncate pr-2">{{ $item['label'] }}</div>
                    <div class="w-2/3 bg-gray-200 rounded-full h-6">
                        <div class="bg-purple-500 h-6 rounded-full flex items-center justify-end pr-2 text-white text-xs font-medium" 
                             style="width: {{ ($item['value'] / $maxOrgValue) * 100 }}%">
                            {{ $item['value'] }} Anggota
                        </div>
                    </div>
                </div>
                @endforeach
                @if($anggotaPerOrganisasi->isEmpty())
                <p class="text-center text-gray-400 text-sm py-4">Data tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
