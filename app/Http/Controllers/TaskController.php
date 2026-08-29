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
        $category = $request->input('category');
        $tag = $request->input('tag');
        $filter = $request->input('filter');
        $viewMode = $request->input('view', 'table'); // 'table', 'kanban', 'focus'

        $query = Task::query();

        // Keyword Search (Title, Assigned To, Category, Tags)
        if ($search) {
            $query->search($search);
        }

        // Status Filter
        if ($status) {
            $query->filterStatus($status);
        }

        // Priority Filter (Supports Urgent, High, Medium, Low)
        if ($priority) {
            $query->filterPriority($priority);
        }

        // Category Filter
        if ($category) {
            $query->filterCategory($category);
        }

        // Tag Filter
        if ($tag) {
            $query->filterTag($tag);
        }

        // Special Quick Filters
        if ($filter === 'overdue') {
            $query->overdue();
        } elseif ($filter === 'due_soon') {
            $query->dueSoon();
        } elseif ($filter === 'pinned') {
            $query->pinned();
        }

        // All tasks for Kanban / stats (without pagination)
        $allFilteredTasks = (clone $query)->orderByDesc('is_pinned')->orderBy('due_date', 'asc')->get();

        // Sorting: Pinned tasks always stick to the top, then due date
        $perPage = config('office.tasks_per_page', 10);
        $tasks = $query->orderByDesc('is_pinned')
                       ->orderBy('due_date', 'asc')
                       ->paginate($perPage)
                       ->withQueryString();

        // Available categories and tags for quick pill filters
        $availableCategories = Task::select('category')->distinct()->whereNotNull('category')->pluck('category');

        return view('tasks.index', compact(
            'tasks',
            'allFilteredTasks',
            'search',
            'status',
            'priority',
            'category',
            'tag',
            'filter',
            'viewMode',
            'availableCategories'
        ));
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
        $task = Task::create($request->validated());

        return redirect()->route('tasks.index')
                         ->with('success', 'Task "' . $task->title . '" created successfully!');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $task->load(['subtasks', 'comments']);
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

        return redirect()->route('tasks.show', $task)
                         ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $title = $task->title;
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task "' . $title . '" deleted successfully!');
    }

    /**
     * Toggle Pin / Favorite status on a task (AJAX).
     */
    public function togglePin(Task $task)
    {
        $task->is_pinned = !$task->is_pinned;
        $task->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_pinned' => $task->is_pinned,
                'message' => $task->is_pinned ? 'Task pinned to top!' : 'Task unpinned.',
            ]);
        }

        return redirect()->back()->with('success', $task->is_pinned ? 'Task pinned to top!' : 'Task unpinned.');
    }

    /**
     * Log worked time from the interactive stopwatch (AJAX).
     */
    public function logTime(Request $request, Task $task)
    {
        $validated = $request->validate([
            'minutes' => 'nullable|numeric|min:0.1|max:1440',
            'hours' => 'nullable|numeric|min:0.01|max:100',
        ]);

        $addedHours = 0;
        if (!empty($validated['minutes'])) {
            $addedHours = round($validated['minutes'] / 60, 2);
        } elseif (!empty($validated['hours'])) {
            $addedHours = round($validated['hours'], 2);
        }

        $task->spent_hours = round(($task->spent_hours ?? 0) + $addedHours, 2);
        $task->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Logged {$addedHours} hrs to task!",
                'spent_hours' => $task->spent_hours,
                'time_progress' => $task->time_progress,
                'formatted_spent' => $task->spent_hours . ' hrs',
            ]);
        }

        return redirect()->back()->with('success', "Logged {$addedHours} hrs to task!");
    }

    /**
     * Quick search API for Ctrl+K Command Palette.
     */
    public function quickSearch(Request $request)
    {
        $q = $request->input('q', '');
        
        if (strlen($q) < 1) {
            $tasks = Task::orderByDesc('is_pinned')->latest()->take(6)->get();
        } else {
            $tasks = Task::search($q)->take(8)->get();
        }

        $results = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'category' => $task->category ?? 'General',
                'priority' => $task->priority,
                'priority_icon' => $task->priority_icon,
                'status' => $task->status,
                'assigned_to' => $task->assigned_to,
                'is_pinned' => $task->is_pinned,
                'url' => route('tasks.show', $task),
            ];
        });

        return response()->json([
            'results' => $results,
        ]);
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

        $tasks = $query->orderByDesc('is_pinned')->orderBy('due_date', 'asc')->get();

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
                'Pinned',
                'Title',
                'Category',
                'Tags',
                'Description',
                'Assigned To',
                'Priority',
                'Status',
                'Estimated Hours',
                'Spent Hours',
                'Due Date',
                'Created At',
            ]);

            // CSV Data Rows
            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->id,
                    $task->is_pinned ? 'Yes' : 'No',
                    $task->title,
                    $task->category ?? 'General',
                    $task->tags ?? '',
                    $task->description,
                    $task->assigned_to,
                    $task->priority,
                    $task->status,
                    $task->estimated_hours ?? 8,
                    $task->spent_hours ?? 0,
                    $task->due_date ? $task->due_date->format('Y-m-d') : '',
                    $task->created_at ? $task->created_at->format('Y-m-d H:i') : '',
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Update only the status of the task (AJAX / Kanban Drag & Drop).
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update(['status' => $validated['status']]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated to ' . $task->status . '!',
                'status' => $task->status,
                'is_overdue' => $task->is_overdue,
            ]);
        }

        return redirect()->back()->with('success', 'Task status updated to ' . $task->status);
    }
}
