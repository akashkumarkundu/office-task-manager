<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the office tracking dashboard with real-time statistics.
     */
    public function index()
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $highPriorityTasks = Task::where('priority', 'High')->count();

        // Bonus Metrics
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        $overdueCount = Task::overdue()->count();
        $dueSoonCount = Task::dueSoon()->count();

        // Recent 5 tasks
        $recentTasks = Task::latest()->take(5)->get();

        // Due soon list (next 3 days)
        $dueSoonTasks = Task::dueSoon()->orderBy('due_date', 'asc')->take(5)->get();

        return view('dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'highPriorityTasks',
            'completionPercentage',
            'overdueCount',
            'dueSoonCount',
            'recentTasks',
            'dueSoonTasks'
        ));
    }
}
