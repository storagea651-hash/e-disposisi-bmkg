@extends('layouts.pimpinan')

@section('page-title', 'Dashboard Pimpinan')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
        <p class="text-gray-600">Sistem E-Disposisi BMKG</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Surat Masuk Belum Disposisi -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Surat Belum Disposisi</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $suratBelumDisposisi }}</h4>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Surat Masuk -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Surat Masuk</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $totalSuratMasuk }}</h4>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Disposisi Saya -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Disposisi Saya</p>
                    <h4 class="text-3xl font-bold text-slate-800">{{ $totalDisposisiSaya }}</h4>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Surat by Sifat & Disposisi Status -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Surat Belum Disposisi Berdasarkan Sifat -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Surat Belum Disposisi (Per Sifat)</h4>
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
                <p class="text-gray-500 text-sm">Semua surat sudah didisposisi.</p>
            @endif
        </div>

        <!-- Disposisi Saya Berdasarkan Status -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Disposisi Saya (Per Status)</h4>
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
                <p class="text-gray-500 text-sm">Belum ada disposisi.</p>
            @endif
        </div>
    </div>

    <!-- Surat Masuk yang Perlu Disposisi -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Surat Masuk yang Perlu Disposisi</h4>
        @if($recentSuratMasuk->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Surat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dari</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sifat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diterima</th>
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
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $surat->diterima_tanggal->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-sm">Semua surat sudah didisposisi.</p>
        @endif
    </div>

    <!-- Disposisi Terbaru Saya -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Disposisi Terbaru Saya</h4>
        @if($recentDisposisi->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Surat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
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
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $disposisi->tanggal_disposisi->format('d/m/Y') }}</td>
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