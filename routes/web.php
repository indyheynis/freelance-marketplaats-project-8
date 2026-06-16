<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/freelancer', [DashboardController::class, 'freelancer'])
        ->name('dashboard.freelancer');

    Route::get('/dashboard/client', [DashboardController::class, 'client'])
        ->name('dashboard.client');

    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('dashboard.admin');
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
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
});
Route::get('commissions/{commission}', [CommissionController::class, 'show'])
    ->whereNumber('commission')
    ->name('commissions.show');
Route::get('search', [CommissionController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
    Route::post('/offers/{offer}/accept', [OfferController::class, 'accept'])->name('offers.accept');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
    Route::post('commissions/{commission}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
    
Route::middleware(['auth', 'role:client,freelancer'])->group(function () {
   
    Route::get('freelancers/{freelancer}', [FreelancerController::class, 'show'])->name('freelancers.show');
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// applications accept/reject routes
Route::middleware(['auth'])->group(function () {
    Route::post('commissions/{commission}/apply', [ApplicationController::class, 'store'])
        ->name('applications.store');
    Route::delete('applications/{application}', [ApplicationController::class, 'destroy'])
        ->name('applications.destroy');
    Route::patch('applications/{application}/accept', [ApplicationController::class, 'accept'])
        ->name('applications.accept');
    Route::patch('applications/{application}/reject', [ApplicationController::class, 'reject'])
        ->name('applications.reject');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-applications', [ApplicationController::class, 'index'])
        ->name('applications.index');
    Route::get('/my-reviews', [ReviewController::class, 'index'])
        ->name('reviews.index');
    Route::get('commissions/{commission}/pdf', [CommissionController::class, 'pdf'])
        ->name('commissions.pdf');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::patch('/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
});

Route::get('/map', function () {
    $commissions = \App\Models\Commission::with('category')
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();
    return view('map.index', compact('commissions'));
})->name('map.index');


// Favorites routes
Route::middleware(['auth'])->group(function () {
    Route::post('commissions/{commission}/favorite', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');
    Route::get('favorites', [FavoriteController::class, 'index'])
        ->name('favorites.index');
});

require __DIR__ . '/auth.php';
