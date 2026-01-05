@extends('layouts.admin')

@section('page-title', 'Tambah Surat Keluar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.surat-keluar.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h3 class="text-2xl font-bold text-gray-800">Tambah Surat Keluar</h3>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
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

        <form action="{{ route('admin.surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Surat -->
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('nomor_surat') border-red-500 @enderror"
                           placeholder="Contoh: 001/SK/2026">
                    @error('nomor_surat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tujuan Surat -->
                <div>
                    <label for="tujuan_surat" class="block text-sm font-medium text-gray-700 mb-2">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tujuan_surat" id="tujuan_surat" value="{{ old('tujuan_surat') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('tujuan_surat') border-red-500 @enderror"
                           placeholder="Contoh: Kementerian Dalam Negeri">
                    @error('tujuan_surat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('tanggal_surat') border-red-500 @enderror">
                    @error('tanggal_surat')
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
                        <option value="Sangat Segera" {{ old('sifat') == 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                        <option value="Segera" {{ old('sifat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                        <option value="Rahasia" {{ old('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                    </select>
                    @error('sifat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Balasan dari Surat Masuk (Optional) -->
                <div class="md:col-span-2">
                    <label for="surat_masuk_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Balasan dari Surat Masuk (Opsional)
                    </label>
                    <select name="surat_masuk_id" id="surat_masuk_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent">
                        <option value="">-- Tidak ada --</option>
                        @foreach($suratMasuk as $sm)
                            <option value="{{ $sm->id }}" {{ old('surat_masuk_id') == $sm->id ? 'selected' : '' }}>
                                {{ $sm->nomor_surat }} - {{ $sm->surat_dari }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Pilih jika surat keluar ini merupakan balasan dari surat masuk</p>
                </div>
            </div>

            <!-- Perihal -->
            <div class="mt-6">
                <label for="perihal" class="block text-sm font-medium text-gray-700 mb-2">
                    Perihal <span class="text-red-500">*</span>
                </label>
                <textarea name="perihal" id="perihal" rows="4" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('perihal') border-red-500 @enderror"
                          placeholder="Tulis perihal surat...">{{ old('perihal') }}</textarea>
                @error('perihal')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Surat -->
            <div class="mt-6">
                <label for="file_surat" class="block text-sm font-medium text-gray-700 mb-2">
                    File Surat (PDF, Max 2MB)
                </label>
                <input type="file" name="file_surat" id="file_surat" accept=".pdf"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('file_surat') border-red-500 @enderror">
                @error('file_surat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Format: PDF, Ukuran maksimal: 2MB</p>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex space-x-3">
                <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-2 rounded-lg">
                    Simpan
                </button>
                <a href="{{ route('admin.surat-keluar.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection