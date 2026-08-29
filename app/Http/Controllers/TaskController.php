<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with search and filtering.
     */
    public function index(Request $request): View
    {
        $query = Task::query();

        // 1. Advanced search by title or assigned person
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('assigned_to', 'like', "%{$search}%");
            });
        }

        // 2. Quick Filter Tabs
        if ($request->filled('filter')) {
            if ($request->filter === 'overdue') {
                $query->where('status', '!=', 'Completed')
                    ->whereNotNull('due_date')
                    ->whereDate('due_date', '<', Carbon::today());
            } elseif ($request->filter === 'due_soon') {
                $query->where('status', '!=', 'Completed')
                    ->whereNotNull('due_date')
                    ->whereDate('due_date', '>=', Carbon::today())
                    ->whereDate('due_date', '<=', Carbon::today()->addDays(3));
            } elseif ($request->filter === 'high_priority') {
                $query->where('priority', 'High');
            }
        }

        // 3. Filter by Status
        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        // 4. Filter by Priority
        if ($request->filled('priority') && $request->priority !== 'All') {
            $query->where('priority', $request->priority);
        }

        // 5. Sorting
        $sortBy = $request->get('sort', 'due_date_asc');
        switch ($sortBy) {
            case 'due_date_desc':
                $query->orderByDesc('due_date');
                break;
            case 'priority_high':
                $query->orderByRaw("CASE priority WHEN 'High' THEN 1 WHEN 'Medium' THEN 2 WHEN 'Low' THEN 3 ELSE 4 END");
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
                $query->latest();
                break;
            case 'due_date_asc':
            default:
                $query->orderBy('due_date', 'asc');
                break;
        }

        // Configurable pagination
        $perPage = (int) config('tracker.tasks_per_page', 10);
        $tasks = $query->paginate($perPage)->withQueryString();

        return view('tasks.index', compact('tasks', 'sortBy'));
    }

    /**
     * Display Kanban Board view.
     */
    public function kanban(): View
    {
        $pendingTasks = Task::where('status', 'Pending')->orderBy('due_date', 'asc')->get();
        $inProgressTasks = Task::where('status', 'In Progress')->orderBy('due_date', 'asc')->get();
        $completedTasks = Task::where('status', 'Completed')->orderBy('due_date', 'asc')->get();

        return view('tasks.kanban', compact('pendingTasks', 'inProgressTasks', 'completedTasks'));
    }

    /**
     * Quickly update task workflow status.
     */
    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Pending', 'In Progress', 'Completed'])],
        ]);

        $task->update(['status' => $validated['status']]);

        return back()->with('success', "Task \"{$task->title}\" transitioned to {$validated['status']}.");
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'assigned_to' => 'required|string|max:255',
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'status' => ['required', Rule::in(['Pending', 'In Progress', 'Completed'])],
            'due_date' => 'required|date',
        ], [
            'title.required' => 'Task Title is required.',
            'title.max' => 'Task Title cannot exceed 255 characters.',
            'assigned_to.required' => 'Please specify the person assigned to this task.',
            'priority.required' => 'Please select a valid priority level (Low, Medium, High).',
            'priority.in' => 'Priority must be either Low, Medium, or High.',
            'status.required' => 'Please select a valid status (Pending, In Progress, Completed).',
            'status.in' => 'Status must be either Pending, In Progress, or Completed.',
            'due_date.required' => 'Due Date is required.',
            'due_date.date' => 'Please provide a valid date for the deadline.',
            'description.max' => 'Description cannot exceed 2,000 characters.',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task has been successfully created.');
    }

    /**
     * Display the specified task details.
     */
    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'assigned_to' => 'required|string|max:255',
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'status' => ['required', Rule::in(['Pending', 'In Progress', 'Completed'])],
            'due_date' => 'required|date',
        ], [
            'title.required' => 'Task Title is required.',
            'title.max' => 'Task Title cannot exceed 255 characters.',
            'assigned_to.required' => 'Please specify the person assigned to this task.',
            'priority.required' => 'Please select a valid priority level (Low, Medium, High).',
            'priority.in' => 'Priority must be either Low, Medium, or High.',
            'status.required' => 'Please select a valid status (Pending, In Progress, Completed).',
            'status.in' => 'Status must be either Pending, In Progress, or Completed.',
            'due_date.required' => 'Due Date is required.',
            'due_date.date' => 'Please provide a valid date for the deadline.',
            'description.max' => 'Description cannot exceed 2,000 characters.',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task details updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task has been permanently deleted.');
    }

    /**
     * Export all tasks to CSV.
     */
    public function export(): StreamedResponse|RedirectResponse
    {
        if (! config('tracker.enable_task_export', false)) {
            return redirect()->route('tasks.index')->with('error', 'Task CSV export is currently disabled.');
        }

        $fileName = 'office-tasks-'.Carbon::now()->format('Y-m-d_His').'.csv';
        $tasks = Task::orderBy('due_date', 'asc')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($tasks) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Columns Header
            fputcsv($handle, [
                'Task ID',
                'Title',
                'Description',
                'Assigned To',
                'Priority',
                'Status',
                'Due Date',
                'Is Overdue',
                'Created Date',
            ]);

            foreach ($tasks as $task) {
                fputcsv($handle, [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->assigned_to,
                    $task->priority,
                    $task->status,
                    $task->due_date ? Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A',
                    $task->is_overdue ? 'YES' : 'NO',
                    $task->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
