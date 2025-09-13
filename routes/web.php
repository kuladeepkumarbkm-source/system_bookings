<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Models\Booking;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});



Route::get('/', function () { return view('search.flights'); });

Route::get('/search/flights', [SearchController::class,'flights'])->name('search.flights');
Route::get('/search/hotels', [SearchController::class,'hotels'])->name('search.hotels');
Route::get('/details/{type}/{id}', [SearchController::class,'details'])->name('details');

Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/clear', [CartController::class,'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout/confirm', [CheckoutController::class,'confirm'])->name('checkout.confirm');

Route::get('/admin', [AdminController::class,'dashboard'])->name('admin.dashboard');

Route::get('/bookings/{id}', function ($id) {
    $booking = Booking::with(['pricing','passengers','customer'])->findOrFail($id);
    return view('bookings.show', compact('booking'));
})->name('bookings.show')->middleware('auth');


require __DIR__.'/auth.php';
