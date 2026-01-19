<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;

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

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (ROLE BASED)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/teknisi', [DashboardController::class, 'teknisi'])->name('dashboard.teknisi');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    /*
    |--------------------------------------------------------------------------
    | ADMIN TICKETS (HARUS DI ATAS USER TICKETS)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/tickets', [AdminTicketController::class, 'index'])
            ->name('admin.tickets.index');

        Route::get('/admin/tickets/{ticket}', [AdminTicketController::class, 'show'])
            ->name('admin.tickets.show');

        Route::post('/admin/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])
            ->name('admin.tickets.assign');

        Route::post('/admin/tickets/{ticket}/status', [AdminTicketController::class, 'status'])
            ->name('admin.tickets.status');

    });
    /*
    |--------------------------------------------------------------------------
    | TEKNISI / ADMIN (EDIT STATUS)  -> kalau kamu masih pakai route ini
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:teknisi,admin'])->group(function () {
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    });
    /*
    |--------------------------------------------------------------------------
    | USER TICKETS
    |--------------------------------------------------------------------------
    */
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::resource('tickets', TicketController::class);
    Route::get('/tickets/{ticket}/edit-status', [TicketController::class, 'editStatus'])->name('tickets.editStatus');
    Route::put('/tickets/{ticket}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    // DETAIL USER
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    /*
    |--------------------------------------------------------------------------
    | ADMIN USERS (KALO MAU DIBUANG, HAPUS BLOK INI AJA)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/users', [AdminUserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/admin/users/create', [AdminUserController::class, 'create'])
            ->name('admin.users.create');

        Route::post('/admin/users', [AdminUserController::class, 'store'])
            ->name('admin.users.store');

        Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])
            ->name('admin.users.update');

        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('admin.users.destroy');

    });

});

require __DIR__.'/auth.php';
