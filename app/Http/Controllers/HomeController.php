<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Enterprise SaaS Homepage with live workspace preview.
     */
    public function index(Request $request): View
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $highPriorityTasks = Task::where('priority', 'High')->count();

        $completionPercentage = $totalTasks > 0
            ? (int) round(($completedTasks / $totalTasks) * 100)
            : 0;

        $recentTasks = Task::latest()->take(3)->get();
        $currentDate = Carbon::now()->format('l, d F Y');

        return view('welcome', compact(
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'highPriorityTasks',
            'completionPercentage',
            'recentTasks',
            'currentDate'
        ));
    }
}
