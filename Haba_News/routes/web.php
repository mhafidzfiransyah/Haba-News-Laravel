<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AdminController;

// 1. Route Frontend
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/kategori/{slug}', [BerandaController::class, 'index'])->name('kategori');
Route::get('/about', [BerandaController::class, 'about'])->name('about');

// 2. Route Detail & Komentar
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.detail');
Route::post('/berita/{id}/komentar', [BeritaController::class, 'storeComment'])->name('berita.komentar'); // NEW Logic

// 3. Route Admin
// Nanti tambahkan middleware(['auth']) jika sudah ada login
Route::prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kelola Berita
    Route::get('/berita', [AdminController::class, 'berita'])->name('admin.berita');
    
    // Action Verifikasi AI & NewsAPI (NEW LOGIC)
    Route::post('/sync-news', [AdminController::class, 'syncNews'])->name('admin.sync'); // Tombol Fetch
    Route::post('/approve/{id}', [AdminController::class, 'approveNews'])->name('admin.approve'); // Tombol Approve
    Route::post('/reject/{id}', [AdminController::class, 'rejectNews'])->name('admin.reject'); // Tombol Reject

    // User
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}/activity', [AdminController::class, 'userActivity'])->name('admin.users.activity');
});