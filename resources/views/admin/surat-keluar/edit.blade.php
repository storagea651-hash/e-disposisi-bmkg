@extends('layouts.admin')

@section('title', 'Edit Surat Keluar')

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
                    <span class="text-slate-800 font-medium">Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Edit Surat Keluar</h1>
        <a href="{{ route('admin.surat-keluar.show', $suratKeluar->id) }}" 
           class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-medium">Terjadi kesalahan:</p>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.surat-keluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Surat -->
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nomor_surat" 
                           id="nomor_surat" 
                           value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           placeholder="Contoh: 001/SK-BMKG/I/2026"
                           required>
                    @error('nomor_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tujuan Surat -->
                <div>
                    <label for="tujuan_surat" class="block text-sm font-medium text-slate-700 mb-2">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="tujuan_surat" 
                           id="tujuan_surat" 
                           value="{{ old('tujuan_surat', $suratKeluar->tujuan_surat) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           placeholder="Contoh: Dinas Perhubungan Kota Balikpapan"
                           required>
                    @error('tujuan_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_surat" 
                           id="tanggal_surat" 
                           value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           required>
                    @error('tanggal_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Dikirim -->
                <div>
                    <label for="tanggal_kirim" class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal Dikirim <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_kirim" 
                           id="tanggal_kirim" 
                           value="{{ old('tanggal_kirim', $suratKeluar->tanggal_kirim) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           required>
                    @error('tanggal_kirim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sifat -->
                <div>
                    <label for="sifat" class="block text-sm font-medium text-slate-700 mb-2">
                        Sifat <span class="text-red-500">*</span>
                    </label>
                    <select name="sifat" 
                            id="sifat" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                            required>
                        <option value="">-- Pilih Sifat --</option>
                        <option value="Sangat Segera" {{ old('sifat', $suratKeluar->sifat) === 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                        <option value="Segera" {{ old('sifat', $suratKeluar->sifat) === 'Segera' ? 'selected' : '' }}>Segera</option>
                        <option value="Rahasia" {{ old('sifat', $suratKeluar->sifat) === 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                    </select>
                    @error('sifat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Surat Masuk Terkait -->
                <div>
                    <label for="surat_masuk_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Surat Masuk Terkait (Opsional)
                    </label>
                    <select name="surat_masuk_id" 
                            id="surat_masuk_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                        <option value="">-- Pilih Surat Masuk --</option>
                        @foreach($suratMasukList as $sm)
                            <option value="{{ $sm->id }}" {{ old('surat_masuk_id', $suratKeluar->surat_masuk_id) == $sm->id ? 'selected' : '' }}>
                                {{ $sm->nomor_surat }} - {{ Str::limit($sm->perihal, 50) }}
                            </option>
                        @endforeach
                    </select>
                    @error('surat_masuk_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Perihal (Full Width) -->
                <div class="md:col-span-2">
                    <label for="perihal" class="block text-sm font-medium text-slate-700 mb-2">
                        Perihal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="perihal" 
                           id="perihal" 
                           value="{{ old('perihal', $suratKeluar->perihal) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                           placeholder="Contoh: Permohonan Data Cuaca Bulanan"
                           required>
                    @error('perihal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi Surat (Full Width) -->
                <div class="md:col-span-2">
                    <label for="isi_surat" class="block text-sm font-medium text-slate-700 mb-2">
                        Isi Surat (Opsional)
                    </label>
                    <textarea name="isi_surat" 
                              id="isi_surat" 
                              rows="6"
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent"
                              placeholder="Masukkan isi surat...">{{ old('isi_surat', $suratKeluar->isi_surat) }}</textarea>
                    @error('isi_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Surat (Full Width) -->
                <div class="md:col-span-2">
                    <label for="file_surat" class="block text-sm font-medium text-slate-700 mb-2">
                        File Surat (PDF - Opsional)
                    </label>
                    
                    @if($suratKeluar->file_surat)
                        <div class="mb-3 flex items-center gap-3 bg-slate-50 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-slate-800 font-medium">File Saat Ini:</p>
                                <p class="text-sm text-slate-600">{{ basename($suratKeluar->file_surat) }}</p>
                            </div>
                            <a href="{{ Storage::url($suratKeluar->file_surat) }}" 
                               target="_blank"
                               class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                Lihat
                            </a>
                        </div>
                    @endif

                    <input type="file" 
                           name="file_surat" 
                           id="file_surat" 
                           accept=".pdf"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-slate-500">Upload file PDF baru jika ingin mengganti file lama. Maksimal 5MB.</p>
                    @error('file_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.surat-keluar.show', $suratKeluar->id) }}" 
                   class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection