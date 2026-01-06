@extends('layouts.admin')

@section('page-title', 'Detail Surat Masuk')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.surat-masuk.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-gray-800">Detail Surat Masuk</h3>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.surat-masuk.print', $suratMasuk->id) }}" target="_blank"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </a>

            <a href="{{ route('admin.surat-masuk.edit', $suratMasuk->id) }}"
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>

            @if($suratMasuk->disposisi)
                <a href="{{ route('admin.surat-masuk.generate-disposisi', $suratMasuk->id) }}"
                   class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v12m0 0l-3-3m3 3l3-3M4 20h16"></path>
                    </svg>
                    Generate Disposisi (DOCX)
                </a>
            @endif
        </div>
    </div>

    @if(!$suratMasuk->disposisi)
        <div class="text-sm text-yellow-800 bg-yellow-100 border border-yellow-200 p-4 rounded-lg">
            Menunggu disposisi dari pimpinan.
        </div>
    @endif

    <!-- Detail Surat -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Surat</label>
                <p class="text-gray-900 font-semibold">{{ $suratMasuk->nomor_surat }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">No. Agenda</label>
                <p class="text-gray-900 font-semibold">{{ $suratMasuk->no_agenda }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Surat Dari</label>
                <p class="text-gray-900">{{ $suratMasuk->surat_dari }}</p>
            </div>

            <!-- Sifat (diambil dari disposisi pimpinan) -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Sifat</label>

                @php
                    $sifat = $suratMasuk->disposisi?->sifat;
                    $badge = match ($sifat) {
                        'Sangat Segera' => 'bg-red-100 text-red-800',
                        'Segera' => 'bg-yellow-100 text-yellow-800',
                        'Rahasia' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <span class="px-3 py-1 text-sm rounded-full {{ $badge }}">
                    {{ $sifat ?? '-' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Surat</label>
                <p class="text-gray-900">
                    {{ optional($suratMasuk->tanggal_surat)->format('d F Y') ?? '-' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Diterima Tanggal</label>
                <p class="text-gray-900">
                    {{ optional($suratMasuk->diterima_tanggal)->format('d F Y') ?? '-' }}
                </p>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-2">Perihal</label>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $suratMasuk->perihal }}</p>
            </div>
        </div>

        @if($suratMasuk->file_surat)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-500 mb-2">File Surat</label>
                <a href="{{ Storage::url($suratMasuk->file_surat) }}" target="_blank"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat File PDF
                </a>
            </div>
        @endif
    </div>

    <!-- Disposisi (hasOne) -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Disposisi Pimpinan</h4>

        @if($suratMasuk->disposisi)
            @php
                $d = $suratMasuk->disposisi;
                $diteruskan = $d->diteruskan_kepada ?? [];
                $harap = $d->dengan_hormat_harap ?? [];
            @endphp

            <div class="border-l-4 border-blue-500 pl-4 py-2 space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Oleh</p>
                        <p class="font-semibold text-gray-900">{{ $d->user?->name ?? '-' }}</p>
                    </div>

                    <span class="px-3 py-1 text-xs rounded-full
                        {{ $d->status == 'Belum Selesai' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $d->status == 'Sedang Diproses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $d->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}">
                        {{ $d->status }}
                    </span>
                </div>

                <div class="text-sm text-gray-700">
                    <p><span class="text-gray-500">Tanggal Disposisi:</span> {{ optional($d->tanggal_disposisi)->format('d/m/Y') ?? '-' }}</p>
                    <p><span class="text-gray-500">Diteruskan Kepada:</span> {{ !empty($diteruskan) ? implode(', ', $diteruskan) : '-' }}</p>
                    <p><span class="text-gray-500">Dengan Hormat Harap:</span> {{ !empty($harap) ? implode(', ', $harap) : '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Catatan</p>
                    <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-800 whitespace-pre-wrap">
                        {{ $d->catatan_disposisi }}
                    </div>
                </div>
            </div>
        @else
            <p class="text-gray-500 text-center">Belum ada disposisi untuk surat ini</p>
        @endif
    </div>
</div>
@endsection
