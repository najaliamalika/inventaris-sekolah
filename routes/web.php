<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ReportController;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/{jenis_barang_id}/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', action: [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{jenis_barang_id}/{barang_id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::get('/barang/{barang_id}', [BarangController::class, 'show'])->name('barang.show');
    Route::put('/barang/{barang_id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{barang_id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
    Route::get('/jenis-barang/create', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
    Route::post('/jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
    Route::get('/jenis-barang/{jenis_barang_id}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
    Route::get('/jenis-barang/{jenis_barang_id}', [JenisBarangController::class, 'show'])->name('jenis-barang.show');
    Route::put('/jenis-barang/{jenis_barang_id}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::delete('/jenis-barang/{jenis_barang_id}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');

    Route::resource('peminjaman', PeminjamanController::class);
    Route::post('/peminjaman/barang/{peminjaman_barang_id}/kembalikan', [PeminjamanController::class, 'kembalikanBarang'])->name('peminjaman.kembalikan-barang');

    // Barang Masuk Routes
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
    Route::get('/barang-masuk/{masuk_id}', [BarangMasukController::class, 'show'])->name('barang-masuk.show');
    Route::get('/barang-masuk/{masuk_id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
    Route::put('/barang-masuk/{masuk_id}', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
    Route::delete('/barang-masuk/{masuk_id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');

    // Barang Keluar Routes
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
    Route::get('/barang-keluar/{keluar_id}', [BarangKeluarController::class, 'show'])->name('barang-keluar.show');
    Route::get('/barang-keluar/{keluar_id}/edit', [BarangKeluarController::class, 'edit'])->name('barang-keluar.edit');
    Route::put('/barang-keluar/{keluar_id}', [BarangKeluarController::class, 'update'])->name('barang-keluar.update');
    Route::delete('/barang-keluar/{keluar_id}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');
    Route::get('/barang-keluar/get-available-barang/{jenis_barang_id}', [BarangKeluarController::class, 'getAvailableBarang'])->name('barang-keluar.get-available-barang');

    // Pengajuan Routes
    Route::resource('pengajuan', PengajuanController::class);
    Route::post('/pengajuan/{pengajuan_id}/update-status', [PengajuanController::class, 'updateStatus'])
        ->name('pengajuan.update-status');
    Route::get('/api/pengajuan/available-barang/{jenisBarangId}', [PengajuanController::class, 'getAvailableBarangForPerbaikan'])
        ->name('pengajuan.available-barang');

    // Halaman Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Download Laporan
    Route::post('/reports/peminjaman', [ReportController::class, 'peminjamanReport'])->name('reports.peminjaman');
    Route::post('/reports/barang-masuk', [ReportController::class, 'barangMasukReport'])->name('reports.barang-masuk');
    Route::post('/reports/barang-keluar', [ReportController::class, 'barangKeluarReport'])->name('reports.barang-keluar');
    Route::post('/reports/pengajuan', [ReportController::class, 'pengajuanReport'])->name('reports.pengajuan');

    Route::post('/reports/laporan-tahunan', [ReportController::class, 'laporanTahunan'])->name('reports.tahunan');
});

Route::get('/', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
