<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskCommentController;
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
| 4. Subtasks & Checklist: Subtask creation, toggle completion, deletion
| 5. Task Comments: Real-time discussion thread per task
|
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// CSV Export (Must be placed before resource to prevent conflict with /tasks/{task})
Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');

// Quick Status Update (AJAX & Kanban)
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');

// Toggle Pin Status (AJAX)
Route::patch('/tasks/{task}/toggle-pin', [TaskController::class, 'togglePin'])->name('tasks.toggle-pin');

// Log Spent Time from Live Stopwatch (AJAX)
Route::post('/tasks/{task}/log-time', [TaskController::class, 'logTime'])->name('tasks.log-time');

// Command Palette Quick Search (JSON for Ctrl+K)
Route::get('/api/quick-search', [TaskController::class, 'quickSearch'])->name('tasks.quick-search');

// Subtasks Checklist Routes
Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');

// Task Comments Route
Route::post('/tasks/{task}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');

// Tasks CRUD Resource
Route::resource('tasks', TaskController::class);
