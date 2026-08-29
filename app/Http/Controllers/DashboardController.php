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

        // 3. Due Soon Tasks (Deadlines arriving within next 7 days, not completed)
        $dueSoonTasks = Task::dueSoon(7)->orderBy('due_date', 'asc')->get()->map(function ($task) use ($today) {
            $dueDate = Carbon::parse($task->due_date)->startOfDay();
            if ($dueDate->isToday()) {
                $task->urgency_label = 'Due Today';
                $task->urgency_color = 'rose';
            } elseif ($dueDate->isTomorrow()) {
                $task->urgency_label = 'Due Tomorrow';
                $task->urgency_color = 'amber';
            } else {
                $days = (int) $today->diffInDays($dueDate);
                $task->urgency_label = "Due in {$days} Days";
                $task->urgency_color = 'indigo';
            }

            return $task;
        });

        // 4. Priority Breakdown
        $lowPriorityCount = Task::where('priority', 'Low')->count();
        $mediumPriorityCount = Task::where('priority', 'Medium')->count();

        // 5. Dynamic Task Completion Percentage & Productivity Health
        $completionPercentage = $totalTasks > 0
            ? (int) round(($completedTasks / $totalTasks) * 100)
            : 0;

        $overduePenalty = min(30, $overdueCount * 10);
        $productivityScore = max(0, min(100, $completionPercentage - $overduePenalty));

        if ($totalTasks === 0) {
            $healthLabel = 'Workspace Ready';
            $healthColor = 'indigo';
        } elseif ($productivityScore >= 75) {
            $healthLabel = 'Optimal Velocity';
            $healthColor = 'emerald';
        } elseif ($productivityScore >= 45) {
            $healthLabel = 'On Track';
            $healthColor = 'amber';
        } else {
            $healthLabel = 'Needs Attention';
            $healthColor = 'rose';
        }

        // 6. 7-Day Weekly Activity Visualizer (Tasks Created vs Completed)
        $weeklyActivity = [];
        $maxDailyActivity = 1;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateString = $date->toDateString();
            $dayName = $date->format('D');

            $createdCount = Task::whereDate('created_at', $dateString)->count();
            $resolvedCount = Task::where('status', 'Completed')->whereDate('updated_at', $dateString)->count();

            $maxDailyActivity = max($maxDailyActivity, $createdCount, $resolvedCount);

            $weeklyActivity[] = [
                'day' => $dayName,
                'date' => $date->format('d M'),
                'is_today' => $date->isToday(),
                'created' => $createdCount,
                'resolved' => $resolvedCount,
            ];
        }

        // 7. Recent 5 Tasks
        $recentTasks = Task::latest()->take(5)->get();

        // 8. Team Workload Distribution (Top 5 assignees with task counts, completed breakdown & percentage)
        $teamWorkload = Task::select('assigned_to', DB::raw('count(*) as task_count'))
            ->groupBy('assigned_to')
            ->orderByDesc('task_count')
            ->take(5)
            ->get()
            ->map(function ($item) use ($totalTasks) {
                $item->percentage = $totalTasks > 0 ? (int) round(($item->task_count / $totalTasks) * 100) : 0;
                $item->completed_count = Task::where('assigned_to', $item->assigned_to)->where('status', 'Completed')->count();
                $item->pending_count = Task::where('assigned_to', $item->assigned_to)->where('status', 'Pending')->count();
                $item->in_progress_count = Task::where('assigned_to', $item->assigned_to)->where('status', 'In Progress')->count();

                return $item;
            });

        // 9. Dynamic Formatted Current Date
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
            'productivityScore',
            'healthLabel',
            'healthColor',
            'weeklyActivity',
            'maxDailyActivity',
            'recentTasks',
            'teamWorkload',
            'currentDate'
        ));
    }
}
