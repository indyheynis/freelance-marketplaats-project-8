<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
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
Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::resource('categories', CategoryController::class);

Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
Route::get('search', [CommissionController::class, 'search'])->name('search');

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
});

Route::get('commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('commissions/{commission}/apply', [ApplicationController::class, 'store'])
        ->name('applications.store');
    Route::delete('applications/{application}', [ApplicationController::class, 'destroy'])
        ->name('applications.destroy');
});


require __DIR__ . '/auth.php';
