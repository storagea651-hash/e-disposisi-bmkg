<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanDashboardController extends Controller
{
    /**
     * Display the pimpinan dashboard.
     */
    public function index()
    {
        $userId = auth()->id();

        // Get total surat masuk
        $totalSuratMasuk = SuratMasuk::count();

        // Get surat masuk that haven't been dispositioned yet
        $suratBelumDisposisi = SuratMasuk::whereDoesntHave('disposisi')->count();

        // Get total disposisi created by this pimpinan
        $totalDisposisiSaya = Disposisi::where('user_id', $userId)->count();

        // Get disposisi by status (only by this pimpinan)
        $disposisiByStatus = Disposisi::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Get recent surat masuk (that need disposition)
        $recentSuratMasuk = SuratMasuk::whereDoesntHave('disposisi')
            ->orderBy('diterima_tanggal', 'desc')
            ->take(5)
            ->get();

        // Get recent disposisi by this pimpinan
        $recentDisposisi = Disposisi::with('suratMasuk')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get surat by sifat (urgent ones)
        $suratBySifat = SuratMasuk::whereDoesntHave('disposisi')
            ->select('sifat', DB::raw('count(*) as total'))
            ->groupBy('sifat')
            ->get()
            ->pluck('total', 'sifat')
            ->toArray();

        return view('pimpinan.dashboard', compact(
            'totalSuratMasuk',
            'suratBelumDisposisi',
            'totalDisposisiSaya',
            'disposisiByStatus',
            'recentSuratMasuk',
            'recentDisposisi',
            'suratBySifat'
        ));
    }
}