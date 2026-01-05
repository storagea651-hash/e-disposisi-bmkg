@extends('layouts.admin')

@section('page-title', 'Edit Surat Masuk')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.surat-masuk.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h3 class="text-2xl font-bold text-gray-800">Edit Surat Masuk</h3>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <!-- Debug Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <p class="font-bold">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Surat -->
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat', $suratMasuk->nomor_surat) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('nomor_surat') border-red-500 @enderror"
                           placeholder="Contoh: 001/SM/2026">
                    @error('nomor_surat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Surat Dari -->
                <div>
                    <label for="surat_dari" class="block text-sm font-medium text-gray-700 mb-2">
                        Surat Dari <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="surat_dari" id="surat_dari" value="{{ old('surat_dari', $suratMasuk->surat_dari) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('surat_dari') border-red-500 @enderror"
                           placeholder="Contoh: Kementerian Dalam Negeri">
                    @error('surat_dari')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat->format('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('tanggal_surat') border-red-500 @enderror">
                    @error('tanggal_surat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diterima Tanggal -->
                <div>
                    <label for="diterima_tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Diterima Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="diterima_tanggal" id="diterima_tanggal" value="{{ old('diterima_tanggal', $suratMasuk->diterima_tanggal->format('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('diterima_tanggal') border-red-500 @enderror">
                    @error('diterima_tanggal')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Agenda -->
                <div>
                    <label for="no_agenda" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Agenda <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_agenda" id="no_agenda" value="{{ old('no_agenda', $suratMasuk->no_agenda) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('no_agenda') border-red-500 @enderror"
                           placeholder="Contoh: AG-2026-0001">
                    @error('no_agenda')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sifat -->
                <div>
                    <label for="sifat" class="block text-sm font-medium text-gray-700 mb-2">
                        Sifat <span class="text-red-500">*</span>
                    </label>
                    <select name="sifat" id="sifat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('sifat') border-red-500 @enderror">
                        <option value="">-- Pilih Sifat --</option>
                        <option value="Sangat Segera" {{ old('sifat', $suratMasuk->sifat) == 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                        <option value="Segera" {{ old('sifat', $suratMasuk->sifat) == 'Segera' ? 'selected' : '' }}>Segera</option>
                        <option value="Rahasia" {{ old('sifat', $suratMasuk->sifat) == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                    </select>
                    @error('sifat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Perihal -->
            <div class="mt-6">
                <label for="perihal" class="block text-sm font-medium text-gray-700 mb-2">
                    Perihal <span class="text-red-500">*</span>
                </label>
                <textarea name="perihal" id="perihal" rows="4" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('perihal') border-red-500 @enderror"
                          placeholder="Tulis perihal surat...">{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                @error('perihal')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Surat -->
            <div class="mt-6">
                <label for="file_surat" class="block text-sm font-medium text-gray-700 mb-2">
                    File Surat (PDF, Max 2MB)
                </label>
                
                @if($suratMasuk->file_surat)
                <div class="mb-3">
                    <p class="text-sm text-gray-600 mb-2">File saat ini:</p>
                    <a href="{{ Storage::url($suratMasuk->file_surat) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat file yang ada
                    </a>
                </div>
                @endif

                <input type="file" name="file_surat" id="file_surat" accept=".pdf"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('file_surat') border-red-500 @enderror">
                @error('file_surat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    @if($suratMasuk->file_surat)
                        Upload file baru untuk mengganti file yang ada. 
                    @endif
                    Format: PDF, Ukuran maksimal: 2MB
                </p>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex space-x-3">
                <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-2 rounded-lg">
                    Update
                </button>
                <a href="{{ route('admin.surat-masuk.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection