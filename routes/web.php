<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Models\Booking;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| All routes for the Mini Booking System
|--------------------------------------------------------------------------
*/

// ✅ Default home page → Flights search
Route::get('/', [SearchController::class, 'flights'])->name('home');

// ✅ Search routes
Route::get('/search/flights', [SearchController::class, 'flights'])->name('search.flights');
Route::get('/search/hotels', [SearchController::class, 'hotels'])->name('search.hotels');

// ✅ View details for a selected flight or hotel
Route::get('/details/{type}/{id}', [SearchController::class, 'details'])->name('details');

// ✅ Cart routes
Route::middleware('web')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// ✅ Checkout routes (requires auth to proceed)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

    // ✅ Booking details (only logged-in user can view)
    Route::get('/bookings/{id}', function ($id) {
        $booking = Booking::with(['pricing', 'passengers', 'customer'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    })->name('bookings.show');
});

// ✅ Admin dashboard (requires auth + is_admin middleware)
Route::get('/admin', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'is_admin'])
    ->name('admin.dashboard');

// ✅ Include Laravel Breeze / Fortify auth routes if installed
require __DIR__.'/auth.php';
