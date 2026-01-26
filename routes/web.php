<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminTicketController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (SPESIFIK)
    |--------------------------------------------------------------------------
    */
    // Ini Rute Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ini Rute Dashboard Spesifik (Yang ada Sidebar Putih)
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/teknisi', [DashboardController::class, 'teknisi'])->name('dashboard.teknisi');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');

    /*
    |--------------------------------------------------------------------------
    | ADMIN TICKETS (Menggunakan AdminTicketController)
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/tickets', [AdminTicketController::class, 'index'])
        ->name('admin.tickets.index');

    Route::get('/admin/tickets/{ticket}', [AdminTicketController::class, 'edit'])
        ->name('admin.tickets.edit');

    // Sesuai dengan form di show.blade.php
    Route::post('/admin/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])
        ->name('admin.tickets.assign');

    Route::post('/admin/tickets/{ticket}/status', [AdminTicketController::class, 'status'])
        ->name('admin.tickets.status');

    /*
    |--------------------------------------------------------------------------
    | TEKNISI (TESTING MODE)
    |--------------------------------------------------------------------------
    */
    // Route::middleware(['role:teknisi,admin'])->group(function () { <-- SAYA MATIKAN
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    // });

    /*
    |-----------------------------------------------------------------------
    |    USER TICKETS (UMUM)
    |----------------------------------------------------------------------
    */
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');


    // DETAIL TIKET

    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');


    // EDIT STATUS (USER)

    Route::get('/tickets/{ticket}/edit-status', [TicketController::class, 'editStatus'])->name('tickets.editStatus');
    Route::put('/tickets/{ticket}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // Route::middleware(['role:admin,teknisi'])->group(function () {});

    /*
    |--------------------------------------------------------------------------
    | ADMIN USERS / MASTER DATA (TESTING MODE)
    |--------------------------------------------------------------------------
    */
    // Route::middleware(['role:admin'])->group(function () { <-- SAYA MATIKAN

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    // })

});

require __DIR__ . '/auth.php';
