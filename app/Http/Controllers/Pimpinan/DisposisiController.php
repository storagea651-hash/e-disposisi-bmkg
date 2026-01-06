<?php
namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index()
    {
        // Surat masuk yang sudah diinput admin (bisa semua, atau hanya yang belum didisposisi)
        $suratMasuk = SuratMasuk::with('disposisi')
            ->orderBy('diterima_tanggal', 'desc')
            ->paginate(10);

        return view('pimpinan.surat-masuk.index', compact('suratMasuk'));
    }

    public function create(SuratMasuk $suratMasuk)
    {
        // kalau sudah ada disposisi, bisa arahkan ke edit (opsional)
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
            'catatan' => 'required|string',
        ], [
            'sifat.required' => 'Sifat wajib dipilih',
            'diteruskan_kepada.required' => 'Diteruskan kepada minimal pilih 1',
            'dengan_hormat_harap.required' => 'Dengan hormat harap minimal pilih 1',
            'catatan.required' => 'Catatan wajib diisi',
        ]);

        Disposisi::create([
            'surat_masuk_id' => $suratMasuk->id,
            'pimpinan_id' => auth()->id(),
            'sifat' => $validated['sifat'],
            'diteruskan_kepada' => $validated['diteruskan_kepada'],
            'dengan_hormat_harap' => $validated['dengan_hormat_harap'],
            'catatan' => $validated['catatan'],
        ]);

        return redirect()->route('pimpinan.surat-masuk.index')
            ->with('success', 'Disposisi berhasil dikirim ke Admin.');
    }
}

