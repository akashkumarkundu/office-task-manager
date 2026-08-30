<x-layouts::app title="Executive Dashboard">
    <flux:main container class="py-2">
        <!-- 1. Executive Top Hero Mesh Cockpit Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-indigo-950 via-purple-950 to-slate-950 px-6 py-8 sm:px-10 sm:py-10 mb-8 text-white shadow-2xl border border-indigo-500/30">
            <!-- Background Ambient Glow Shapes -->
            <div class="absolute -top-32 -right-32 size-96 bg-indigo-500/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-32 size-96 bg-purple-500/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 size-72 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none hidden lg:block">
                <flux:icon name="squares-plus" class="size-80 text-white" />
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap mb-3">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/20 text-xs font-semibold backdrop-blur-md border border-indigo-400/30 text-indigo-200 shadow-xs">
                            <span class="size-2 rounded-full bg-emerald-400 animate-ping"></span>
                            <flux:icon name="building-office-2" class="size-3.5 text-indigo-300" />
                            <span>{{ config('tracker.company_name', 'ASTGD') }} Enterprise Hub</span>
                        </div>
                        
                        <!-- Gamification Rank Tier Badge -->
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-gradient-to-r {{ $rankBadgeColor }} text-xs font-black text-white shadow-lg border border-white/20 backdrop-blur-md">
                            <flux:icon name="trophy" class="size-3.5 text-amber-200" />
                            <span>{{ $rankTitle }} ({{ number_format($xpPoints) }} XP)</span>
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-purple-900/50 text-xs font-semibold text-purple-200 border border-purple-500/30 backdrop-blur-md">
                            <flux:icon name="sparkles" class="size-3.5 text-purple-300" />
                            <span>{{ $healthLabel }}</span>
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/10 text-xs font-medium text-indigo-200 border border-white/10 backdrop-blur-md">
                            <flux:icon name="calendar" class="size-3.5 text-indigo-300" />
                            <span>{{ $currentDate }}</span>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight mb-2 bg-gradient-to-r from-white via-indigo-100 to-indigo-300 bg-clip-text text-transparent">
                        {{ config('tracker.office_app_name', 'Office Task Tracker') }}
                    </h1>
                    
                    <p class="text-indigo-200/90 text-sm max-w-2xl font-normal leading-relaxed">
                        Real-time executive cockpit for deliverables distribution, team velocity, live time tracking, and multi-department analytics.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0 flex-wrap">
                    <flux:button href="{{ route('tasks.kanban') }}" icon="view-columns" variant="subtle" class="shadow-md font-semibold border border-white/20 bg-white/10 hover:bg-white/20 text-white py-2.5 px-4.5 rounded-xl backdrop-blur-md transition-all">
                        Kanban Board
                    </flux:button>
                    <flux:button href="{{ route('tasks.create') }}" icon="plus" variant="primary" class="shadow-xl shadow-indigo-500/30 font-bold bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-600 hover:from-indigo-600 hover:to-pink-700 text-white border-0 py-2.5 px-5.5 rounded-xl hover:scale-105 transition-all">
                        Create Deliverable
                    </flux:button>
                </div>
            </div>
        </div>

        @if($totalTasks === 0)
            <!-- Global Zero-Data Empty State -->
            <flux:card class="text-center py-20 px-6 rounded-3xl shadow-lg border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 mb-8 relative overflow-hidden">
                <div class="size-20 rounded-3xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center mx-auto mb-5 shadow-xl shadow-indigo-500/20">
                    <flux:icon name="clipboard-document-list" class="size-10" />
                </div>
                <flux:heading size="xl" level="2" class="font-bold text-zinc-900 dark:text-zinc-100">Your Workspace is Ready</flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-2 max-w-md mx-auto">
                    Launch your first deliverable to unlock live activity charts, team workload analytics, and performance insights.
                </flux:subheading>
                <div class="mt-8 flex justify-center gap-3">
                    <flux:button href="{{ route('tasks.create') }}" variant="primary" icon="plus" class="shadow-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        Create Your First Task
                    </flux:button>
                </div>
            </flux:card>
        @else
            <!-- 2. Colorful High-Impact KPI Stat Cards (5 Cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5 mb-8">
                <!-- Total Tasks -->
                <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-indigo-100 dark:border-indigo-950/60 p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Total Tasks</span>
                        <div class="size-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs border border-indigo-200/50 dark:border-indigo-800/40">
                            <flux:icon name="inbox-stack" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-zinc-900 dark:text-white tracking-tight">{{ $totalTasks }}</div>
                    <div class="mt-3 flex items-center justify-between text-[11px] text-zinc-500 dark:text-zinc-400">
                        <span>All deliverables</span>
                        <span class="font-bold px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">100% Volume</span>
                    </div>
                </div>

                <!-- Pending -->
                <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-amber-100 dark:border-amber-950/60 p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-400 via-orange-500 to-amber-600"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400">Pending</span>
                        <div class="size-10 rounded-2xl bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs border border-amber-200/50 dark:border-amber-800/40">
                            <flux:icon name="clock" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-amber-600 dark:text-amber-400 tracking-tight">{{ $pendingTasks }}</div>
                    <div class="mt-3 flex items-center justify-between text-[11px] text-zinc-500 dark:text-zinc-400">
                        <span>Awaiting start</span>
                        <span class="font-bold px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                            {{ $totalTasks > 0 ? round(($pendingTasks/$totalTasks)*100) : 0 }}% of total
                        </span>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-cyan-100 dark:border-cyan-950/60 p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-cyan-400 via-sky-500 to-blue-600"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">In Progress</span>
                        <div class="size-10 rounded-2xl bg-cyan-50 dark:bg-cyan-950/80 text-cyan-600 dark:text-cyan-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs border border-cyan-200/50 dark:border-cyan-800/40">
                            <flux:icon name="arrow-path" class="size-5 group-hover:rotate-180 transition-transform duration-700" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-cyan-600 dark:text-cyan-400 tracking-tight">{{ $inProgressTasks }}</div>
                    <div class="mt-3 flex items-center justify-between text-[11px] text-zinc-500 dark:text-zinc-400">
                        <span>Active execution</span>
                        <span class="font-bold px-2 py-0.5 rounded-full bg-cyan-100 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-300">
                            {{ $totalTasks > 0 ? round(($inProgressTasks/$totalTasks)*100) : 0 }}% of total
                        </span>
                    </div>
                </div>

                <!-- Completed -->
                <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-emerald-100 dark:border-emerald-950/60 p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-400 via-teal-500 to-green-600"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Completed</span>
                        <div class="size-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs border border-emerald-200/50 dark:border-emerald-800/40">
                            <flux:icon name="check-badge" class="size-5" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $completedTasks }}</div>
                    <div class="mt-3 flex items-center justify-between text-[11px] text-zinc-500 dark:text-zinc-400">
                        <span>Resolved</span>
                        <span class="font-bold px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                            {{ $completionPercentage }}% closed
                        </span>
                    </div>
                </div>

                <!-- High Priority -->
                <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-rose-100 dark:border-rose-950/60 p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group col-span-2 sm:col-span-1">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-rose-500 via-red-500 to-pink-600"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-rose-600 dark:text-rose-400">High Priority</span>
                        <div class="size-10 rounded-2xl bg-rose-50 dark:bg-rose-950/80 text-rose-600 dark:text-rose-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs border border-rose-200/50 dark:border-rose-800/40">
                            <flux:icon name="fire" class="size-5 animate-pulse text-rose-500" />
                        </div>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-rose-600 dark:text-rose-400 tracking-tight">{{ $highPriorityTasks }}</div>
                    <div class="mt-3 flex items-center justify-between text-[11px] text-zinc-500 dark:text-zinc-400">
                        <span>Critical focus</span>
                        <span class="font-bold px-2 py-0.5 rounded-full {{ $highPriorityTasks > 0 ? 'bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-300' : 'bg-emerald-100 dark:bg-emerald-950 text-emerald-700' }}">
                            {{ $highPriorityTasks > 0 ? 'Action required' : 'All clear' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- 3. INNOVATIVE INTERACTIVE SUITE: Focus Stopwatch & 5-Second Quick-Task Creator -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
                <!-- ⏱️ Live Focus Stopwatch & Pomodoro Timer (Alpine.js Reactive Widget) -->
                <div 
                    x-data="{
                        mode: 'stopwatch',
                        running: false,
                        seconds: 0,
                        pomodoroSeconds: 25 * 60,
                        timerInterval: null,
                        selectedTask: '',
                        
                        startTimer() {
                            if (this.running) return;
                            this.running = true;
                            this.timerInterval = setInterval(() => {
                                if (this.mode === 'stopwatch') {
                                    this.seconds++;
                                } else {
                                    if (this.pomodoroSeconds > 0) {
                                        this.pomodoroSeconds--;
                                    } else {
                                        this.pauseTimer();
                                        this.playChime();
                                        alert('🎉 Focus Pomodoro session complete! Great work!');
                                    }
                                }
                            }, 1000);
                        },
                        pauseTimer() {
                            this.running = false;
                            clearInterval(this.timerInterval);
                        },
                        resetTimer() {
                            this.pauseTimer();
                            if (this.mode === 'stopwatch') {
                                this.seconds = 0;
                            } else {
                                this.pomodoroSeconds = 25 * 60;
                            }
                        },
                        switchMode(newMode) {
                            this.pauseTimer();
                            this.mode = newMode;
                            this.resetTimer();
                        },
                        formatTime(totalSecs) {
                            const hrs = Math.floor(totalSecs / 3600).toString().padStart(2, '0');
                            const mins = Math.floor((totalSecs % 3600) / 60).toString().padStart(2, '0');
                            const secs = (totalSecs % 60).toString().padStart(2, '0');
                            return hrs > 0 ? `${hrs}:${mins}:${secs}` : `${mins}:${secs}`;
                        },
                        playChime() {
                            try {
                                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                                const osc = ctx.createOscillator();
                                const gain = ctx.createGain();
                                osc.connect(gain);
                                gain.connect(ctx.destination);
                                osc.type = 'sine';
                                osc.frequency.setValueAtTime(587.33, ctx.currentTime);
                                osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.3);
                                gain.gain.setValueAtTime(0.2, ctx.currentTime);
                                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.6);
                                osc.start();
                                osc.stop(ctx.currentTime + 0.6);
                            } catch(e) {}
                        }
                    }"
                    class="col-span-1 lg:col-span-6 rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-2 border-indigo-500/40 p-6 text-white shadow-xl relative overflow-hidden flex flex-col justify-between"
                >
                    <!-- Background ambient aura -->
                    <div class="absolute -top-20 -right-20 size-48 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div>
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/40 shadow-xs">
                                    <flux:icon name="bolt" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-white">Live Focus & Stopwatch Engine</h3>
                                    <p class="text-xs text-indigo-300/80">Track deep work sessions in real-time</p>
                                </div>
                            </div>

                            <!-- Mode Toggle Switch -->
                            <div class="flex items-center p-1 rounded-xl bg-slate-950/80 border border-indigo-500/30 text-xs font-bold">
                                <button 
                                    @click="switchMode('stopwatch')" 
                                    :class="mode === 'stopwatch' ? 'bg-indigo-600 text-white shadow-xs' : 'text-zinc-400 hover:text-white'" 
                                    class="px-3 py-1 rounded-lg transition-all cursor-pointer"
                                >
                                    Stopwatch
                                </button>
                                <button 
                                    @click="switchMode('pomodoro')" 
                                    :class="mode === 'pomodoro' ? 'bg-indigo-600 text-white shadow-xs' : 'text-zinc-400 hover:text-white'" 
                                    class="px-3 py-1 rounded-lg transition-all cursor-pointer"
                                >
                                    25m Pomodoro
                                </button>
                            </div>
                        </div>

                        <!-- Active Deliverable Selector -->
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-indigo-200/80 mb-1.5">Select Focus Deliverable:</label>
                            <select 
                                x-model="selectedTask" 
                                class="w-full text-xs font-medium bg-slate-950/90 text-white rounded-xl border border-indigo-500/40 px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                            >
                                <option value="">-- General Workspace Productivity --</option>
                                @foreach($activeTimerTasks as $task)
                                    <option value="{{ $task->id }}">[{{ $task->priority }}] {{ $task->title }} ({{ $task->assigned_to }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Live Digital Counter Display -->
                        <div class="my-4 py-6 px-4 rounded-2xl bg-slate-950/70 border border-indigo-500/30 text-center relative overflow-hidden group">
                            <div 
                                class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 via-purple-500/15 to-pink-500/10 opacity-0 transition-opacity duration-700" 
                                :class="{ 'opacity-100 animate-pulse': running }"
                            ></div>
                            
                            <div class="relative z-10">
                                <span 
                                    class="text-4xl sm:text-5xl font-black tracking-widest font-mono text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 via-white to-cyan-200"
                                    x-text="mode === 'stopwatch' ? formatTime(seconds) : formatTime(pomodoroSeconds)"
                                >
                                    00:00
                                </span>
                                
                                <div class="mt-2 flex items-center justify-center gap-2 text-xs font-bold text-indigo-300">
                                    <span class="size-2 rounded-full" :class="running ? 'bg-emerald-400 animate-ping' : 'bg-zinc-500'"></span>
                                    <span x-text="running ? 'Timer Active & Logging...' : 'Timer Paused'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timer Action Controls -->
                    <div class="flex items-center gap-3 pt-3 border-t border-indigo-900/60">
                        <button 
                            @click="startTimer()" 
                            x-show="!running" 
                            class="flex-1 py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-xs shadow-lg shadow-emerald-500/30 flex items-center justify-center gap-2 transition-all hover:scale-[1.02] cursor-pointer"
                        >
                            <flux:icon name="play" class="size-4" />
                            Start Focus
                        </button>
                        
                        <button 
                            @click="pauseTimer()" 
                            x-show="running" 
                            class="flex-1 py-2.5 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black text-xs shadow-lg shadow-amber-500/30 flex items-center justify-center gap-2 transition-all hover:scale-[1.02] cursor-pointer"
                        >
                            <flux:icon name="pause" class="size-4" />
                            Pause Session
                        </button>

                        <button 
                            @click="resetTimer()" 
                            class="py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition-all cursor-pointer flex items-center gap-1.5"
                        >
                            <flux:icon name="arrow-path" class="size-3.5" />
                            Reset
                        </button>
                    </div>
                </div>

                <!-- ⚡ 5-Second Quick-Task Creator (Fast Inline Creation) -->
                <div class="col-span-1 lg:col-span-6 rounded-3xl bg-white dark:bg-zinc-900 border-2 border-purple-200 dark:border-purple-900/60 p-6 shadow-xl flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -bottom-20 -right-20 size-48 bg-purple-500/10 rounded-full blur-2xl pointer-events-none"></div>

                    <div>
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-purple-50 dark:bg-purple-950/80 text-purple-600 dark:text-purple-400 border border-purple-200/60 dark:border-purple-800/60 shadow-xs">
                                    <flux:icon name="sparkles" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">5-Second Quick Task Launch</h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Instantly launch deliverables without leaving cockpit</p>
                                </div>
                            </div>
                            
                            <span class="px-3 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 border border-purple-300 dark:border-purple-800">
                                Instant Save
                            </span>
                        </div>

                        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-3.5">
                            @csrf
                            <input type="hidden" name="status" value="Pending">

                            <div>
                                <input 
                                    type="text" 
                                    name="title" 
                                    required 
                                    placeholder="What deliverable needs to be done? (e.g. Design Payment UI)"
                                    class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-sm font-medium text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all"
                                >
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Assignee -->
                                <div>
                                    <label class="block text-[11px] font-bold text-zinc-600 dark:text-zinc-400 mb-1">Assignee</label>
                                    <input 
                                        type="text" 
                                        name="assigned_to" 
                                        required 
                                        placeholder="Assignee Name"
                                        value="{{ auth()->user()->name ?? 'Workspace Member' }}"
                                        class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-xs font-medium text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                                    >
                                </div>

                                <!-- Category -->
                                <div>
                                    <label class="block text-[11px] font-bold text-zinc-600 dark:text-zinc-400 mb-1">Department</label>
                                    <select 
                                        name="category" 
                                        class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-xs font-medium text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                                    >
                                        <option value="Development">Development 💻</option>
                                        <option value="Design">Design 🎨</option>
                                        <option value="Marketing">Marketing 🚀</option>
                                        <option value="Operations" selected>Operations ⚡</option>
                                        <option value="Finance">Finance 💰</option>
                                        <option value="Management">Management 👑</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Priority Radios -->
                                <div>
                                    <label class="block text-[11px] font-bold text-zinc-600 dark:text-zinc-400 mb-1">Priority</label>
                                    <div class="flex items-center gap-1.5">
                                        <label class="flex-1 text-center text-xs font-bold py-1.5 px-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 cursor-pointer has-checked:bg-indigo-600 has-checked:text-white has-checked:border-indigo-600 transition-all">
                                            <input type="radio" name="priority" value="Low" class="sr-only">
                                            Low
                                        </label>
                                        <label class="flex-1 text-center text-xs font-bold py-1.5 px-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 hover:bg-amber-50 dark:hover:bg-amber-950/60 cursor-pointer has-checked:bg-amber-500 has-checked:text-white has-checked:border-amber-500 transition-all">
                                            <input type="radio" name="priority" value="Medium" checked class="sr-only">
                                            Med
                                        </label>
                                        <label class="flex-1 text-center text-xs font-bold py-1.5 px-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 hover:bg-rose-50 dark:hover:bg-rose-950/60 cursor-pointer has-checked:bg-rose-600 has-checked:text-white has-checked:border-rose-600 transition-all">
                                            <input type="radio" name="priority" value="High" class="sr-only">
                                            High
                                        </label>
                                    </div>
                                </div>

                                <!-- Due Date -->
                                <div>
                                    <label class="block text-[11px] font-bold text-zinc-600 dark:text-zinc-400 mb-1">Due Date</label>
                                    <input 
                                        type="date" 
                                        name="due_date" 
                                        required 
                                        value="{{ now()->addDays(3)->format('Y-m-d') }}"
                                        class="w-full px-3 py-1.5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60 text-xs font-medium text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                                    >
                                </div>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-black text-xs shadow-lg shadow-purple-500/25 flex items-center justify-center gap-2 transition-all hover:scale-[1.01] cursor-pointer mt-2"
                            >
                                <flux:icon name="plus-circle" class="size-4" />
                                Launch Deliverable Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 4. 🎨 Vibrant Multi-Department Category Distribution Grid -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="p-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50">
                            <flux:icon name="squares-2x2" class="size-4.5" />
                        </div>
                        <div>
                            <h2 class="text-base font-black text-zinc-900 dark:text-zinc-100">Multi-Department Workload Breakdown</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Deliverable distribution and resolution rates by department</p>
                        </div>
                    </div>

                    <a href="{{ route('tasks.index') }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                        Filter Tasks &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
                    @foreach($categoryDistribution as $cat)
                        <a 
                            href="{{ route('tasks.index', ['category' => $cat['name']]) }}" 
                            class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border {{ $cat['border'] }} p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group"
                        >
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="size-8 rounded-xl {{ $cat['bg'] }} {{ $cat['text'] }} flex items-center justify-center font-bold shadow-xs">
                                        <flux:icon :name="$cat['icon']" class="size-4" />
                                    </span>
                                    <span class="text-xs font-black {{ $cat['text'] }}">
                                        {{ $cat['percentage'] }}%
                                    </span>
                                </div>
                                <h3 class="font-extrabold text-xs text-zinc-900 dark:text-zinc-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $cat['name'] }}
                                </h3>
                                <div class="text-lg font-black text-zinc-800 dark:text-zinc-200 mt-0.5">
                                    {{ $cat['count'] }} <span class="text-[10px] font-medium text-zinc-400">tasks</span>
                                </div>
                            </div>

                            <div class="mt-3 pt-2.5 border-t border-zinc-100 dark:border-zinc-800">
                                <div class="w-full h-1.5 rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden mb-1">
                                    <div class="h-full bg-gradient-to-r {{ $cat['gradient'] }}" style="width: {{ $cat['resolution_rate'] }}%"></div>
                                </div>
                                <span class="text-[10px] font-semibold text-zinc-400 flex items-center justify-between">
                                    <span>Resolved</span>
                                    <strong class="{{ $cat['text'] }}">{{ $cat['resolution_rate'] }}%</strong>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Overdue Tasks Priority Banner (When Overdue Tasks Exist) -->
            @if($overdueCount > 0)
                <div class="mb-8 rounded-3xl bg-gradient-to-r from-rose-950 via-slate-900 to-rose-950 border-2 border-rose-500/60 p-6 sm:p-8 shadow-2xl shadow-rose-950/50 relative overflow-hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-rose-500/20 text-rose-400 rounded-2xl border border-rose-500/40 animate-bounce">
                                <flux:icon name="exclamation-triangle" class="size-6" />
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-xl font-black text-white tracking-tight">Overdue Deliverables Radar</h2>
                                    <span class="px-3 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-rose-500 to-red-600 text-white shadow-md">
                                        {{ $overdueCount }} Urgent Action Required
                                    </span>
                                </div>
                                <p class="text-xs text-rose-200/90 mt-0.5">
                                    Deliverables that have surpassed their target deadline require prompt status resolution.
                                </p>
                            </div>
                        </div>

                        <flux:button href="{{ route('tasks.index', ['filter' => 'overdue']) }}" variant="subtle" size="sm" class="bg-rose-500/30 hover:bg-rose-500/50 text-white border border-rose-400/50 font-bold shrink-0 shadow-lg">
                            Manage All Overdue Tasks &rarr;
                        </flux:button>
                    </div>

                    <!-- Overdue Task Cards Grid with 1-Click Status Resolvers -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($overdueTasks->take(6) as $task)
                            <div class="p-4.5 rounded-2xl bg-slate-900/90 border border-rose-500/50 hover:border-rose-400 transition-all flex flex-col justify-between group shadow-md hover:shadow-rose-900/20">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-2">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white shadow-xs">
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

                                <div class="pt-3 border-t border-zinc-800 flex items-center justify-between text-xs">
                                    <span class="text-rose-400 font-bold flex items-center gap-1">
                                        <flux:icon name="calendar" class="size-3.5" />
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                    </span>
                                    
                                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600/80 hover:bg-emerald-600 text-white font-bold text-[11px] flex items-center gap-1 shadow-xs transition-colors cursor-pointer" title="Mark Resolved">
                                            <flux:icon name="check" class="size-3" />
                                            Done
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 5. Central Visual Analytics Grid (Health Dial + 7-Day Activity Chart) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
                <!-- Completion Health & Productivity Index Gauge (5 cols) -->
                <flux:card class="col-span-1 lg:col-span-5 shadow-sm hover:shadow-md transition-shadow rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50 dark:border-indigo-800/40">
                                    <flux:icon name="chart-pie" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">Completion Health</h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Resolution velocity index</p>
                                </div>
                            </div>
                            
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold border bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950 dark:text-indigo-300 dark:border-indigo-800">
                                {{ $productivityScore }}% Score
                            </span>
                        </div>

                        <!-- Circular Progress Dial with Vibrant SVG Gradients -->
                        <div class="flex items-center justify-center my-4">
                            <div class="relative size-44 flex items-center justify-center group">
                                <svg class="size-full rotate-[-90deg]" viewBox="0 0 36 36">
                                    <defs>
                                        <linearGradient id="completionGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#6366f1" />
                                            <stop offset="50%" stop-color="#8b5cf6" />
                                            <stop offset="100%" stop-color="#ec4899" />
                                        </linearGradient>
                                    </defs>
                                    <circle cx="18" cy="18" r="15.5" fill="none" class="stroke-zinc-100 dark:stroke-zinc-800/80" stroke-width="3"></circle>
                                    <circle cx="18" cy="18" r="15.5" fill="none" stroke="url(#completionGradient)" stroke-width="3.5" stroke-dasharray="100" stroke-dashoffset="{{ 100 - $completionPercentage }}" stroke-linecap="round" class="transition-all duration-1000 ease-out group-hover:stroke-[4.5px]"></circle>
                                </svg>
                                <div class="absolute flex flex-col items-center justify-center text-center">
                                    <span class="text-4xl font-black text-zinc-900 dark:text-zinc-100 tracking-tight">{{ $completionPercentage }}%</span>
                                    <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider mt-0.5">Completed</span>
                                    <span class="mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-xs">
                                        {{ $healthLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <p class="text-center text-xs text-zinc-500 dark:text-zinc-400 mb-4">
                            <strong class="text-zinc-900 dark:text-zinc-100 font-bold">{{ $completedTasks }}</strong> of <strong class="text-zinc-900 dark:text-zinc-100 font-bold">{{ $totalTasks }}</strong> workspace deliverables completed.
                        </p>

                        <!-- Sub-tasks Checklist Progress Bar -->
                        @if($totalSubtasksCount > 0)
                            <div class="mb-4 p-3 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800">
                                <div class="flex items-center justify-between text-xs font-bold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <flux:icon name="check-circle" class="size-3.5 text-emerald-500" />
                                        Subtasks Deliverables
                                    </span>
                                    <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">
                                        {{ $completedSubtasksCount }}/{{ $totalSubtasksCount }} ({{ $subtaskProgress }}%)
                                    </span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-zinc-200 dark:bg-zinc-700 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full" style="width: {{ $subtaskProgress }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Priority Breakdown Bar -->
                    <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800/80">
                        <div class="text-xs font-bold text-zinc-700 dark:text-zinc-300 mb-2 flex justify-between">
                            <span>Priority Matrix:</span>
                            <span class="text-zinc-500 dark:text-zinc-400 font-medium">
                                <span class="text-rose-500 font-bold">H: {{ $highPriorityTasks }}</span> &bull; 
                                <span class="text-indigo-500 font-bold">M: {{ $mediumPriorityCount }}</span> &bull; 
                                <span class="text-zinc-400 font-bold">L: {{ $lowPriorityCount }}</span>
                            </span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex shadow-inner">
                            @if($totalTasks > 0)
                                <div class="h-full bg-gradient-to-r from-rose-500 to-red-500" style="width: {{ ($highPriorityTasks / $totalTasks) * 100 }}%" title="High Priority: {{ $highPriorityTasks }}"></div>
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500" style="width: {{ ($mediumPriorityCount / $totalTasks) * 100 }}%" title="Medium Priority: {{ $mediumPriorityCount }}"></div>
                                <div class="h-full bg-zinc-400 dark:bg-zinc-600" style="width: {{ ($lowPriorityCount / $totalTasks) * 100 }}%" title="Low Priority: {{ $lowPriorityCount }}"></div>
                            @endif
                        </div>
                    </div>
                </flux:card>

                <!-- 7-Day Weekly Task Velocity Bar Chart (7 cols) -->
                <flux:card class="col-span-1 lg:col-span-7 shadow-sm hover:shadow-md transition-shadow rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-purple-50 dark:bg-purple-950/80 text-purple-600 dark:text-purple-400 border border-purple-200/50 dark:border-purple-800/40">
                                    <flux:icon name="chart-bar" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">7-Day Work Velocity Flow</h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Created vs Resolved deliverables daily trend</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-xs font-semibold">
                                <div class="flex items-center gap-1.5">
                                    <span class="size-3 rounded-md bg-gradient-to-tr from-indigo-500 to-purple-600"></span>
                                    <span class="text-zinc-600 dark:text-zinc-300">Created</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="size-3 rounded-md bg-gradient-to-tr from-emerald-400 to-teal-500"></span>
                                    <span class="text-zinc-600 dark:text-zinc-300">Resolved</span>
                                </div>
                            </div>
                        </div>

                        <!-- Visual CSS/SVG Bar Chart Grid -->
                        <div class="h-48 pt-6 pb-2 px-2 flex items-end justify-between gap-2 sm:gap-4 border-b border-zinc-100 dark:border-zinc-800">
                            @foreach($weeklyActivity as $activity)
                                @php
                                    $createdHeight = $activity['created'] > 0 
                                        ? max(15, (int) round(($activity['created'] / $maxDailyActivity) * 100)) 
                                        : 4;
                                    $resolvedHeight = $activity['resolved'] > 0 
                                        ? max(15, (int) round(($activity['resolved'] / $maxDailyActivity) * 100)) 
                                        : 4;
                                @endphp
                                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                    <div class="w-full flex items-end justify-center gap-1 h-36 relative">
                                        <!-- Tooltip on Hover -->
                                        <div class="absolute -top-10 opacity-0 group-hover:opacity-100 transition-opacity bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-[10px] font-bold py-1 px-2 rounded-lg pointer-events-none z-20 whitespace-nowrap shadow-md">
                                            {{ $activity['date'] }}: {{ $activity['created'] }} Created / {{ $activity['resolved'] }} Resolved
                                        </div>

                                        <!-- Created Bar -->
                                        <div class="w-1.5 sm:w-2.5 rounded-t-lg bg-gradient-to-t from-indigo-600 to-purple-500 group-hover:brightness-125 transition-all" style="height: {{ $createdHeight }}%" title="Created: {{ $activity['created'] }}"></div>

                                        <!-- Resolved Bar -->
                                        <div class="w-1.5 sm:w-2.5 rounded-t-lg bg-gradient-to-t from-emerald-500 to-teal-400 group-hover:brightness-125 transition-all" style="height: {{ $resolvedHeight }}%" title="Resolved: {{ $activity['resolved'] }}"></div>
                                    </div>

                                    <!-- Day Label -->
                                    <span class="text-[11px] font-bold {{ $activity['is_today'] ? 'text-indigo-600 dark:text-indigo-400 underline underline-offset-4' : 'text-zinc-400' }}">
                                        {{ $activity['day'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                        <span>7-Day Total Activity Trend</span>
                        <span class="font-semibold text-zinc-700 dark:text-zinc-300">
                            Created: <strong class="text-indigo-600 dark:text-indigo-400">{{ array_sum(array_column($weeklyActivity, 'created')) }}</strong> &bull; 
                            Resolved: <strong class="text-emerald-600 dark:text-emerald-400">{{ array_sum(array_column($weeklyActivity, 'resolved')) }}</strong>
                        </span>
                    </div>
                </flux:card>
            </div>

            <!-- 6. Lower Operational Grid (Due Soon Guardian, Team Workload, Recent Tasks & Quick Actions) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                <!-- Due Soon Guardian (Tasks due in next 7 days) -->
                <flux:card class="shadow-sm hover:shadow-md transition-shadow rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 border border-amber-200/50 dark:border-amber-800/40">
                                    <flux:icon name="clock" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">Upcoming Deadlines</h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Tasks due within the next 7 days</p>
                                </div>
                            </div>
                            
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                {{ $dueSoonTasks->count() }} Due Soon
                            </span>
                        </div>

                        <div class="space-y-3">
                            @forelse($dueSoonTasks->take(5) as $task)
                                <div class="flex items-center justify-between gap-3 p-3.5 rounded-2xl bg-amber-50/40 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/40 hover:bg-amber-50/80 dark:hover:bg-amber-950/40 transition-colors">
                                    <div class="min-w-0 flex items-center gap-3">
                                        <div class="size-9 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center font-extrabold text-xs shrink-0 shadow-xs">
                                            {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('tasks.show', $task) }}" class="font-bold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 dark:hover:text-indigo-400 truncate block">
                                                {{ $task->title }}
                                            </a>
                                            <div class="text-[11px] text-zinc-400 mt-0.5">
                                                <span>Assigned: <strong class="text-zinc-600 dark:text-zinc-300 font-semibold">{{ $task->assigned_to }}</strong></span>
                                                <span class="mx-1">&bull;</span>
                                                <span class="font-semibold text-indigo-500">{{ $task->category ?? 'Operations' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="shrink-0">
                                        @if($task->status === 'Completed')
                                            <flux:badge size="sm" color="emerald" icon="check">{{ $task->status }}</flux:badge>
                                        @elseif($task->status === 'In Progress')
                                            <flux:badge size="sm" color="cyan" icon="arrow-path">{{ $task->status }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="amber" icon="clock">{{ $task->status }}</flux:badge>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-zinc-400">
                                    <div class="size-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-500 flex items-center justify-center mx-auto mb-3 shadow-xs">
                                        <flux:icon name="shield-check" class="size-8" />
                                    </div>
                                    <p class="text-xs text-zinc-500 font-medium">No deadlines approaching in the next 7 days. Excellent work!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between text-xs">
                        <span class="text-zinc-400">Inspect full task list?</span>
                        <a href="{{ route('tasks.index') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                            View All Workspace Tasks &rarr;
                        </a>
                    </div>
                </flux:card>

                <!-- Team Workload Distribution -->
                <flux:card class="shadow-sm hover:shadow-md transition-shadow rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-violet-50 dark:bg-violet-950/80 text-violet-600 dark:text-violet-400 border border-violet-200/50 dark:border-violet-800/40">
                                    <flux:icon name="users" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">Team Workload Distribution</h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Task distribution and resolution per assignee</p>
                                </div>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-violet-100 text-violet-800 dark:bg-violet-950 dark:text-violet-300">
                                Top {{ $teamWorkload->count() }} Assignees
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse($teamWorkload as $member)
                                <div>
                                    <div class="flex items-center justify-between text-xs font-bold text-zinc-800 dark:text-zinc-200 mb-1.5">
                                        <span class="flex items-center gap-2">
                                            <span class="size-6 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black text-[10px] shadow-xs">
                                                {{ strtoupper(substr($member->assigned_to, 0, 2)) }}
                                            </span>
                                            <span class="font-extrabold">{{ $member->assigned_to }}</span>
                                        </span>
                                        <span class="text-zinc-500 dark:text-zinc-400 font-semibold">
                                            {{ $member->task_count }} {{ \Illuminate\Support\Str::plural('task', $member->task_count) }} ({{ $member->percentage }}%)
                                        </span>
                                    </div>

                                    <!-- Multi-Color Progress Bar -->
                                    <div class="w-full h-2.5 rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex shadow-inner">
                                        <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full transition-all duration-500" style="width: {{ $member->percentage }}%"></div>
                                    </div>

                                    <div class="mt-1 flex items-center justify-end gap-3 text-[10px] text-zinc-400">
                                        <span>Resolved: <strong class="text-emerald-600 dark:text-emerald-400">{{ $member->completed_count }}</strong></span>
                                        <span>Active: <strong class="text-cyan-600 dark:text-cyan-400">{{ $member->in_progress_count }}</strong></span>
                                        <span>Pending: <strong class="text-amber-600 dark:text-amber-400">{{ $member->pending_count }}</strong></span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-zinc-400 text-center py-8">No assignee workload data recorded.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between text-xs">
                        <span class="text-zinc-400">Need to reassign work?</span>
                        <a href="{{ route('tasks.kanban') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                            Open Board View &rarr;
                        </a>
                    </div>
                </flux:card>

                <!-- Recent Deliverables -->
                <flux:card class="shadow-sm hover:shadow-md transition-shadow rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50 dark:border-indigo-800/40">
                                    <flux:icon name="document-text" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">Recent Deliverables</h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Latest task creation activity</p>
                                </div>
                            </div>

                            <flux:button href="{{ route('tasks.index') }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700">
                                View All
                            </flux:button>
                        </div>

                        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @forelse($recentTasks as $task)
                                <div class="py-3 flex items-center justify-between gap-3 group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 px-2 -mx-2 rounded-xl transition-colors">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="font-bold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 truncate block">
                                                {{ $task->title }}
                                            </a>
                                            @if($task->is_overdue)
                                                <span class="inline-flex px-2 py-0.2 rounded-full text-[9px] font-black bg-rose-500 text-white animate-pulse">
                                                    OVERDUE
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-zinc-400 mt-0.5">
                                            <span>Assigned: <strong class="text-zinc-600 dark:text-zinc-300 font-semibold">{{ $task->assigned_to }}</strong></span>
                                        </div>
                                    </div>

                                    <div class="shrink-0">
                                        @if($task->status === 'Completed')
                                            <flux:badge size="sm" color="emerald" icon="check">{{ $task->status }}</flux:badge>
                                        @elseif($task->status === 'In Progress')
                                            <flux:badge size="sm" color="cyan" icon="arrow-path">{{ $task->status }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="amber" icon="clock">{{ $task->status }}</flux:badge>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-zinc-400">
                                    <p class="text-xs">No tasks recorded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </flux:card>

                <!-- Quick Executive Actions & Hub -->
                <flux:card class="shadow-sm hover:shadow-md transition-shadow rounded-3xl bg-white dark:bg-zinc-900 border-zinc-200/80 dark:border-zinc-800 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2.5 mb-4">
                            <div class="p-2.5 rounded-2xl bg-pink-50 dark:bg-pink-950/80 text-pink-600 dark:text-pink-400 border border-pink-200/50 dark:border-pink-800/40">
                                <flux:icon name="bolt" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-zinc-900 dark:text-zinc-100">Executive Quick Launch</h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Instant workspace shortcuts</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <flux:button href="{{ route('tasks.kanban') }}" icon="view-columns" variant="primary" class="justify-start shadow-md font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl py-3">
                                Drag & Drop Kanban
                            </flux:button>

                            <flux:button href="{{ route('tasks.create') }}" icon="plus-circle" variant="subtle" class="justify-start font-bold border border-zinc-200 dark:border-zinc-700 rounded-xl py-3">
                                Full Task Builder
                            </flux:button>

                            <flux:button href="{{ route('tasks.index', ['filter' => 'my_tasks']) }}" icon="user" variant="subtle" class="justify-start font-bold border border-zinc-200 dark:border-zinc-700 rounded-xl py-3">
                                Assigned To Me
                            </flux:button>

                            @if(config('tracker.enable_task_export'))
                                <flux:button href="{{ route('tasks.export') }}" icon="arrow-down-tray" variant="subtle" class="justify-start font-bold border border-zinc-200 dark:border-zinc-700 rounded-xl py-3">
                                    Export CSV Report
                                </flux:button>
                            @endif
                        </div>
                    </div>


                    <div class="mt-5 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between text-xs text-zinc-400">
                        <span>Pagination: <strong class="text-zinc-600 dark:text-zinc-300">{{ config('tracker.tasks_per_page', 10) }}/page</strong></span>
                        <span class="font-bold text-emerald-500 flex items-center gap-1">
                            <span class="size-2 rounded-full bg-emerald-500 animate-ping"></span>
                            Live Sync Active
                        </span>
                    </div>
                </flux:card>
            </div>
        @endif

        <x-footer />
    </flux:main>
</x-layouts::app>

