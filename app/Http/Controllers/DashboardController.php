<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskItem;
use App\Models\User;
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

        // 9. Multi-Department Category Distribution
        $allCategories = [
            'Development' => ['icon' => 'code-bracket', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-blue-600', 'bg' => 'bg-indigo-50 dark:bg-indigo-950/60', 'text' => 'text-indigo-600 dark:text-indigo-400', 'border' => 'border-indigo-200 dark:border-indigo-800/60'],
            'Design' => ['icon' => 'paint-brush', 'color' => 'purple', 'gradient' => 'from-purple-500 to-pink-600', 'bg' => 'bg-purple-50 dark:bg-purple-950/60', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-200 dark:border-purple-800/60'],
            'Marketing' => ['icon' => 'megaphone', 'color' => 'amber', 'gradient' => 'from-amber-500 to-orange-600', 'bg' => 'bg-amber-50 dark:bg-amber-950/60', 'text' => 'text-amber-600 dark:text-amber-400', 'border' => 'border-amber-200 dark:border-amber-800/60'],
            'Operations' => ['icon' => 'cog-6-tooth', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-teal-600', 'bg' => 'bg-emerald-50 dark:bg-emerald-950/60', 'text' => 'text-emerald-600 dark:text-emerald-400', 'border' => 'border-emerald-200 dark:border-emerald-800/60'],
            'Finance' => ['icon' => 'banknotes', 'color' => 'cyan', 'gradient' => 'from-cyan-500 to-sky-600', 'bg' => 'bg-cyan-50 dark:bg-cyan-950/60', 'text' => 'text-cyan-600 dark:text-cyan-400', 'border' => 'border-cyan-200 dark:border-cyan-800/60'],
            'Management' => ['icon' => 'academic-cap', 'color' => 'rose', 'gradient' => 'from-rose-500 to-red-600', 'bg' => 'bg-rose-50 dark:bg-rose-950/60', 'text' => 'text-rose-600 dark:text-rose-400', 'border' => 'border-rose-200 dark:border-rose-800/60'],
        ];

        $categoryDistribution = [];
        foreach ($allCategories as $catName => $meta) {
            $catCount = Task::where('category', $catName)->count();
            $catCompleted = Task::where('category', $catName)->where('status', 'Completed')->count();
            $catPercentage = $totalTasks > 0 ? (int) round(($catCount / $totalTasks) * 100) : 0;
            $catResolution = $catCount > 0 ? (int) round(($catCompleted / $catCount) * 100) : 0;

            $categoryDistribution[$catName] = array_merge($meta, [
                'name' => $catName,
                'count' => $catCount,
                'completed' => $catCompleted,
                'percentage' => $catPercentage,
                'resolution_rate' => $catResolution,
            ]);
        }

        // 10. Sub-task Deliverables Analytics
        $totalSubtasksCount = TaskItem::count();
        $completedSubtasksCount = TaskItem::where('is_completed', true)->count();
        $subtaskProgress = $totalSubtasksCount > 0
            ? (int) round(($completedSubtasksCount / $totalSubtasksCount) * 100)
            : 0;

        // 11. Gamification XP Points & Rank Tier
        $xpPoints = ($completedTasks * 50) + ($completedSubtasksCount * 20) + ($totalTasks * 5);
        if ($xpPoints >= 1000) {
            $rankTitle = 'Diamond Champion';
            $rankBadgeColor = 'from-cyan-400 to-indigo-500';
        } elseif ($xpPoints >= 500) {
            $rankTitle = 'Titanium Master';
            $rankBadgeColor = 'from-purple-500 to-pink-500';
        } elseif ($xpPoints >= 200) {
            $rankTitle = 'Gold Strategist';
            $rankBadgeColor = 'from-amber-400 to-orange-500';
        } else {
            $rankTitle = 'Rising Pioneer';
            $rankBadgeColor = 'from-emerald-400 to-teal-500';
        }

        // 12. Workspace User List & Active Timer Tasks
        $usersList = User::orderBy('name')->get();
        $activeTimerTasks = Task::where('status', '!=', 'Completed')
            ->orderBy('priority', 'asc')
            ->orderBy('due_date', 'asc')
            ->take(12)
            ->get();

        // 13. Dynamic Formatted Current Date
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
            'categoryDistribution',
            'totalSubtasksCount',
            'completedSubtasksCount',
            'subtaskProgress',
            'xpPoints',
            'rankTitle',
            'rankBadgeColor',
            'usersList',
            'activeTimerTasks',
            'currentDate'
        ));
    }
}
