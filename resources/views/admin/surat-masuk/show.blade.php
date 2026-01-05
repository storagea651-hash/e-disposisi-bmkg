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
        <div class="flex space-x-2">
            <a href="{{ route('admin.surat-masuk.print', $suratMasuk->id) }}" target="_blank" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </a>
            <a href="{{ route('admin.surat-masuk.edit', $suratMasuk->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nomor Surat -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Surat</label>
                <p class="text-gray-900 font-semibold">{{ $suratMasuk->nomor_surat }}</p>
            </div>

            <!-- No Agenda -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">No. Agenda</label>
                <p class="text-gray-900 font-semibold">{{ $suratMasuk->no_agenda }}</p>
            </div>

            <!-- Surat Dari -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Surat Dari</label>
                <p class="text-gray-900">{{ $suratMasuk->surat_dari }}</p>
            </div>

            <!-- Sifat -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Sifat</label>
                <span class="px-3 py-1 text-sm rounded-full
                    {{ $suratMasuk->sifat == 'Sangat Segera' ? 'bg-red-100 text-red-800' : '' }}
                    {{ $suratMasuk->sifat == 'Segera' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $suratMasuk->sifat == 'Rahasia' ? 'bg-purple-100 text-purple-800' : '' }}">
                    {{ $suratMasuk->sifat }}
                </span>
            </div>

            <!-- Tanggal Surat -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Surat</label>
                <p class="text-gray-900">{{ $suratMasuk->tanggal_surat->format('d F Y') }}</p>
            </div>

            <!-- Diterima Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Diterima Tanggal</label>
                <p class="text-gray-900">{{ $suratMasuk->diterima_tanggal->format('d F Y') }}</p>
            </div>
        </div>

        <!-- Perihal -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-2">Perihal</label>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $suratMasuk->perihal }}</p>
            </div>
        </div>

        <!-- File Surat -->
        @if($suratMasuk->file_surat)
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-2">File Surat</label>
            <div class="flex items-center space-x-4">
                <a href="{{ Storage::url($suratMasuk->file_surat) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat File PDF
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Disposisi -->
    @if($suratMasuk->disposisi->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Disposisi</h4>
        <div class="space-y-4">
            @foreach($suratMasuk->disposisi as $disposisi)
            <div class="border-l-4 border-blue-500 pl-4 py-2">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $disposisi->tujuan_disposisi }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $disposisi->catatan_disposisi }}</p>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span>Oleh: {{ $disposisi->user->name }}</span>
                            <span>•</span>
                            <span>{{ $disposisi->tanggal_disposisi->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full
                        {{ $disposisi->status == 'Belum Selesai' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $disposisi->status == 'Sedang Diproses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $disposisi->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}">
                        {{ $disposisi->status }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-6">
        <p class="text-gray-500 text-center">Belum ada disposisi untuk surat ini</p>
    </div>
    @endif
</div>
@endsection