<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ScannerController;
use App\Http\Controllers\Admin\TiketController;

use App\Http\Controllers\User\LandingController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PurchaseController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/events', [DashboardController::class, 'home'])->name('user.home');
    Route::get('/history', [DashboardController::class, 'history'])->name('user.history');
    Route::get('/waiting-list', [DashboardController::class, 'waitingList'])->name('user.waiting_list');
    
    Route::get('/purchase/{event}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{event}', [PurchaseController::class, 'process'])->name('purchase.process');
    Route::post('/purchase/{event}/waiting-list', [PurchaseController::class, 'joinWaitingList'])->name('purchase.waitingList');
    Route::post('/purchase/pay-offered/{registration}', [PurchaseController::class, 'payOffered'])->name('purchase.payOffered');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ORGANIZER
Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Organizer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/graph', [\App\Http\Controllers\Organizer\DashboardController::class, 'graph'])->name('graph');
    Route::get('/performance', [\App\Http\Controllers\Organizer\DashboardController::class, 'performance'])->name('performance');
    Route::get('/revenue', [\App\Http\Controllers\Organizer\DashboardController::class, 'revenue'])->name('revenue');
    Route::get('/statistics', [\App\Http\Controllers\Organizer\DashboardController::class, 'statistics'])->name('statistics');
    Route::resource('events', \App\Http\Controllers\Organizer\EventController::class);
    
    // Registration Management for Organizers
    Route::get('registrations', [\App\Http\Controllers\Organizer\RegistrationController::class, 'index'])->name('registrations.index');
    Route::post('registrations/{registration}/approve', [\App\Http\Controllers\Organizer\RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('registrations/{registration}/reject', [\App\Http\Controllers\Organizer\RegistrationController::class, 'reject'])->name('registrations.reject');

    // Scanner Routes for Organizer
    Route::get('scanner', [\App\Http\Controllers\Organizer\ScannerController::class, 'index'])->name('scanner.index');
    Route::post('scanner/verify', [\App\Http\Controllers\Organizer\ScannerController::class, 'verify'])->name('scanner.verify');

    Route::get('events/{event}/tikets/create', [\App\Http\Controllers\Organizer\TiketController::class, 'create'])->name('events.tikets.create');
    Route::post('events/{event}/tikets', [\App\Http\Controllers\Organizer\TiketController::class, 'store'])->name('events.tikets.store');
    Route::get('events/{event}/tikets/{tiket}/edit', [\App\Http\Controllers\Organizer\TiketController::class, 'edit'])->name('events.tikets.edit');
    Route::put('events/{event}/tikets/{tiket}', [\App\Http\Controllers\Organizer\TiketController::class, 'update'])->name('events.tikets.update');
    Route::delete('events/{event}/tikets/{tiket}', [\App\Http\Controllers\Organizer\TiketController::class, 'destroy'])->name('events.tikets.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('events', EventController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('scanner', ScannerController::class);
    Route::post('/scanner/process', [\App\Http\Controllers\Admin\ScannerController::class, 'process'])->name('scanner.process');
    Route::get('events/{event}/tikets/create', [TiketController::class, 'create'])->name('events.tikets.create');
    Route::post('events/{event}/tikets', [TiketController::class, 'store'])->name('events.tikets.store');
    Route::get('events/{event}/tikets/{tiket}/edit', [TiketController::class, 'edit'])->name('events.tikets.edit');
    Route::put('events/{event}/tikets/{tiket}', [TiketController::class, 'update'])->name('events.tikets.update');
    Route::delete('events/{event}/tikets/{tiket}', [TiketController::class, 'destroy'])->name('events.tikets.destroy');
});
