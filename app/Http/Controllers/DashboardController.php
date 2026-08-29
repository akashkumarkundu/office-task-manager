<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Executive Task Tracker Dashboard.
     */
    public function index(Request $request): View
    {
        $today = Carbon::today();

        // 1. Core Statistics (Dynamic Eloquent Aggregations)
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $highPriorityTasks = Task::where('priority', 'High')->count();

        // 2. Overdue Tasks (Sorted by oldest due date first)
        $overdueTasks = Task::overdue()->orderBy('due_date', 'asc')->get();
        $overdueCount = $overdueTasks->count();

        // 3. Due Soon Tasks (Deadlines arriving within next 3 days, not completed)
        $dueSoonTasks = Task::dueSoon(3)->orderBy('due_date', 'asc')->get();

        // 4. Priority Breakdown
        $lowPriorityCount = Task::where('priority', 'Low')->count();
        $mediumPriorityCount = Task::where('priority', 'Medium')->count();

        // 5. Dynamic Task Completion Percentage
        $completionPercentage = $totalTasks > 0
            ? (int) round(($completedTasks / $totalTasks) * 100)
            : 0;

        // 6. Recent 5 Tasks
        $recentTasks = Task::latest()->take(5)->get();

        // 7. Team Workload Distribution (Top 5 assignees with task counts & percentage)
        $teamWorkload = Task::select('assigned_to', DB::raw('count(*) as task_count'))
            ->groupBy('assigned_to')
            ->orderByDesc('task_count')
            ->take(5)
            ->get()
            ->map(function ($item) use ($totalTasks) {
                $item->percentage = $totalTasks > 0 ? (int) round(($item->task_count / $totalTasks) * 100) : 0;

                return $item;
            });

        // 8. Dynamic Formatted Current Date
        $currentDate = Carbon::now()->format('l, d F Y');

        return view('dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'highPriorityTasks',
            'overdueTasks',
            'overdueCount',
            'dueSoonTasks',
            'lowPriorityCount',
            'mediumPriorityCount',
            'completionPercentage',
            'recentTasks',
            'teamWorkload',
            'currentDate'
        ));
    }
}
