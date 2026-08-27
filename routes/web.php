<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes - Daily Groceries in Rajshahi City
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

// Page 2: Grocery Items
Route::get('/items', [GroceryController::class, 'index'])->name('items');

// Page 3: Order Now (Checkout & Bangladeshi Payments)
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::post('/order/place', [OrderController::class, 'store'])->name('order.store');

// Page 4: Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.store');
