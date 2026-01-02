<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ProdukController;

// API Routes untuk Menu
Route::prefix('menus')->group(function () {
    Route::get('/', [MenuController::class, 'index']); // GET semua menu
    Route::get('/{id}', [MenuController::class, 'show']); // GET menu by ID
});

// API Routes untuk Produk
Route::prefix('produks')->group(function () {
    Route::get('/', [ProdukController::class, 'index']); // GET semua produk
    Route::get('/{id}', [ProdukController::class, 'show']); // GET produk by ID
});
