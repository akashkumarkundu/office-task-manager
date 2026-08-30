<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskItemController;
use Illuminate\Support\Facades\Route;

// 1. World-Class SaaS Landing Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Open Workspace & Features (Direct 1-click access without forced login)
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
Route::get('tasks/export', [TaskController::class, 'export'])->name('tasks.export');
Route::resource('tasks', TaskController::class);

// Sub-tasks / Deliverables Checklist Routes
Route::post('tasks/{task}/items', [TaskItemController::class, 'store'])->name('tasks.items.store');
Route::patch('tasks/items/{item}/toggle', [TaskItemController::class, 'toggle'])->name('tasks.items.toggle');
Route::delete('tasks/items/{item}', [TaskItemController::class, 'destroy'])->name('tasks.items.destroy');

// Discussion Comments Feed Routes
Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');
Route::delete('tasks/comments/{comment}', [TaskCommentController::class, 'destroy'])->name('tasks.comments.destroy');

require __DIR__.'/settings.php';
