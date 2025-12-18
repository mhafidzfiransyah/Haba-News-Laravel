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

// ROUTE ADMIN (WAJIB LOGIN)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Sync API
    Route::post('/admin/sync', [AdminController::class, 'syncNews'])->name('admin.sync');
    
    // Approve Berita
    Route::post('/admin/approve/{id}', [AdminController::class, 'approveNews'])->name('admin.approve');
    
    // Reject Berita (hapus permanen satuan)
    Route::post('/admin/reject/{id}', [AdminController::class, 'rejectNews'])->name('admin.reject');

    // Kelola Berita (List)
    Route::get('/admin/berita', [AdminController::class, 'berita'])->name('admin.berita');

    // --- ROUTE BARU: HAPUS SEMUA BERITA ---
    Route::delete('/admin/berita/delete-all', [AdminController::class, 'deleteAllContent'])->name('admin.berita.deleteAll');

    // Hapus User
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/{id}', [AdminController::class, 'usersShow'])->name('admin.users.show');
    Route::delete('/admin/users/{id}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');
    
    // Hapus Pending News (dari Dashboard)
    Route::post('/admin/news/delete-all-pending', [AdminController::class, 'deleteAllNews'])->name('admin.deleteAll');
});

// User Actions
Route::middleware('auth')->group(function () {
    Route::post('/berita/{id}/komentar', [BeritaController::class, 'storeComment'])->name('berita.komentar');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect user dashboard to home
Route::get('/user/dashboard', function () {
    return redirect('/');
})->name('user.dashboard');

require __DIR__.'/auth.php';