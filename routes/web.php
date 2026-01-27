<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryTransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except('show')->middleware('role:admin');
    Route::resource('payments', PaymentController::class)->except('show')->middleware('role:admin');
    Route::resource('stuffs', StuffController::class)->middleware('role:admin');
    Route::resource('productList', ProductListController::class)->except('delete', 'update', 'edit', 'store', 'destroy');

    Route::get('/history', [HistoryTransactionController::class, 'index'])->name('history.index');
    Route::get('/history/detail/{id}', [HistoryTransactionController::class, 'detail'])->name('history.show');

    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::delete('wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::get('/checkout/print/{id}', [CheckoutController::class, 'printReceipt'])->name('checkout.print');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
