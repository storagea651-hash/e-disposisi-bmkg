<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use Illuminate\Http\Request;

class SuratMasukPimpinanController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with('disposisi')
            ->orderBy('diterima_tanggal', 'desc')
            ->paginate(10);

        return view('pimpinan.surat-masuk.index', compact('suratMasuk'));
    }

    public function create(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->disposisi) {
            return redirect()->route('pimpinan.surat-masuk.index')
                ->with('success', 'Surat ini sudah didisposisi.');
        }

        $diteruskanOptions = [
            'Petugas Tata Usaha dan Keuangan',
            'PPK',
            'Operasional',
            'Koordinator Operasional',
        ];

        $harapanOptions = [
            'Memberi Tanggapan/Saran',
            'Proses Lebih Lanjut',
            'Koordinasi/Konfirmasi',
        ];

        $sifatOptions = ['Sangat Segera', 'Segera', 'Rahasia'];

        return view('pimpinan.disposisi.create', compact(
            'suratMasuk',
            'diteruskanOptions',
            'harapanOptions',
            'sifatOptions'
        ));
    }

    public function store(Request $request, SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->disposisi) {
            return redirect()->route('pimpinan.surat-masuk.index')
                ->with('success', 'Surat ini sudah didisposisi.');
        }

        $validated = $request->validate([
            'sifat' => 'required|in:Sangat Segera,Segera,Rahasia',
            'diteruskan_kepada' => 'required|array|min:1',
            'diteruskan_kepada.*' => 'string|max:255',
            'dengan_hormat_harap' => 'required|array|min:1',
            'dengan_hormat_harap.*' => 'string|max:255',
            'catatan_disposisi' => 'required|string',
        ]);

        Disposisi::create([
            'surat_masuk_id' => $suratMasuk->id,
            'user_id' => auth()->id(),
            'tujuan_disposisi' => 'multi',
            'catatan_disposisi' => $validated['catatan_disposisi'],
            'tanggal_disposisi' => now()->toDateString(),
            'status' => 'Belum Selesai',
            'sifat' => $validated['sifat'],
            'diteruskan_kepada' => $validated['diteruskan_kepada'],
            'dengan_hormat_harap' => $validated['dengan_hormat_harap'],
        ]);

        return redirect()->route('pimpinan.surat-masuk.index')
            ->with('success', 'Disposisi berhasil dikirim ke Admin.');
    }
}
