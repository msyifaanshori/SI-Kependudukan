@extends('layouts.app')

@section('title', 'Riwayat Perubahan - SI Kependudukan')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Perubahan Data</h1>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Waktu</th>
                    <th class="py-3 px-6 text-left">Aksi</th>
                    <th class="py-3 px-6 text-left">Detail</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($history as $log)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        <span class="py-1 px-3 rounded-full text-xs font-semibold 
                            @if(str_contains($log->action, 'Tambah')) bg-green-200 text-green-800
                            @elseif(str_contains($log->action, 'Update')) bg-yellow-200 text-yellow-800
                            @elseif(str_contains($log->action, 'Hapus')) bg-red-200 text-red-800
                            @else bg-gray-200 text-gray-800
                            @endif">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-left">{{ $log->details }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">Belum ada riwayat perubahan data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $history->links() }}
    </div>
</div>
@endsection
