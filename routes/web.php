<?php

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route khusus admin
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

    });


// Route khusus kasir
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->group(function () {
    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
});

// Home
Route::get('/', function () {
    return redirect('/login');
});

use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Manajemen User - CRUD lengkap + nama route
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');
});






use App\Http\Controllers\Admin\LaporanController;

Route::get('/admin/laporan', [LaporanController::class, 'index'])->middleware('auth');
Route::post('/admin/laporan/filter', [LaporanController::class, 'filter'])->middleware('auth');
Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');

Route::get('/admin/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
Route::get('/admin/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');


use App\Http\Controllers\Admin\ProdukController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('produk', ProdukController::class);
    });


    use App\Http\Controllers\Admin\StokController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.stok.')->group(function () {
    Route::get('/stok', [StokController::class, 'index'])->name('index');
    Route::get('/stok/masuk', [StokController::class, 'masuk'])->name('masuk');
    Route::post('/stok/masuk', [StokController::class, 'storeMasuk']);
    Route::get('/stok/keluar', [StokController::class, 'keluar'])->name('keluar');
    Route::post('/stok/keluar', [StokController::class, 'storeKeluar']);
    Route::get('/stok/riwayat', [StokController::class, 'riwayat'])->name('riwayat');
});


use App\Http\Controllers\Admin\VoidController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/void', [VoidController::class, 'index'])->name('void.index');
    Route::post('/void/{transaksi}', [VoidController::class, 'prosesVoid'])->name('void.proses');
});



////KASIRRR


use App\Http\Controllers\Kasir\KasirController;

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/buka', [KasirController::class, 'bukaKasirForm'])->name('buka');
    Route::post('/buka', [KasirController::class, 'bukaKasir']);
    Route::get('/pos', [KasirController::class, 'index'])->name('pos');
    Route::post('/tambah', [KasirController::class, 'tambahKeKeranjang'])->name('tambah');
    Route::delete('/hapus/{id}', [KasirController::class, 'hapusDariKeranjang'])->name('hapus');
    Route::post('/bayar', [KasirController::class, 'bayar'])->name('bayar');
    Route::get('/tutup', [KasirController::class, 'tutupKasirForm'])->name('tutup.form');
    Route::post('/tutup', [KasirController::class, 'tutupKasir'])->name('tutup');
    Route::get('/daftar', [KasirController::class, 'daftarPenjualan'])->name('daftar');
    Route::get('/cetak/{id}', [KasirController::class, 'cetak'])->name('cetak');


    Route::get('/update-stok', [KasirController::class, 'updateStokForm'])->name('update-stok');
    Route::post('/update-stok', [KasirController::class, 'updateStokProses']);
});