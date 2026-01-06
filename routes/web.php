<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\Pimpinan\PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\SuratMasukPimpinanController;
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

    Route::get('surat-masuk/{suratMasuk}/generate-disposisi', [SuratMasukController::class, 'generateDisposisi'])
    ->name('surat-masuk.generate-disposisi');

});

// Pimpinan Routes
// Pimpinan Routes
Route::middleware(['auth', 'pimpinan'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {

        // Dashboard Pimpinan
        Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])
            ->name('dashboard');

        // Surat Masuk (dari Admin)
        Route::get('/surat-masuk', [SuratMasukPimpinanController::class, 'index'])
            ->name('surat-masuk.index');

        // Form Disposisi Pimpinan
        Route::get('/disposisi', fn() => view('pimpinan.disposisi.index'))->name('disposisi.index');
        Route::get('/surat-masuk/{suratMasuk}/disposisi', [SuratMasukPimpinanController::class, 'create'])
            ->name('disposisi.create');
        

        // Simpan Disposisi
        Route::post('/surat-masuk/{suratMasuk}/disposisi', [SuratMasukPimpinanController::class, 'store'])
            ->name('disposisi.store');
    });


require __DIR__.'/auth.php';