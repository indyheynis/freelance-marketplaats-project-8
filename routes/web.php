<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/freelancer', [DashboardController::class, 'freelancer'])
        ->name('dashboard.freelancer');

    Route::get('/dashboard/client', [DashboardController::class, 'client'])
        ->name('dashboard.client');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route voor Commissions
// Route::resource('commissions', CommissionController::class);
Route::resource('categories', CategoryController::class);

Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
Route::get('commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
});

require __DIR__.'/auth.php';
