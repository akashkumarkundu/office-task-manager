<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
Route::get('/items', function () {
    if (view()->exists('items')) {
        return app(\App\Http\Controllers\GroceryController::class)->index(request());
    }
    return redirect()->route('home')->with('info', 'Grocery Items catalog is available in branch-1');
})->name('items');

// Page 3: Order Now (Implemented in branch-2)
Route::get('/order', function () {
    if (view()->exists('order')) {
        return app(\App\Http\Controllers\OrderController::class)->index(request());
    }
    return redirect()->route('home')->with('info', 'Order Now checkout is available in branch-2');
})->name('order');

// Page 4: Contact Us (Implemented in branch-3)
Route::get('/contact', function () {
    if (view()->exists('contact')) {
        return app(\App\Http\Controllers\ContactController::class)->index(request());
    }
    return redirect()->route('home')->with('info', 'Contact Us page is available in branch-3');
})->name('contact');
