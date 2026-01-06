@extends('layouts.pimpinan')

@section('page-title', 'Surat Masuk (Pimpinan)')

@section('content')
<div class="bg-white rounded-lg shadow p-6">

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-left">
                <th class="py-2">Nomor Surat</th>
                <th class="py-2">Dari</th>
                <th class="py-2">Perihal</th>
                <th class="py-2">Status</th>
                <th class="py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($suratMasuk as $surat)
            <tr class="border-b">
                <td class="py-2">{{ $surat->nomor_surat }}</td>
                <td class="py-2">{{ $surat->surat_dari }}</td>
                <td class="py-2">{{ $surat->perihal }}</td>
                <td class="py-2">
                    @if($surat->disposisi)
                        <span class="text-green-600 font-medium">Sudah Disposisi</span>
                    @else
                        <span class="text-orange-600 font-medium">Menunggu</span>
                    @endif
                </td>
                <td class="py-2">
                    @if(!$surat->disposisi)
                        <a href="{{ route('pimpinan.disposisi.create', $surat->id) }}"
                           class="bg-slate-800 text-white px-3 py-1 rounded">
                           Isi Disposisi
                        </a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-4 text-center text-gray-500">
                    Tidak ada surat masuk
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $suratMasuk->links() }}
    </div>
</div>
@endsection
