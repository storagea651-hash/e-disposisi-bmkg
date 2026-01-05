<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\ArsipSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get total counts
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalDisposisi = Disposisi::count();
        $totalArsip = ArsipSurat::count();

        // Get recent surat masuk (5 latest)
        $recentSuratMasuk = SuratMasuk::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get surat masuk by sifat (for chart/stats)
        $suratBySifat = SuratMasuk::select('sifat', DB::raw('count(*) as total'))
            ->groupBy('sifat')
            ->get()
            ->pluck('total', 'sifat')
            ->toArray();

        // Get monthly statistics (current year)
        $currentYear = date('Y');
        $monthlySuratMasuk = SuratMasuk::selectRaw('MONTH(tanggal_surat) as month, COUNT(*) as total')
            ->whereYear('tanggal_surat', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlySuratKeluar = SuratKeluar::selectRaw('MONTH(tanggal_surat) as month, COUNT(*) as total')
            ->whereYear('tanggal_surat', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Get disposisi statistics
        $disposisiByStatus = Disposisi::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Recent disposisi
        $recentDisposisi = Disposisi::with(['suratMasuk', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ensure all variables are defined
        $totalArsip = $totalArsip ?? 0;
        $suratBySifat = $suratBySifat ?? [];
        $disposisiByStatus = $disposisiByStatus ?? [];

        return view('admin.dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalDisposisi',
            'totalArsip',
            'recentSuratMasuk',
            'suratBySifat',
            'monthlySuratMasuk',
            'monthlySuratKeluar',
            'disposisiByStatus',
            'recentDisposisi'
        ));
    }
}