@extends('layouts.admin')

@section('page-title', 'Surat Keluar')

@section('content')
<div class="space-y-6">
    <!-- Header & Actions -->
    <div class="flex justify-between items-center">
        <h3 class="text-2xl font-bold text-gray-800">Daftar Surat Keluar</h3>
        <a href="{{ route('admin.surat-keluar.create') }}" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Surat Keluar
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('admin.surat-keluar.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat, tujuan, perihal..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent">
            </div>
            <div>
                <select name="sifat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent">
                    <option value="">Semua Sifat</option>
                    <option value="Sangat Segera" {{ request('sifat') == 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                    <option value="Segera" {{ request('sifat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                    <option value="Rahasia" {{ request('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg">
                    Filter
                </button>
                <a href="{{ route('admin.surat-keluar.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($suratKeluar->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($suratKeluar as $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $surat->nomor_surat }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $surat->tujuan_surat }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $surat->tanggal_surat->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $surat->sifat == 'Sangat Segera' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $surat->sifat == 'Segera' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $surat->sifat == 'Rahasia' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $surat->sifat }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ Str::limit($surat->perihal, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($surat->suratMasuk)
                                <span class="text-blue-600" title="{{ $surat->suratMasuk->nomor_surat }}">
                                    Ya
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.surat-keluar.show', $surat->id) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.surat-keluar.print', $surat->id) }}" target="_blank" class="text-gray-600 hover:text-gray-900" title="Print">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.surat-keluar.edit', $surat->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.surat-keluar.destroy', $surat->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $suratKeluar->links() }}
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <p class="mt-4">Belum ada surat keluar</p>
        </div>
        @endif
    </div>
</div>
@endsection