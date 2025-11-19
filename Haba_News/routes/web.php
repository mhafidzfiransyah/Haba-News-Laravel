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