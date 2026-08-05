<?php
// ========================================
// FILE: routes/web.php
// ========================================

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\PesananController as PelangganPesananController;
use App\Http\Controllers\Pelanggan\ChatController as PelangganChatController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\PesananController as KaryawanPesananController;
use App\Http\Controllers\Karyawan\ProsesController;
use App\Http\Controllers\Kurir\DashboardController as KurirDashboardController;
use App\Http\Controllers\Kurir\PenjemputanController;
use App\Http\Controllers\Kurir\PengantaranController;
use App\Http\Controllers\Kurir\ChatController as KurirChatController;
use App\Http\Controllers\Pemilik\DashboardController as PemilikDashboardController;
use App\Http\Controllers\Pemilik\LayananController;
use App\Http\Controllers\Pemilik\KaryawanController;
use App\Http\Controllers\Pemilik\LaporanController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// AJAX Notifications Routes
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/api/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/api/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// Invoice Route (Accessible by all roles, authorized inside controller)
Route::get('/pesanan/{id}/invoice', [\App\Http\Controllers\InvoiceController::class, 'show'])
    ->middleware('auth')
    ->name('pesanan.invoice');

// Pelanggan Routes
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    
    // Pesanan
    Route::get('/pesanan', [PelangganPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PelangganPesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PelangganPesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{id}', [PelangganPesananController::class, 'show'])->name('pesanan.show');
    
    // Pembayaran
    Route::get('/pesanan/{id}/pembayaran', [PelangganPesananController::class, 'pembayaran'])->name('pesanan.pembayaran');
    Route::post('/pesanan/{id}/upload-bukti', [PelangganPesananController::class, 'uploadBukti'])->name('pesanan.upload-bukti');
    
    // Chat
    Route::get('/chat', [PelangganChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{pesananId}', [PelangganChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{pesananId}', [PelangganChatController::class, 'store'])->name('chat.store');
});

// Karyawan Routes
Route::middleware(['auth', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Pesanan
    Route::get('/pesanan', [KaryawanPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [KaryawanPesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/timbang', [KaryawanPesananController::class, 'timbang'])->name('pesanan.timbang');
    Route::post('/pesanan/{id}/update-status', [KaryawanPesananController::class, 'updateStatus'])->name('pesanan.update-status');
    Route::post('/pesanan/{id}/konfirmasi-pembayaran', [KaryawanPesananController::class, 'konfirmasiPembayaran'])->name('pesanan.konfirmasi-pembayaran');
    
    // Proses Laundry
    Route::get('/proses', [ProsesController::class, 'index'])->name('proses.index');
    Route::post('/proses/{id}/checklist', [ProsesController::class, 'updateChecklist'])->name('proses.checklist');
});

// Kurir Routes
Route::middleware(['auth', 'role:kurir'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [KurirDashboardController::class, 'index'])->name('dashboard');
    
    // Penjemputan
    Route::get('/penjemputan', [PenjemputanController::class, 'index'])->name('penjemputan.index');
    Route::get('/penjemputan/{id}', [PenjemputanController::class, 'show'])->name('penjemputan.show');
    Route::post('/penjemputan/{id}/mulai', [PenjemputanController::class, 'mulai'])->name('penjemputan.mulai');
    Route::post('/penjemputan/{id}/selesai', [PenjemputanController::class, 'selesai'])->name('penjemputan.selesai');
    
    // Pengantaran
    Route::get('/pengantaran', [PengantaranController::class, 'index'])->name('pengantaran.index');
    Route::get('/pengantaran/{id}', [PengantaranController::class, 'show'])->name('pengantaran.show');
    Route::post('/pengantaran/{id}/mulai', [PengantaranController::class, 'mulai'])->name('pengantaran.mulai');
    Route::post('/pengantaran/{id}/selesai', [PengantaranController::class, 'selesai'])->name('pengantaran.selesai');
    
    // Chat
    Route::get('/chat', [KurirChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{pesananId}', [KurirChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{pesananId}', [KurirChatController::class, 'store'])->name('chat.store');
});

// Pemilik Routes
Route::middleware(['auth', 'role:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [PemilikDashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Layanan
    Route::resource('layanan', LayananController::class);
    
    // Kelola Karyawan
    Route::resource('karyawan', KaryawanController::class);
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
    Route::get('/laporan/export/{jenis}', [LaporanController::class, 'export'])->name('laporan.export');
    
    // Pesanan (view only)
    Route::get('/pesanan', [PemilikDashboardController::class, 'pesanan'])->name('pesanan.index');
});