<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-950 text-zinc-100 antialiased selection:bg-red-500 selection:text-white flex flex-col font-sans">
        <!-- 1. Top Enterprise Navbar -->
        <header class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur-xl border-b border-blue-900/40 shadow-lg shadow-blue-950/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
                <!-- Brand Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="h-10 px-2 rounded-xl bg-white flex items-center justify-center shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform overflow-hidden border border-white/20">
                        <img src="{{ asset('images/astgd-logo.png') }}" alt="ASTGD Logo" class="h-7 w-auto object-contain" />
                    </div>
                    <div>
                        <span class="font-extrabold text-base tracking-tight text-white block leading-tight">
                            {{ config('tracker.office_app_name', 'Office Task Tracker') }}
                        </span>
                        <span class="text-[11px] font-bold text-red-500 block tracking-wider uppercase">
                            {{ config('tracker.company_name', 'ASTGD') }} Enterprise Workspace
                        </span>
                    </div>
                </a>

                <!-- Center Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-zinc-300">
                    <a href="#dashboard-preview" class="hover:text-blue-400 transition-colors">Dashboard Overview</a>
                    <a href="#features" class="hover:text-red-400 transition-colors">Features</a>
                    <a href="{{ route('tasks.kanban') }}" class="hover:text-blue-400 transition-colors">Kanban Board</a>
                    <a href="{{ route('tasks.index') }}" class="hover:text-red-400 transition-colors">Task Table</a>
                </nav>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" variant="primary" icon="bolt" class="bg-gradient-to-r from-blue-600 via-blue-700 to-red-600 hover:from-blue-700 hover:to-red-700 shadow-lg shadow-red-600/25 font-bold text-xs sm:text-sm border-0">
                            Open Dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" variant="ghost" size="sm" class="text-zinc-300 hover:text-white font-semibold">
                            Sign In
                        </flux:button>
                        <flux:button href="{{ route('dashboard') }}" variant="primary" icon="bolt" class="bg-gradient-to-r from-blue-600 via-blue-700 to-red-600 hover:from-blue-700 hover:to-red-700 shadow-lg shadow-red-600/25 font-bold text-xs sm:text-sm border-0">
                            Open Dashboard
                        </flux:button>
                    @endauth
                </div>
            </div>
        </header>

        <!-- 2. Hero Section -->
        <section class="relative overflow-hidden pt-16 pb-20 sm:pt-24 sm:pb-28">
            <!-- Decorative Glow Elements (Blue & Red Ambiance) -->
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 size-[700px] bg-gradient-to-tr from-blue-600/30 via-blue-700/20 to-red-600/30 rounded-full blur-[150px] pointer-events-none"></div>
            <div class="absolute top-1/3 right-10 size-96 bg-red-600/15 rounded-full blur-[130px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4.5 py-1.5 rounded-full bg-slate-900/90 border border-red-500/40 text-xs sm:text-sm font-extrabold text-red-400 mb-8 backdrop-blur-md shadow-lg shadow-red-950/50">
                    <span class="size-2.5 rounded-full bg-red-500 animate-ping"></span>
                    <span>Plan. Track. Collaborate. Succeed.</span>
                </div>

                <!-- Headline -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white max-w-5xl mx-auto leading-[1.15] mb-6">
                    Welcome to <span class="bg-gradient-to-r from-blue-400 via-blue-500 to-red-500 bg-clip-text text-transparent">ASTGD Office Task Manager</span> — your smart workspace for managing tasks, tracking progress, and staying organized.
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-xl text-zinc-300 max-w-3xl mx-auto mb-10 leading-relaxed font-normal">
                    Plan your work, prioritize important tasks, collaborate with your team, and meet deadlines effortlessly—all from one simple and powerful platform.
                </p>

                <!-- Primary Call To Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon="squares-2x2" class="w-full sm:w-auto py-3.5 px-8 font-extrabold text-base bg-gradient-to-r from-blue-600 via-blue-700 to-red-600 hover:from-blue-700 hover:to-red-700 hover:scale-105 transition-all shadow-xl shadow-red-600/30 border-0">
                        Go to Dashboard
                    </flux:button>
                    <flux:button href="{{ route('tasks.index') }}" variant="subtle" icon="clipboard-document-list" class="w-full sm:w-auto py-3.5 px-8 font-bold text-base bg-slate-900/90 hover:bg-slate-800 border border-blue-500/50 text-blue-200 shadow-md">
                        Explore Task Management
                    </flux:button>
                </div>

                <!-- Real-time Live Metric Banner (Blue & Red Theme) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-blue-500/30 backdrop-blur-md shadow-md">
                        <div class="text-2xl sm:text-3xl font-black text-blue-400">{{ $totalTasks }}</div>
                        <div class="text-xs text-zinc-400 font-semibold mt-0.5">Total System Tasks</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-red-500/30 backdrop-blur-md shadow-md">
                        <div class="text-2xl sm:text-3xl font-black text-red-500">{{ $pendingTasks }}</div>
                        <div class="text-xs text-zinc-400 font-semibold mt-0.5">Pending Action</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-blue-500/30 backdrop-blur-md shadow-md">
                        <div class="text-2xl sm:text-3xl font-black text-blue-400">{{ $inProgressTasks }}</div>
                        <div class="text-xs text-zinc-400 font-semibold mt-0.5">In Production</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-red-500/30 backdrop-blur-md shadow-md">
                        <div class="text-2xl sm:text-3xl font-black text-red-400">{{ $completionPercentage }}%</div>
                        <div class="text-xs text-zinc-400 font-semibold mt-0.5">Completion Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Dashboard Live Preview & Gateway Hub -->
        <section id="dashboard-preview" class="py-16 bg-slate-900/60 border-t border-blue-900/30 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-red-400 mb-1.5 block">Live Workspace Hub</span>
                        <h2 class="text-3xl font-extrabold text-white">Executive Dashboard Preview</h2>
                        <p class="text-sm text-zinc-400 mt-1">Get immediate visibility into your office deliverables and deadlines.</p>
                    </div>
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon="arrow-right" class="font-bold bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-700 hover:to-red-700 shadow-lg shadow-red-600/25 border-0">
                        Launch Full Dashboard
                    </flux:button>
                </div>

                <!-- 5 Dynamic Metric Cards Grid (Blue & Red Theme) -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                    <!-- Total Tasks -->
                    <div class="relative overflow-hidden rounded-2xl bg-slate-900/90 border border-blue-500/30 p-5 shadow-md">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-700"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-blue-400">Total</span>
                            <flux:icon name="inbox-stack" class="size-5 text-blue-400" />
                        </div>
                        <div class="text-3xl font-black text-white">{{ $totalTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1 font-medium">Live tasks tracked</div>
                    </div>

                    <!-- Pending -->
                    <div class="relative overflow-hidden rounded-2xl bg-slate-900/90 border border-red-500/30 p-5 shadow-md">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 to-red-700"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-red-500">Pending</span>
                            <flux:icon name="clock" class="size-5 text-red-500" />
                        </div>
                        <div class="text-3xl font-black text-red-500">{{ $pendingTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1 font-medium">Queued items</div>
                    </div>

                    <!-- In Progress -->
                    <div class="relative overflow-hidden rounded-2xl bg-slate-900/90 border border-blue-500/30 p-5 shadow-md">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-cyan-500"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-blue-400">In Progress</span>
                            <flux:icon name="arrow-path" class="size-5 text-blue-400" />
                        </div>
                        <div class="text-3xl font-black text-blue-400">{{ $inProgressTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1 font-medium">Under execution</div>
                    </div>

                    <!-- Completed -->
                    <div class="relative overflow-hidden rounded-2xl bg-slate-900/90 border border-blue-500/30 p-5 shadow-md">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-blue-400">Completed</span>
                            <flux:icon name="check-badge" class="size-5 text-blue-400" />
                        </div>
                        <div class="text-3xl font-black text-blue-400">{{ $completedTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1 font-medium">Successfully resolved</div>
                    </div>

                    <!-- High Priority -->
                    <div class="relative overflow-hidden rounded-2xl bg-slate-900/90 border border-red-500/40 p-5 shadow-md col-span-2 sm:col-span-1">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 to-rose-600"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-red-500">High Priority</span>
                            <flux:icon name="fire" class="size-5 text-red-500 animate-pulse" />
                        </div>
                        <div class="text-3xl font-black text-red-500">{{ $highPriorityTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1 font-medium">Immediate focus</div>
                    </div>
                </div>

                <!-- Direct Gateway Banner (Blue & Red Gradient) -->
                <div class="rounded-3xl bg-gradient-to-r from-blue-950/90 via-slate-900 to-red-950/90 border-2 border-red-500/40 p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-2xl bg-red-500/20 text-red-400 flex items-center justify-center shrink-0 border border-red-500/30">
                            <flux:icon name="bolt" class="size-7" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Full Workspace Dashboard Ready</h3>
                            <p class="text-xs text-zinc-300 mt-0.5">Explore interactive Kanban boards, detailed audit logs, and instant status transitions.</p>
                        </div>
                    </div>
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon="arrow-right" class="shrink-0 font-extrabold bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-700 hover:to-red-700 shadow-lg border-0">
                        Open Dashboard Now
                    </flux:button>
                </div>
            </div>
        </section>

        <!-- 4. Key SaaS Modules Showcase -->
        <section id="features" class="py-20 border-t border-blue-900/30 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <span class="text-xs font-black uppercase tracking-wider text-blue-400 block mb-2">Built for Performance</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Enterprise Productivity Features</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 (Blue Theme) -->
                    <div class="rounded-3xl bg-slate-900/70 border border-blue-500/30 p-8 hover:border-blue-400 transition-colors group shadow-md">
                        <div class="size-12 rounded-2xl bg-blue-500/10 text-blue-400 border border-blue-500/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon name="view-columns" class="size-6" />
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Interactive Kanban Board</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed mb-6">
                            Visual 3-column agile workflow for seamless status transitions: Pending ➔ In Progress ➔ Completed.
                        </p>
                        <flux:button href="{{ route('tasks.kanban') }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs text-blue-400 font-bold p-0">
                            Launch Kanban
                        </flux:button>
                    </div>

                    <!-- Feature 2 (Red Theme) -->
                    <div class="rounded-3xl bg-slate-900/70 border border-red-500/30 p-8 hover:border-red-400 transition-colors group shadow-md">
                        <div class="size-12 rounded-2xl bg-red-500/10 text-red-400 border border-red-500/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon name="exclamation-triangle" class="size-6" />
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Deadline & Overdue Intelligence</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed mb-6">
                            Automated live detection of upcoming deadlines and prominent pulsing warning alerts for overdue deliverables.
                        </p>
                        <flux:button href="{{ route('tasks.index', ['filter' => 'overdue']) }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs text-red-400 font-bold p-0">
                            View Overdue Tasks
                        </flux:button>
                    </div>

                    <!-- Feature 3 (Blue & Red Theme) -->
                    <div class="rounded-3xl bg-slate-900/70 border border-blue-500/30 p-8 hover:border-red-400 transition-colors group shadow-md">
                        <div class="size-12 rounded-2xl bg-gradient-to-tr from-blue-500/20 to-red-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon name="funnel" class="size-6 text-red-400" />
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Advanced Search & Multi-Filters</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed mb-6">
                            Instant multi-field search across titles and assignees, paired with status and priority compound filters.
                        </p>
                        <flux:button href="{{ route('tasks.index') }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs text-red-400 font-bold p-0">
                            Open Task Table
                        </flux:button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Corporate Footer -->
        <footer class="mt-auto border-t border-blue-900/40 bg-slate-950 py-8 px-6 text-center text-xs text-zinc-500">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 flex-wrap">
                    <span>&copy; {{ date('Y') }} <strong class="font-semibold text-zinc-300">{{ config('tracker.company_name', 'ASTGD') }}</strong>. All rights reserved.</span>
                    <span>&bull;</span>
                    <a href="mailto:{{ config('tracker.company_email', 'info@astgd.com') }}" class="hover:text-red-400 transition-colors">
                        {{ config('tracker.company_email', 'info@astgd.com') }}
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @if(app()->environment('local'))
                        <span class="px-2.5 py-0.5 rounded-full bg-red-950/80 text-red-300 border border-red-800/80 font-mono text-[10px] font-semibold">
                            Environment: Development
                        </span>
                    @endif
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-400 font-medium">Dashboard</a>
                    <a href="{{ route('tasks.kanban') }}" class="hover:text-red-400 font-medium">Kanban</a>
                    <a href="{{ route('tasks.index') }}" class="hover:text-blue-400 font-medium">Tasks</a>
                </div>
            </div>
        </footer>

        @fluxScripts
    </body>
</html>
