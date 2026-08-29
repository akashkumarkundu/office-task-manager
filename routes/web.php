<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// 1. World-Class SaaS Landing Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Authenticated SaaS Workspace & Features
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::get('tasks/export', [TaskController::class, 'export'])->name('tasks.export');
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/settings.php';
