<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;

// BERANDA (public)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// ABOUT (public)
Route::get('/about', function () {
    return view('About.index'); 
})->name('about');


Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.detail');
Route::get('/kategori/{slug}', [BerandaController::class, 'index'])->name('kategori');
// ===================================
// ROUTE ADMIN (WAJIB LOGIN)
// ===================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Sync API
    Route::post('/admin/sync', [AdminController::class, 'syncNews'])
        ->name('admin.sync');

    // Approve Berita
    Route::post('/admin/approve/{id}', [AdminController::class, 'approveNews'])
        ->name('admin.approve');

    // Reject Berita (hapus permanen)
    Route::post('/admin/reject/{id}', [AdminController::class, 'rejectNews'])
        ->name('admin.reject');

    // Kelola Berita
    Route::get('/admin/berita', [AdminController::class, 'berita'])
        ->name('admin.berita');

    //  daftra user
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');

    // detail user
    Route::get('/admin/users/{id}', [AdminController::class, 'usersShow'])->name('admin.users.show');

    // haopus user
    Route::delete('/admin/users/{id}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');

});

Route::post('/berita/{id}/komentar', [BeritaController::class, 'storeComment'])
    ->name('berita.komentar');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Harus Login Dahulu
Route::post('/berita/{id}/comment', [BeritaController::class, 'storeComment'])
     ->name('berita.comment')
     ->middleware('auth');

//hapus semua berita yang pending
Route::post('/admin/news/delete-all', [AdminController::class, 'deleteAllNews'])->name('admin.deleteAll');


// PROFILE (login required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
