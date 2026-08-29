<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks with search and filters.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $filter = $request->input('filter');

        $query = Task::query();

        // Keyword Search (Title or Assigned To)
        if ($search) {
            $query->search($search);
        }

        // Status Filter
        if ($status) {
            $query->filterStatus($status);
        }

        // Priority Filter
        if ($priority) {
            $query->filterPriority($priority);
        }

        // Special Quick Filters
        if ($filter === 'overdue') {
            $query->overdue();
        } elseif ($filter === 'due_soon') {
            $query->dueSoon();
        }

        // Sorting & Dynamic Pagination from config/office.php
        $perPage = config('office.tasks_per_page', 10);
        $tasks = $query->orderBy('due_date', 'asc')
                       ->paginate($perPage)
                       ->withQueryString();

        return view('tasks.index', compact('tasks', 'search', 'status', 'priority', 'filter'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')
                         ->with('success', 'Task has been created successfully!');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')
                         ->with('success', 'Task has been updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task has been deleted successfully!');
    }

    /**
     * Export tasks to CSV (Feature Flagged).
     */
    public function export(Request $request): StreamedResponse
    {
        if (!config('office.enable_task_export', true)) {
            abort(403, 'Task export feature is currently disabled.');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');

        $query = Task::query();

        if ($search) {
            $query->search($search);
        }
        if ($status) {
            $query->filterStatus($status);
        }
        if ($priority) {
            $query->filterPriority($priority);
        }

        $tasks = $query->orderBy('due_date', 'asc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="office_tasks_' . date('Y-m-d_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($tasks) {
            $file = fopen('php://output', 'w');
            
            // CSV Header Row
            fputcsv($file, [
                'ID',
                'Title',
                'Description',
                'Assigned To',
                'Priority',
                'Status',
                'Due Date',
                'Created At',
            ]);

            // CSV Data Rows
            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->assigned_to,
                    $task->priority,
                    $task->status,
                    $task->due_date ? $task->due_date->format('Y-m-d') : '',
                    $task->created_at ? $task->created_at->format('Y-m-d H:i') : '',
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }
}
