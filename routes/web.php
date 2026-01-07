<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tickets/create', [TicketController::class, 'create']);
    Route::post('/tickets', [TicketController::class, 'store']);

  // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tickets (Lapor IT)
 
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index'); // LIST
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show'); // DETAIL
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    Route::middleware(['auth'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
        Route::get('/admin/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
        Route::post('/admin/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('admin.tickets.assign');
        Route::post('/admin/tickets/{ticket}/status', [AdminTicketController::class, 'status'])->name('admin.tickets.status');
    });
});

});

require __DIR__ . '/auth.php';
