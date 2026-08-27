<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 1. Home Page: Daily groceries in Rajshahi city (main branch)
| 2. Grocery Items: Bangladeshi grocery items with photos & BDT prices (branch-1)
| 3. Order Now: Cart & Bangladeshi payment methods (branch-2)
| 4. Contact Us: Rajshahi office & support (branch-3)
|
*/

// Page 1: Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page 2: Grocery Items (Implemented in branch-1)
Route::get('/items', [GroceryController::class, 'index'])->name('items');

// Page 3: Order Now (Implemented in branch-2)
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::post('/order/place', [OrderController::class, 'store'])->name('order.store');

// Page 4: Contact Us (Implemented in branch-3)
Route::get('/contact', function () {
    if (view()->exists('contact')) {
        return app(\App\Http\Controllers\ContactController::class)->index(request());
    }
    return redirect()->route('home')->with('info', 'Contact Us page is available in branch-3');
})->name('contact');
