<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController; // <-- Jangan lupa import controller baru

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Route Beranda (Halaman Depan & Filter Kategori)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/kategori/{slug}', [BerandaController::class, 'index'])->name('kategori');

// 2. Route Berita (Halaman Detail / Baca Berita)
// Kita arahkan ke BeritaController method 'show'
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.detail');
Route::get('/about', [BerandaController::class, 'about'])->name('about');

// ROUTE GRUP ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/berita', [App\Http\Controllers\AdminController::class, 'berita'])->name('admin.berita');

    // Route Baru
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}/activity', [App\Http\Controllers\AdminController::class, 'userActivity'])->name('admin.users.activity');

    //mantap
});

