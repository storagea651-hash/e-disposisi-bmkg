@extends('layouts.pimpinan')

@section('page-title', 'Form Disposisi')

@section('content')
<div class="space-y-6">

    {{-- Detail Surat --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-2">Detail Surat</h3>
        <p><b>Nomor:</b> {{ $suratMasuk->nomor_surat }}</p>
        <p><b>Dari:</b> {{ $suratMasuk->surat_dari }}</p>
        <p><b>Perihal:</b> {{ $suratMasuk->perihal }}</p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form class="bg-white rounded-lg shadow p-6"
          action="{{ route('pimpinan.disposisi.store', $suratMasuk->id) }}"
          method="POST">
        @csrf

        {{-- Sifat --}}
        <div class="mb-6">
            <label class="block font-medium mb-2">Sifat <span class="text-red-500">*</span></label>
            <select name="sifat" class="w-full border rounded p-2">
                <option value="">-- Pilih Sifat --</option>
                @foreach($sifatOptions as $opt)
                    <option value="{{ $opt }}" {{ old('sifat') == $opt ? 'selected' : '' }}>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Diteruskan Kepada --}}
        <div class="mb-6">
            <label class="block font-medium mb-2">
                Diteruskan Kepada Saudara <span class="text-red-500">*</span>
            </label>
            <div class="space-y-2">
                @foreach($diteruskanOptions as $opt)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="diteruskan_kepada[]" value="{{ $opt }}"
                            {{ in_array($opt, old('diteruskan_kepada', [])) ? 'checked' : '' }}>
                        <span>{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Dengan Hormat Harap --}}
        <div class="mb-6">
            <label class="block font-medium mb-2">
                Dengan Hormat Harap <span class="text-red-500">*</span>
            </label>
            <div class="space-y-2">
                @foreach($harapanOptions as $opt)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="dengan_hormat_harap[]" value="{{ $opt }}"
                            {{ in_array($opt, old('dengan_hormat_harap', [])) ? 'checked' : '' }}>
                        <span>{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Catatan --}}
        <div class="mb-6">
            <label class="block font-medium mb-2">Catatan <span class="text-red-500">*</span></label>
            <textarea name="catatan_disposisi" rows="4"
                      class="w-full border rounded p-2">{{ old('catatan_disposisi') }}</textarea>
        </div>

        {{-- Button --}}
        <div class="flex gap-3">
            <button class="bg-slate-800 text-white px-5 py-2 rounded">
                Kirim ke Admin
            </button>
            <a href="{{ route('pimpinan.surat-masuk.index') }}"
               class="bg-gray-200 px-5 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
