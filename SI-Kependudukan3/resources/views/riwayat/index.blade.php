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
                    <th class="py-3 px-6 text-left">User</th>
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
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-medium">{{ $log->user_name ?? 'System' }}</span>
                        </div>
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
                    <td colspan="4" class="text-center text-gray-500 py-4">Belum ada riwayat perubahan data.</td>
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
