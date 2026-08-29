<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the office tracking dashboard with enterprise real-time statistics.
     */
    public function index()
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();
        $completedTasks = Task::where('status', 'Completed')->count();
        
        $urgentPriorityTasks = Task::where('priority', 'Urgent')->count();
        $highPriorityTasks = Task::where('priority', 'High')->count();
        $mediumPriorityTasks = Task::where('priority', 'Medium')->count();
        $lowPriorityTasks = Task::where('priority', 'Low')->count();

        // Time tracking & budget analytics
        $totalEstimatedHours = (int) Task::sum('estimated_hours');
        $totalSpentHours = (float) round(Task::sum('spent_hours'), 1);
        $timeEfficiency = $totalEstimatedHours > 0 ? min(100, round(($totalSpentHours / $totalEstimatedHours) * 100)) : 0;

        // Metric Percentages
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        $overdueCount = Task::overdue()->count();
        $dueSoonCount = Task::dueSoon()->count();
        $pinnedCount = Task::pinned()->count();

        // Pinned & Critical focus tasks
        $pinnedTasks = Task::pinned()->orderBy('due_date', 'asc')->take(6)->get();

        // Recent 5 tasks
        $recentTasks = Task::latest()->take(6)->get();

        // Due soon list (next 3 days)
        $dueSoonTasks = Task::dueSoon()->orderBy('due_date', 'asc')->take(5)->get();

        // Workload distribution by team member
        $teamWorkload = Task::selectRaw('assigned_to, count(*) as total, sum(case when status = "Completed" then 1 else 0 end) as completed')
                            ->groupBy('assigned_to')
                            ->orderByDesc('total')
                            ->take(6)
                            ->get();

        // Category distribution for charts
        $categoryCounts = Task::selectRaw('COALESCE(category, "General") as cat, count(*) as count')
                              ->groupBy('cat')
                              ->pluck('count', 'cat')
                              ->toArray();

        return view('dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'urgentPriorityTasks',
            'highPriorityTasks',
            'mediumPriorityTasks',
            'lowPriorityTasks',
            'totalEstimatedHours',
            'totalSpentHours',
            'timeEfficiency',
            'completionPercentage',
            'overdueCount',
            'dueSoonCount',
            'pinnedCount',
            'pinnedTasks',
            'recentTasks',
            'dueSoonTasks',
            'teamWorkload',
            'categoryCounts'
        ));
    }
}
