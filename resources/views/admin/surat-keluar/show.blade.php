@extends('layouts.admin')

@section('title', 'Detail Surat Keluar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-slate-800">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-slate-400">/</span>
                    <a href="{{ route('admin.surat-keluar.index') }}" class="text-slate-600 hover:text-slate-800">
                        Surat Keluar
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-slate-400">/</span>
                    <span class="text-slate-800 font-medium">Detail</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Detail Surat Keluar</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.surat-keluar.edit', $suratKeluar->id) }}" 
               class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.surat-keluar.print', $suratKeluar->id) }}" 
               target="_blank"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </a>
            <a href="{{ route('admin.surat-keluar.index') }}" 
               class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nomor Surat -->
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Nomor Surat</label>
                <p class="text-slate-800 font-semibold">{{ $suratKeluar->nomor_surat }}</p>
            </div>

            <!-- Tujuan Surat -->
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Tujuan Surat</label>
                <p class="text-slate-800">{{ $suratKeluar->tujuan_surat }}</p>
            </div>

            <!-- Tanggal Surat -->
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Surat</label>
                <p class="text-slate-800">{{ \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d F Y') }}</p>
            </div>

            <!-- Tanggal Dikirim -->
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Dikirim</label>
                <p class="text-slate-800">{{ \Carbon\Carbon::parse($suratKeluar->tanggal_kirim)->format('d F Y') }}</p>
            </div>

            <!-- Sifat -->
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Sifat</label>
                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                    @if($suratKeluar->sifat === 'Sangat Segera') bg-red-100 text-red-800
                    @elseif($suratKeluar->sifat === 'Segera') bg-orange-100 text-orange-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ $suratKeluar->sifat }}
                </span>
            </div>

            <!-- Surat Masuk Terkait -->
            @if($suratKeluar->surat_masuk_id)
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Surat Masuk Terkait</label>
                <a href="{{ route('admin.surat-masuk.show', $suratKeluar->surat_masuk_id) }}" 
                   class="text-blue-600 hover:text-blue-800 hover:underline">
                    {{ $suratKeluar->suratMasuk->nomor_surat ?? '-' }}
                </a>
            </div>
            @endif

            <!-- Perihal (Full Width) -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-1">Perihal</label>
                <p class="text-slate-800 leading-relaxed">{{ $suratKeluar->perihal }}</p>
            </div>

            <!-- Isi Surat (Full Width) -->
            @if($suratKeluar->isi_surat)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-1">Isi Surat</label>
                <div class="bg-slate-50 p-4 rounded-lg">
                    <p class="text-slate-800 leading-relaxed whitespace-pre-line">{{ $suratKeluar->isi_surat }}</p>
                </div>
            </div>
            @endif

            <!-- File Surat -->
            @if($suratKeluar->file_surat)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-2">File Surat</label>
                <div class="flex items-center space-x-4">
                    <a href="{{ Storage::url($suratKeluar->file_surat) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat File PDF
                    </a>
                </div>
            </div>
            @endif

            <!-- Metadata -->
            <div class="md:col-span-2 pt-4 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-600">Dibuat:</span>
                        <span class="text-slate-800 ml-2">{{ $suratKeluar->created_at->format('d F Y, H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="text-slate-600">Terakhir Diubah:</span>
                        <span class="text-slate-800 ml-2">{{ $suratKeluar->updated_at->format('d F Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection