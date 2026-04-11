<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect setelah login berdasarkan role
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('siswa.dashboard');
})->middleware('auth')->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('kelas', KelasController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('mata-pelajaran', MataPelajaranController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('absensi', AbsensiController::class);
    });

// Siswa routes
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/rekap', [SiswaDashboardController::class, 'rekap'])->name('rekap');
    });

require __DIR__.'/auth.php';
