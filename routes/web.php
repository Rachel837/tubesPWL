<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    //  return view('dashboard');      
    return view('layouts.master');
    
})->name('dashboard');

// ORGANIZER
Route::prefix('organizer')->group(function () {
    Route::get('/', [OrganizerController::class, 'index']);
    Route::get('/create', [OrganizerController::class, 'create']);
    Route::post('/store', [OrganizerController::class, 'store']);
    Route::get('/edit/{id}', [OrganizerController::class, 'edit']);
    Route::post('/update/{id}', [OrganizerController::class, 'update']);
    Route::post('/toggle/{id}', [OrganizerController::class, 'toggleStatus']);
});

// CATEGORY
Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::post('/update/{id}', [CategoryController::class, 'update']);
    Route::post('/delete/{id}', [CategoryController::class, 'delete']);
});

// Route::resource('event', EventController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
