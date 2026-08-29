<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Office Task Tracker
|--------------------------------------------------------------------------
|
| 1. Dashboard: Key metrics, completion rates, due soon alerts, recent tasks
| 2. Tasks Resource: Full CRUD for task management
| 3. CSV Export: Export filtered tasks (controlled by ENABLE_TASK_EXPORT)
|
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// CSV Export (Must be placed before resource to prevent conflict with /tasks/{task})
Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');

// Quick Status Update (AJAX & Kanban)
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');

// Tasks CRUD Resource
Route::resource('tasks', TaskController::class);
