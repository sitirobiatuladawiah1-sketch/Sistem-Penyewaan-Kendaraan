<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenyewaanController;



// 1. AREA PUBLIK (Hanya untuk pengguna yang BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AutentikasiController::class, 'landing'])->name('landing');
    
    Route::get('/register', [AutentikasiController::class, 'showRegister'])->name('register');
    Route::post('/register', [AutentikasiController::class, 'register']);
    
    Route::get('/login', [AutentikasiController::class, 'showLogin'])->name('login');
    Route::post('/login', [AutentikasiController::class, 'login']);
});

// 2. AREA TERKUNCI (Wajib login untuk mengakses)
Route::middleware('auth')->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [PenyewaanController::class, 'index'])->name('dashboard');

    // Dashboard admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/riwayat-transaksi', [AdminController::class, 'riwayatTransaksi'])->name('riwayat-transaksi');
        Route::get('/pengembalian', [AdminController::class, 'pengembalian'])->name('pengembalian');
        Route::get('/riwayat-perbaikan', [AdminController::class, 'riwayatPerbaikan'])->name('riwayat-perbaikan');
        Route::post('/kendaraan', [AdminController::class, 'storeKendaraan'])->name('kendaraan.store');
        Route::get('/kendaraan/{kendaraan}/edit', [AdminController::class, 'editKendaraan'])->name('kendaraan.edit');
        Route::put('/kendaraan/{kendaraan}', [AdminController::class, 'updateKendaraan'])->name('kendaraan.update');
        Route::patch('/kendaraan/{kendaraan}/status', [AdminController::class, 'updateKendaraanStatus'])->name('kendaraan.status');
        Route::delete('/kendaraan/{kendaraan}', [AdminController::class, 'destroyKendaraan'])->name('kendaraan.destroy');
        Route::post('/pickup-point', [AdminController::class, 'storePickupPoint'])->name('pickup-point.store');
        Route::get('/pickup-point/{pickupPoint}/edit', [AdminController::class, 'editPickupPoint'])->name('pickup-point.edit');
        Route::put('/pickup-point/{pickupPoint}', [AdminController::class, 'updatePickupPoint'])->name('pickup-point.update');
        Route::delete('/pickup-point/{pickupPoint}', [AdminController::class, 'destroyPickupPoint'])->name('pickup-point.destroy');
        Route::patch('/transaksi/{transaksi}/status', [AdminController::class, 'updateTransaksiStatus'])->name('transaksi.status');
        Route::patch('/transaksi/{transaksi}/pengembalian', [AdminController::class, 'returnTransaksi'])->name('transaksi.return');
        Route::post('/kendaraan/{kendaraan}/service', [AdminController::class, 'storeServiceHistory'])->name('kendaraan.service.store');
    });
    
    // Alur Penyewaan: Pilih Mobil -> Formulir -> Pembayaran
    Route::get('/sewa/{id}', [PenyewaanController::class, 'create'])->name('sewa.create');
    Route::post('/sewa', [PenyewaanController::class, 'store'])->name('sewa.store');
    Route::get('/riwayat-transaksi', [PenyewaanController::class, 'riwayatTransaksi'])->name('riwayat-transaksi');
    
    // Alur Pembayaran
    Route::get('/pembayaran', [PenyewaanController::class, 'indexPembayaran'])->name('pembayaran.index'); 
    Route::post('/pembayaran', [PenyewaanController::class, 'prosesPembayaran'])->name('pembayaran.proses');
    Route::get('/pembayaran/berhasil', [PenyewaanController::class, 'successPembayaran'])->name('pembayaran.success');
    Route::get('/pembayaran/identitas', [PenyewaanController::class, 'warningIdentitas'])->name('pembayaran.identitas');
    Route::get('/struk', [PenyewaanController::class, 'struk'])->name('struk');
    Route::get('/struk/download-pdf', [PenyewaanController::class, 'downloadStrukPdf'])->name('struk.pdf');
    
    // Logout
    Route::post('/logout', [AutentikasiController::class, 'logout'])->name('logout');
});
