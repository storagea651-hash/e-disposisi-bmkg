@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
        <p class="text-gray-600">Sistem Manajemen Surat & Disposisi BMKG</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Surat Masuk -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Surat Masuk</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $totalSuratMasuk }}</h4>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Surat Keluar</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $totalSuratKeluar }}</h4>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Disposisi -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Disposisi Surat</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $totalDisposisi }}</h4>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Arsip -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Arsip Surat</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $totalArsip ?? 0 }}</h4>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Surat by Sifat & Disposisi Status -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Surat Masuk Berdasarkan Sifat -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Surat Masuk Berdasarkan Sifat</h4>
            @if(!empty($suratBySifat))
                <div class="space-y-3">
                    @foreach(['Sangat Segera' => 'red', 'Segera' => 'yellow', 'Rahasia' => 'purple'] as $sifat => $color)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $sifat }}</span>
                            <span class="px-3 py-1 bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full text-sm font-semibold">
                                {{ $suratBySifat[$sifat] ?? 0 }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada data surat masuk.</p>
            @endif
        </div>

        <!-- Disposisi Berdasarkan Status -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Disposisi Berdasarkan Status</h4>
            @if(!empty($disposisiByStatus))
                <div class="space-y-3">
                    @foreach(['Belum Selesai' => 'red', 'Sedang Diproses' => 'yellow', 'Selesai' => 'green'] as $status => $color)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $status }}</span>
                            <span class="px-3 py-1 bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full text-sm font-semibold">
                                {{ $disposisiByStatus[$status] ?? 0 }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada data disposisi.</p>
            @endif
        </div>
    </div>

    <!-- Recent Surat Masuk -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Surat Masuk Terbaru</h4>
        @if($recentSuratMasuk->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Surat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dari</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sifat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentSuratMasuk as $surat)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $surat->nomor_surat }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $surat->surat_dari }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($surat->perihal, 50) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $surat->sifat == 'Sangat Segera' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $surat->sifat == 'Segera' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $surat->sifat == 'Rahasia' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ $surat->sifat }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada surat masuk.</p>
        @endif
    </div>

    <!-- Recent Disposisi -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Disposisi Terbaru</h4>
        @if($recentDisposisi->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Surat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentDisposisi as $disposisi)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $disposisi->suratMasuk->nomor_surat }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $disposisi->tujuan_disposisi }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($disposisi->catatan_disposisi, 40) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $disposisi->status == 'Belum Selesai' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $disposisi->status == 'Sedang Diproses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $disposisi->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $disposisi->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $disposisi->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada disposisi.</p>
        @endif
    </div>
</div>
@endsection