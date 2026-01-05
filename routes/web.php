<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\Pimpinan\PimpinanDashboardController;
use Illuminate\Support\Facades\Route;

// Public Route
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirect setelah login berdasarkan role
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isPimpinan()) {
            return redirect()->route('pimpinan.dashboard');
        }
        
        abort(403, 'Role tidak dikenali.');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Surat Masuk Routes
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::get('surat-masuk/{suratMasuk}/print', [SuratMasukController::class, 'print'])->name('surat-masuk.print');
    
    // Surat Keluar Routes
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::get('surat-keluar/{suratKeluar}/print', [SuratKeluarController::class, 'print'])->name('surat-keluar.print');
    
    // Routes untuk Disposisi, Arsip akan ditambahkan di tahap berikutnya
    Route::get('/disposisi', fn() => view('admin.disposisi.index'))->name('disposisi.index');
    Route::get('/arsip', fn() => view('admin.arsip.index'))->name('arsip.index');
});

// Pimpinan Routes
Route::middleware(['auth', 'pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])->name('dashboard');
    
    // Routes untuk Disposisi, dll akan ditambahkan di tahap berikutnya
    // Temporary routes untuk menu sidebar
    Route::get('/surat-masuk', fn() => view('pimpinan.surat-masuk.index'))->name('surat-masuk.index');
    Route::get('/disposisi', fn() => view('pimpinan.disposisi.index'))->name('disposisi.index');
});

require __DIR__.'/auth.php';