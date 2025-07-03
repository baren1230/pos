<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\PembelianItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect(auth()->user()->role === 'admin' ? '/admin' : '/kasir');
    })->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'index']);

        Route::get('setting', [\App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
        Route::post('setting/update-qris-image', [\App\Http\Controllers\SettingController::class, 'updateQrisImage'])->name('admin.settings.updateQrisImage');
        Route::post('setting/update-logo-image', [\App\Http\Controllers\SettingController::class, 'updateLogoImage'])->name('admin.settings.updateLogoImage');

        Route::resource('produk', ProdukController::class);
        Route::post('produk/{produk}/purchase', [ProdukController::class, 'purchase'])->name('produk.purchase');
        Route::get('produk/produk-view', [ProdukController::class, 'produkView'])->name('produk.produk');

        Route::get('produk/kategori', [ProdukController::class, 'kategori'])->name('produk.kategori');

        Route::resource('kategori', \App\Http\Controllers\CategoryController::class)->names('kategori');

        Route::resource('users', \App\Http\Controllers\UserController::class)->names('users');

Route::resource('supplier', SupplierController::class)->names('admin.supplier');

        // Laporan routes
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('stok-produk', [\App\Http\Controllers\LaporanController::class, 'stokProduk'])->name('stok_produk');
            Route::get('pembelian', [\App\Http\Controllers\LaporanController::class, 'pembelian'])->name('pembelian');
            Route::get('penjualan', [\App\Http\Controllers\LaporanController::class, 'penjualan'])->name('penjualan');
            Route::get('pengeluaran', [\App\Http\Controllers\LaporanController::class, 'pengeluaran'])->name('pengeluaran');
            Route::post('pengeluaran', [\App\Http\Controllers\LaporanController::class, 'storePengeluaran'])->name('pengeluaran.store');
            Route::put('pengeluaran/{id}', [\App\Http\Controllers\LaporanController::class, 'updatePengeluaran'])->name('pengeluaran.update');
            Route::delete('pengeluaran/{id}', [\App\Http\Controllers\LaporanController::class, 'destroyPengeluaran'])->name('pengeluaran.destroy');
            Route::get('laba-rugi', [\App\Http\Controllers\LaporanController::class, 'labaRugi'])->name('laba_rugi');
        });

        // Produk pembelian route
        // Route::get('produk/pembelian_produk', [\App\Http\Controllers\LaporanController::class, 'pembelianProduk'])->name('produk.pembelian_produk');

        // Pembelian Produk resource routes
        // Route::resource('produk/pembelian_produk', \App\Http\Controllers\PembelianProdukController::class)->parameters([
        //     'produk/pembelian_produk' => 'pembelian_produk'
        // ])->names('produk.pembelian_produk');
    });

    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir', [\App\Http\Controllers\KasirController::class, 'index'])->name('kasir.index');
        Route::post('/kasir/add-to-cart', [\App\Http\Controllers\KasirController::class, 'addToCart'])->name('kasir.addToCart');
        Route::delete('/kasir/remove-from-cart/{produkId}', [\App\Http\Controllers\KasirController::class, 'removeFromCart'])->name('kasir.removeFromCart');
        Route::post('/kasir/clear-cart', [\App\Http\Controllers\KasirController::class, 'clearCart'])->name('kasir.clearCart');
        Route::post('/kasir/process-transaction', [\App\Http\Controllers\KasirController::class, 'processTransaction'])->name('kasir.processTransaction');
        Route::get('/kasir/receipt/{transaction}', [\App\Http\Controllers\KasirController::class, 'receipt'])->name('kasir.receipt');

        Route::get('/kasir/transaction-history', [\App\Http\Controllers\KasirController::class, 'transactionHistory'])->name('kasir.transactionHistory');
    });

    Route::get('/test-kategori', [\App\Http\Controllers\CategoryController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/test-produk-view', [ProdukController::class, 'produkView']);
    Route::get('/profile/view', [ProfileController::class, 'view'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update.put');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user-image/{filename}', function ($filename) {
    $path = 'user_images/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = mime_content_type(storage_path('app/public/' . $path));

    return Response::make($file, 200)->header("Content-Type", $type);
});

require __DIR__ . '/auth.php';