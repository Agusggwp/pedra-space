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

    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
        ->name('users.resetPassword');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

    // Route detail user untuk modal AJAX (paling bawah agar tidak menimpa /create)
    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');

    // Tambahkan route show di dalam group kategori
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('admin.category.show');
});




use App\Http\Controllers\Admin\LaporanController;

Route::get('/admin/laporan', [LaporanController::class, 'index'])->middleware('auth');
Route::post('/admin/laporan/filter', [LaporanController::class, 'filter'])->middleware('auth');
Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');

Route::get('/admin/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
Route::get('/admin/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');

// 🔥 NEW Routes for Shift Report
Route::get('/admin/laporan-shift', [LaporanController::class, 'laporanShift'])->name('laporan.shift');
Route::get('/admin/laporan-shift/{id}', [LaporanController::class, 'showShift'])->name('laporan.shift.show');
Route::get('/admin/laporan-shift/{id}/export/pdf', [LaporanController::class, 'exportShiftDetailPdf'])->name('laporan.shift.detail.pdf');
Route::get('/admin/laporan-shift/{id}/export/excel', [LaporanController::class, 'exportShiftDetailExcel'])->name('laporan.shift.detail.excel');

// 🔥 NEW Routes for Keuntungan Report
Route::get('/admin/laporan-keuntungan', [LaporanController::class, 'laporanKeuntungan'])->name('laporan.keuntungan');
Route::get('/admin/laporan-keuntungan/export/pdf', [LaporanController::class, 'exportKeuntunganPdf'])->name('laporan.keuntungan.pdf');
Route::get('/admin/laporan-keuntungan/export/excel', [LaporanController::class, 'exportKeuntunganExcel'])->name('laporan.keuntungan.excel');


use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('menu', MenuController::class);
        Route::patch('menu/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');
    });


    use App\Http\Controllers\Admin\StokController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.stok.')->group(function () {
    Route::get('/stok', [StokController::class, 'index'])->name('index');
    Route::get('/stok/masuk', [StokController::class, 'masuk'])->name('masuk');
    Route::post('/stok/masuk', [StokController::class, 'storeMasuk']);
    Route::get('/stok/keluar', [StokController::class, 'keluar'])->name('keluar');
    Route::post('/stok/keluar', [StokController::class, 'storeKeluar']);
    Route::get('/stok/riwayat', [StokController::class, 'riwayat'])->name('riwayat');
    Route::get('/stok/riwayat/export/pdf', [StokController::class, 'exportRiwayatPdf'])->name('riwayat.pdf');
});


use App\Http\Controllers\Admin\VoidController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/void', [VoidController::class, 'index'])->name('void.index');
    Route::post('/void/{transaksi}', [VoidController::class, 'prosesVoid'])->name('void.proses');
    Route::get('/void/export/pdf', [VoidController::class, 'exportVoidPdf'])->name('void.pdf');
});


use App\Http\Controllers\Admin\DiskonController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.diskon.')->group(function () {
    // Main
    Route::get('/diskon', [DiskonController::class, 'index'])->name('index');
    
    // Diskon Produk
    Route::get('/diskon/produk', [DiskonController::class, 'produk'])->name('produk');
    Route::get('/diskon/produk/create', [DiskonController::class, 'createProduk'])->name('produk.create');
    Route::post('/diskon/produk', [DiskonController::class, 'storeProduk'])->name('produk.store');
    Route::get('/diskon/produk/{diskon}/edit', [DiskonController::class, 'editProduk'])->name('produk.edit');
    Route::put('/diskon/produk/{diskon}', [DiskonController::class, 'updateProduk'])->name('produk.update');
    
    // Diskon Menu
    Route::get('/diskon/menu', [DiskonController::class, 'menu'])->name('menu');
    Route::get('/diskon/menu/create', [DiskonController::class, 'createMenu'])->name('menu.create');
    Route::post('/diskon/menu', [DiskonController::class, 'storeMenu'])->name('menu.store');
    Route::get('/diskon/menu/{diskon}/edit', [DiskonController::class, 'editMenu'])->name('menu.edit');
    Route::put('/diskon/menu/{diskon}', [DiskonController::class, 'updateMenu'])->name('menu.update');
    
    // Diskon Kategori
    Route::get('/diskon/kategori', [DiskonController::class, 'kategori'])->name('kategori');
    Route::get('/diskon/kategori/create', [DiskonController::class, 'createKategori'])->name('kategori.create');
    Route::post('/diskon/kategori', [DiskonController::class, 'storeKategori'])->name('kategori.store');
    Route::get('/diskon/kategori/{diskon}/edit', [DiskonController::class, 'editKategori'])->name('kategori.edit');
    Route::put('/diskon/kategori/{diskon}', [DiskonController::class, 'updateKategori'])->name('kategori.update');
    
    // Diskon Umum
    Route::get('/diskon/umum', [DiskonController::class, 'umum'])->name('umum');
    Route::get('/diskon/umum/create', [DiskonController::class, 'createUmum'])->name('umum.create');
    Route::post('/diskon/umum', [DiskonController::class, 'storeUmum'])->name('umum.store');
    Route::get('/diskon/umum/{diskon}/edit', [DiskonController::class, 'editUmum'])->name('umum.edit');
    Route::put('/diskon/umum/{diskon}', [DiskonController::class, 'updateUmum'])->name('umum.update');
    
    // Delete & Toggle
    Route::delete('/diskon/{diskon}', [DiskonController::class, 'destroy'])->name('destroy');
    Route::patch('/diskon/{diskon}/toggle', [DiskonController::class, 'toggle'])->name('toggle');
});


////KASIRRR

use App\Http\Controllers\Kasir\KasirController;

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/buka', [KasirController::class, 'bukaKasirForm'])->name('buka');
    Route::post('/buka', [KasirController::class, 'bukaKasir']);
    Route::get('/pos', [KasirController::class, 'index'])->name('pos');
    Route::post('/tambah', [KasirController::class, 'tambahKeKeranjang'])->name('tambah');
    Route::post('/tambah-menu', [KasirController::class, 'tambahMenuKeKeranjang'])->name('tambah.menu');
    Route::delete('/hapus/{id}', [KasirController::class, 'hapusDariKeranjang'])->name('hapus');
    Route::post('/update-jumlah', [KasirController::class, 'updateJumlahKeranjang'])->name('update.jumlah');
    Route::post('/bayar', [KasirController::class, 'bayar'])->name('bayar');
    Route::get('/tutup', [KasirController::class, 'tutupKasirForm'])->name('tutup.form');
    Route::post('/tutup', [KasirController::class, 'tutupKasir'])->name('tutup');
    Route::get('/daftar', [KasirController::class, 'daftarPenjualan'])->name('daftar');
    Route::get('/cetak/{id}', [KasirController::class, 'cetak'])->name('cetak');
    Route::get('/update-stok', [KasirController::class, 'updateStokForm'])->name('update-stok');
    Route::post('/update-stok', [KasirController::class, 'updateStokProses']);
});

