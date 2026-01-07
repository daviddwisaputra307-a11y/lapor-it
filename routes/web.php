<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// GROUP ROUTE UTAMA
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. DASHBOARD & TIKET (Semua Role lewat sini, nanti Controller yang memilah)
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    
    // Rute Index tiket (opsional jika dashboard sudah jadi index)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

    // 2. KHUSUS ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/kelola-user', function() {
            return "Halaman Kelola User";
        });
    });

    // 3. KHUSUS TEKNISI & ADMIN (Edit Status)
    Route::middleware(['role:teknisi,admin'])->group(function () {
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    });

});

// 2. KHUSUS ADMIN (Mengelola Master Data)
Route::middleware(['role:admin'])->group(function () {
    
    // Route untuk menampilkan daftar user
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    
    // 1. Form Tambah User
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    // 2. Proses Simpan User
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    // 3. Form Edit User
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    
    // 4. Proses Update User
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    
    // 5. Proses Hapus User
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__ . '/auth.php';