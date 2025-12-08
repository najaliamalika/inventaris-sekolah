<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\PeminjamanController;
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
    Route::get('/item', [ItemController::class, 'index'])->name('item.index');
    Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('/item', [ItemController::class, 'store'])->name('item.store');
    Route::get('/item/{item_id}', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/item/{item_id}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/item/{item_id}', [ItemController::class, 'destroy'])->name('item.destroy');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [ PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman_id}', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{peminjaman_id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{peminjaman_id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Barang Masuk Routes
    Route::get('/barang-masuk', [MasukController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/create', [MasukController::class, 'create'])->name('barang-masuk.create');
    Route::post('/barang-masuk', [MasukController::class, 'store'])->name('barang-masuk.store');
    Route::get('/barang-masuk/{masuk_id}', [MasukController::class, 'edit'])->name('barang-masuk.edit');
    Route::put('/barang-masuk/{masuk_id}', [MasukController::class, 'update'])->name('barang-masuk.update');
    Route::delete('/barang-masuk/{masuk_id}', [MasukController::class, 'destroy'])->name('barang-masuk.destroy');

    // Barang Keluar Routes
    Route::get('/barang-keluar', [KeluarController::class, 'index'])->name('barang-keluar.index');
    Route::get('/barang-keluar/create', [KeluarController::class, 'create'])->name('barang-keluar.create');
    Route::post('/barang-keluar', [KeluarController::class, 'store'])->name('barang-keluar.store');
    Route::get('/barang-keluar/{keluar_id}', [KeluarController::class, 'edit'])->name('barang-keluar.edit');
    Route::put('/barang-keluar/{keluar_id}', [KeluarController::class, 'update'])->name('barang-keluar.update');
    Route::delete('/barang-keluar/{keluar_id}', [KeluarController::class, 'destroy'])->name('barang-keluar.destroy');
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
