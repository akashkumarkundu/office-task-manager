<x-layouts::app title="Executive Dashboard">
    <flux:main container class="py-2">
        <!-- 1. Executive Top Hero Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 px-6 py-8 sm:px-10 sm:py-10 mb-8 text-white shadow-xl border border-indigo-500/20">
            <!-- Background Ambient Glow Mesh -->
            <div class="absolute -top-32 -right-32 size-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-32 size-96 bg-violet-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-5 pointer-events-none hidden lg:block">
                <flux:icon name="squares-plus" class="size-72 text-white" />
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap mb-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold backdrop-blur-md border border-white/10 text-indigo-200">
                            <span class="size-2 rounded-full bg-emerald-400 animate-ping"></span>
                            <flux:icon name="building-office-2" class="size-3.5 text-indigo-300" />
                            <span>{{ config('tracker.company_name', 'ASTGD') }} Enterprise Hub</span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-900/60 text-xs font-medium text-indigo-200 border border-indigo-700/40">
                            <flux:icon name="calendar" class="size-3.5 text-indigo-400" />
                            <span>{{ $currentDate }}</span>
                        </div>
                    </div>

                    <flux:heading size="xl" level="1" class="text-white! text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight mb-2">
                        {{ config('tracker.office_app_name', 'Office Task Tracker') }}
                    </flux:heading>
                    
                    <p class="text-indigo-200/90 text-sm max-w-xl font-normal leading-relaxed">
                        Real-time executive cockpit for task distribution, project momentum, and deadline management.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0 flex-wrap">
                    <flux:button href="{{ route('tasks.kanban') }}" icon="view-columns" variant="subtle" class="shadow-xs font-semibold border border-white/15 bg-white/5 hover:bg-white/15 text-white py-2.5 px-4.5 rounded-xl">
                        Kanban Board
                    </flux:button>
                    <flux:button href="{{ route('tasks.create') }}" icon="plus" variant="primary" class="shadow-lg shadow-indigo-500/25 font-bold bg-gradient-to-r from-indigo-500 via-indigo-600 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white border-0 py-2.5 px-5.5 rounded-xl hover:scale-105 transition-transform">
                        Create New Task
                    </flux:button>
                </div>
            </div>
        </div>

        @if($totalTasks === 0)
            <!-- Global Zero-Data Empty State -->
            <flux:card class="text-center py-20 px-6 rounded-3xl shadow-sm border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 mb-8">
                <div class="size-20 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto mb-5 shadow-xs">
                    <flux:icon name="clipboard-document-list" class="size-10" />
                </div>
                <flux:heading size="xl" level="2" class="font-bold text-zinc-900 dark:text-zinc-100">No tasks in workspace</flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-2 max-w-md mx-auto">
                    Your workspace is ready. Launch your first project deliverable to begin real-time tracking.
                </flux:subheading>
                <div class="mt-8 flex justify-center gap-3">
                    <flux:button href="{{ route('tasks.create') }}" variant="primary" icon="plus" class="shadow-sm">
                        Create Your First Task
                    </flux:button>
                </div>
            </flux:card>
        @else
            <!-- 2. High-Impact KPI Stat Cards (5 Metrics + Overdue Alert) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5 mb-8">
                <!-- Total Tasks -->
                <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Total Tasks</span>
                        <div class="size-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                            <flux:icon name="inbox-stack" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-zinc-900 dark:text-zinc-100 tracking-tight">{{ $totalTasks }}</div>
                    <div class="mt-2 flex items-center justify-between text-[11px] text-zinc-400">
                        <span>All deliverables</span>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">100% Volume</span>
                    </div>
                </div>

                <!-- Pending -->
                <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Pending</span>
                        <div class="size-9 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                            <flux:icon name="clock" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-amber-600 dark:text-amber-400 tracking-tight">{{ $pendingTasks }}</div>
                    <div class="mt-2 flex items-center justify-between text-[11px] text-zinc-400">
                        <span>Awaiting start</span>
                        <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $totalTasks > 0 ? round(($pendingTasks/$totalTasks)*100) : 0 }}% of total</span>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-400 to-cyan-500"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400">In Progress</span>
                        <div class="size-9 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                            <flux:icon name="arrow-path" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-sky-600 dark:text-sky-400 tracking-tight">{{ $inProgressTasks }}</div>
                    <div class="mt-2 flex items-center justify-between text-[11px] text-zinc-400">
                        <span>Under active work</span>
                        <span class="font-semibold text-sky-600 dark:text-sky-400">{{ $totalTasks > 0 ? round(($inProgressTasks/$totalTasks)*100) : 0 }}% of total</span>
                    </div>
                </div>

                <!-- Completed -->
                <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Completed</span>
                        <div class="size-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                            <flux:icon name="check-badge" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $completedTasks }}</div>
                    <div class="mt-2 flex items-center justify-between text-[11px] text-zinc-400">
                        <span>Resolved</span>
                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $completionPercentage }}% closed</span>
                    </div>
                </div>

                <!-- High Priority -->
                <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group col-span-2 sm:col-span-1">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-red-600"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400">High Priority</span>
                        <div class="size-9 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                            <flux:icon name="fire" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-rose-600 dark:text-rose-400 tracking-tight">{{ $highPriorityTasks }}</div>
                    <div class="mt-2 flex items-center justify-between text-[11px] text-zinc-400">
                        <span>Critical tasks</span>
                        <span class="font-semibold text-rose-600 dark:text-rose-400">{{ $highPriorityTasks > 0 ? 'Action required' : 'All clear' }}</span>
                    </div>
                </div>
            </div>

            <!-- Optional Dedicated Overdue Tasks Alert Banner & Section (When Overdue Exists) -->
            @if($overdueCount > 0)
                <div class="mb-8 rounded-3xl bg-gradient-to-r from-rose-950/90 via-slate-900 to-rose-950/90 border-2 border-rose-500/50 p-6 sm:p-8 shadow-xl relative overflow-hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-rose-500/20 text-rose-400 rounded-2xl border border-rose-500/30 animate-pulse">
                                <flux:icon name="exclamation-triangle" class="size-6" />
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-xl font-black text-white tracking-tight">Overdue Tasks</h2>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-500 text-white shadow-xs">
                                        {{ $overdueCount }} Urgent
                                    </span>
                                </div>
                                <p class="text-xs text-rose-200/80 mt-0.5">
                                    Deliverables that have passed their deadline and are awaiting completion (sorted by oldest deadline first).
                                </p>
                            </div>
                        </div>

                        <flux:button href="{{ route('tasks.index', ['filter' => 'overdue']) }}" variant="subtle" size="sm" class="bg-rose-500/20 hover:bg-rose-500/30 text-rose-200 border border-rose-500/30 font-semibold shrink-0">
                            Manage All Overdue Tasks &rarr;
                        </flux:button>
                    </div>

                    <!-- Overdue Task Cards List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($overdueTasks->take(6) as $task)
                            <div class="p-4 rounded-2xl bg-slate-900/90 border border-rose-500/40 hover:border-rose-400 transition-all flex flex-col justify-between group shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                                            <flux:icon name="exclamation-triangle" class="size-3" />
                                            OVERDUE
                                        </span>
                                        @if($task->priority === 'High')
                                            <flux:badge size="sm" color="red" icon="fire">{{ $task->priority }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="indigo">{{ $task->priority }}</flux:badge>
                                        @endif
                                    </div>

                                    <a href="{{ route('tasks.show', $task) }}" class="font-bold text-sm text-white hover:text-rose-400 truncate block mb-1">
                                        {{ $task->title }}
                                    </a>
                                    <p class="text-xs text-zinc-400 flex items-center gap-1.5 mb-3">
                                        <flux:icon name="user" class="size-3 text-zinc-500" />
                                        <span>Assigned: <strong class="text-zinc-200">{{ $task->assigned_to }}</strong></span>
                                    </p>
                                </div>

                                <div class="pt-2.5 border-t border-zinc-800/80 flex items-center justify-between text-xs">
                                    <span class="text-rose-400 font-bold flex items-center gap-1">
                                        <flux:icon name="calendar" class="size-3.5" />
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                    </span>
                                    <span class="text-[11px] font-semibold text-rose-300 bg-rose-950/80 px-2 py-0.5 rounded-md border border-rose-800/60">
                                        {{ $task->days_overdue }} {{ \Illuminate\Support\Str::plural('day', $task->days_overdue) }} overdue
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 3. Central Analytics & Due Soon Guardian Section -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
                <!-- Task Completion & Priority Health Widget (5 cols) -->
                <flux:card class="lg:col-span-5 shadow-sm rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <div class="p-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400">
                                    <flux:icon name="chart-pie" class="size-4" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Completion Health</h3>
                                    <p class="text-xs text-zinc-400">Project resolution velocity</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                {{ $completionPercentage }}% Overall
                            </span>
                        </div>

                        <!-- Circular Progress Dial -->
                        <div class="flex items-center justify-center my-4">
                            <div class="relative size-40 flex items-center justify-center group">
                                <svg class="size-full rotate-[-90deg]" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="15.5" fill="none" class="stroke-zinc-100 dark:stroke-zinc-800" stroke-width="3"></circle>
                                    <circle cx="18" cy="18" r="15.5" fill="none" class="stroke-indigo-600 dark:stroke-indigo-500 transition-all duration-1000 ease-out group-hover:stroke-[4px]" stroke-width="3" stroke-dasharray="100" stroke-dashoffset="{{ 100 - $completionPercentage }}" stroke-linecap="round"></circle>
                                </svg>
                                <div class="absolute flex flex-col items-center justify-center text-center">
                                    <span class="text-4xl font-black text-zinc-900 dark:text-zinc-100 tracking-tight">{{ $completionPercentage }}%</span>
                                    <span class="text-[11px] text-zinc-400 font-medium">Completed</span>
                                </div>
                            </div>
                        </div>

                        <p class="text-center text-xs text-zinc-500 dark:text-zinc-400 mb-6">
                            <strong class="text-zinc-900 dark:text-zinc-100 font-semibold">{{ $completedTasks }}</strong> of <strong class="text-zinc-900 dark:text-zinc-100 font-semibold">{{ $totalTasks }}</strong> total tasks finalized.
                        </p>
                    </div>

                    <!-- Priority Distribution Bar -->
                    <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <div class="text-xs font-bold text-zinc-700 dark:text-zinc-300 mb-2 flex justify-between">
                            <span>Priority Distribution:</span>
                            <span class="text-zinc-400 font-normal">H: {{ $highPriorityTasks }} &bull; M: {{ $mediumPriorityCount }} &bull; L: {{ $lowPriorityCount }}</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex">
                            @if($totalTasks > 0)
                                <div class="h-full bg-rose-500" style="width: {{ ($highPriorityTasks / $totalTasks) * 100 }}%" title="High Priority: {{ $highPriorityTasks }}"></div>
                                <div class="h-full bg-indigo-500" style="width: {{ ($mediumPriorityCount / $totalTasks) * 100 }}%" title="Medium Priority: {{ $mediumPriorityCount }}"></div>
                                <div class="h-full bg-zinc-400" style="width: {{ ($lowPriorityCount / $totalTasks) * 100 }}%" title="Low Priority: {{ $lowPriorityCount }}"></div>
                            @endif
                        </div>
                    </div>
                </flux:card>

                <!-- Due Soon Guardian (7 cols) -->
                <flux:card class="lg:col-span-7 shadow-sm rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400">
                                    <flux:icon name="fire" class="size-4" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Due Soon (Next 3 Days)</h3>
                                    <p class="text-xs text-zinc-400">Upcoming deadlines arriving shortly</p>
                                </div>
                            </div>
                            
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                {{ $dueSoonTasks->count() }} Tasks
                            </span>
                        </div>

                        <div class="space-y-3">
                            @forelse($dueSoonTasks as $task)
                                <div class="flex items-center justify-between gap-3 p-3.5 rounded-2xl bg-amber-50/40 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/40 hover:bg-amber-50/80 dark:hover:bg-amber-950/40 transition-colors">
                                    <div class="min-w-0 flex items-center gap-3">
                                        <div class="size-8 rounded-full bg-amber-200/80 dark:bg-amber-900/60 text-amber-900 dark:text-amber-200 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 truncate block">
                                                {{ $task->title }}
                                            </a>
                                            <span class="text-xs text-zinc-500">Assigned: <strong class="font-medium text-zinc-700 dark:text-zinc-300">{{ $task->assigned_to }}</strong></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2.5 shrink-0">
                                        <span class="text-xs font-bold text-amber-700 dark:text-amber-300 flex items-center gap-1">
                                            <flux:icon name="calendar" class="size-3.5" />
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d M') }}
                                            <span class="hidden sm:inline font-normal text-zinc-400">({{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }})</span>
                                        </span>
                                        @if($task->priority === 'High')
                                            <flux:badge size="sm" color="red" icon="fire">{{ $task->priority }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="indigo">{{ $task->priority }}</flux:badge>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-zinc-400">
                                    <flux:icon name="shield-check" class="size-10 mx-auto text-emerald-500 mb-2" />
                                    <p class="text-xs text-zinc-500">No deadlines approaching in the next 3 days. All on track!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between text-xs">
                        <span class="text-zinc-400">Want to inspect all tasks?</span>
                        <a href="{{ route('tasks.index') }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                            View All Workspace Tasks &rarr;
                        </a>
                    </div>
                </flux:card>
            </div>

            <!-- 4. Lower Operational Grid (Recent Tasks, Team Workload, Quick Actions) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                <!-- Recent Deliverables -->
                <flux:card class="shadow-sm rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Recent Deliverables</h3>
                                <p class="text-xs text-zinc-400">Latest activity</p>
                            </div>
                            <flux:button href="{{ route('tasks.index') }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                                View All
                            </flux:button>
                        </div>

                        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @forelse($recentTasks as $task)
                                <div class="py-3 flex items-center justify-between gap-3 group hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 px-2 -mx-2 rounded-xl transition-colors">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 truncate block">
                                                {{ $task->title }}
                                            </a>
                                            @if($task->is_overdue)
                                                <span class="inline-flex px-1.5 py-0.2 rounded-full text-[9px] font-black bg-rose-100 text-rose-700 animate-pulse">
                                                    OVERDUE
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-zinc-400">
                                            <span>{{ $task->assigned_to }}</span>
                                        </div>
                                    </div>

                                    <div class="shrink-0">
                                        @if($task->status === 'Completed')
                                            <flux:badge size="sm" color="emerald">{{ $task->status }}</flux:badge>
                                        @elseif($task->status === 'In Progress')
                                            <flux:badge size="sm" color="blue">{{ $task->status }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="amber">{{ $task->status }}</flux:badge>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-zinc-400">
                                    <p class="text-xs">No tasks recorded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </flux:card>

                <!-- Team Workload Distribution Widget -->
                <flux:card class="shadow-sm rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-2 bg-violet-50 dark:bg-violet-950/60 text-violet-600 dark:text-violet-400 rounded-xl">
                                <flux:icon name="users" class="size-4" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Team Workload</h3>
                                <p class="text-xs text-zinc-400">Distribution by assignee</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($teamWorkload as $member)
                                <div>
                                    <div class="flex justify-between text-xs font-semibold text-zinc-800 dark:text-zinc-200 mb-1.5">
                                        <span class="flex items-center gap-1.5">
                                            <span class="size-5 rounded-full bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold text-[9px]">
                                                {{ strtoupper(substr($member->assigned_to, 0, 2)) }}
                                            </span>
                                            {{ $member->assigned_to }}
                                        </span>
                                        <span>{{ $member->task_count }} {{ \Illuminate\Support\Str::plural('task', $member->task_count) }} ({{ $member->percentage }}%)</span>
                                    </div>
                                    <div class="w-full h-2 rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-600 rounded-full transition-all duration-500" style="width: {{ $member->percentage }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-zinc-400 text-center py-6">No assignee data available.</p>
                            @endforelse
                        </div>
                    </div>
                </flux:card>

                <!-- Quick Executive Actions -->
                <flux:card class="shadow-sm rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-2 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl">
                                <flux:icon name="bolt" class="size-4" />
                            </div>
                            <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Quick Actions</h3>
                        </div>

                        <div class="space-y-2.5">
                            <flux:button href="{{ route('tasks.kanban') }}" icon="view-columns" variant="primary" class="w-full justify-start shadow-xs font-semibold bg-indigo-600 hover:bg-indigo-700">
                                Open Kanban Board
                            </flux:button>
                            <flux:button href="{{ route('tasks.create') }}" icon="plus" variant="subtle" class="w-full justify-start font-semibold">
                                Add New Task
                            </flux:button>
                            <flux:button href="{{ route('tasks.index') }}" icon="table-cells" variant="ghost" class="w-full justify-start font-semibold">
                                View Task Table
                            </flux:button>
                            @if(config('tracker.enable_task_export'))
                                <flux:button href="{{ route('tasks.export') }}" icon="arrow-down-tray" variant="ghost" class="w-full justify-start text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 font-medium">
                                    Export Tasks (CSV)
                                </flux:button>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-zinc-100 dark:border-zinc-800 text-xs text-zinc-400 space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span>CSV Export Status:</span>
                            <span class="font-semibold px-2 py-0.5 rounded-md text-[11px] {{ config('tracker.enable_task_export') ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-600' }}">
                                {{ config('tracker.enable_task_export') ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Pagination Limit:</span>
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ config('tracker.tasks_per_page', 10) }} tasks / page</span>
                        </div>
                    </div>
                </flux:card>
            </div>
        @endif
    </flux:main>
</x-layouts::app>
