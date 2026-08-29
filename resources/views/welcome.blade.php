<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-950 text-zinc-100 antialiased selection:bg-indigo-500 selection:text-white flex flex-col font-sans">
        <!-- 1. Top Enterprise Navbar -->
        <header class="sticky top-0 z-50 bg-slate-950/80 backdrop-blur-xl border-b border-zinc-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
                <!-- Brand Logo & Name -->
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                        <flux:icon name="squares-plus" class="size-6" />
                    </div>
                    <div>
                        <span class="font-extrabold text-base tracking-tight text-white block leading-tight">
                            {{ config('tracker.office_app_name', 'Office Task Tracker') }}
                        </span>
                        <span class="text-[11px] font-medium text-indigo-400 block tracking-wider uppercase">
                            {{ config('tracker.company_name', 'ASTGD') }} Enterprise Workspace
                        </span>
                    </div>
                </div>

                <!-- Center Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-300">
                    <a href="#dashboard-preview" class="hover:text-indigo-400 transition-colors">Dashboard Overview</a>
                    <a href="#features" class="hover:text-indigo-400 transition-colors">Features</a>
                    <a href="{{ route('tasks.kanban') }}" class="hover:text-indigo-400 transition-colors">Kanban Board</a>
                    <a href="{{ route('tasks.index') }}" class="hover:text-indigo-400 transition-colors">Task Table</a>
                </nav>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" variant="primary" icon="bolt" class="bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 shadow-md font-semibold text-xs sm:text-sm">
                            Open Dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" variant="ghost" size="sm" class="text-zinc-300 hover:text-white">
                            Sign In
                        </flux:button>
                        <flux:button href="{{ route('dashboard') }}" variant="primary" icon="bolt" class="bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 shadow-md font-semibold text-xs sm:text-sm">
                            Open Dashboard
                        </flux:button>
                    @endauth
                </div>
            </div>
        </header>

        <!-- 2. Hero Section -->
        <section class="relative overflow-hidden pt-16 pb-20 sm:pt-24 sm:pb-28">
            <!-- Decorative Glow Elements -->
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 size-[650px] bg-gradient-to-tr from-indigo-600/20 to-violet-600/20 rounded-full blur-[140px] pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-950/80 border border-indigo-500/30 text-xs font-semibold text-indigo-300 mb-8 backdrop-blur-md shadow-inner">
                    <span class="size-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Corporate Productivity & Task Management SaaS</span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white max-w-4xl mx-auto leading-[1.1] mb-6">
                    Streamline Office Workflows with <span class="bg-gradient-to-r from-indigo-400 via-violet-400 to-sky-400 bg-clip-text text-transparent">Total Clarity</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-xl text-zinc-400 max-w-2xl mx-auto mb-10 leading-relaxed font-normal">
                    Experience dynamic real-time metrics, interactive agile Kanban boards, deadline alerts, and team workload balancing in a unified modern interface.
                </p>

                <!-- Primary Call To Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon="squares-2x2" class="w-full sm:w-auto py-3.5 px-8 font-bold text-base bg-gradient-to-r from-indigo-500 via-violet-600 to-indigo-600 hover:scale-105 transition-transform shadow-xl shadow-indigo-500/25 border-0">
                        Go to Dashboard
                    </flux:button>
                    <flux:button href="{{ route('tasks.index') }}" variant="subtle" icon="clipboard-document-list" class="w-full sm:w-auto py-3.5 px-8 font-bold text-base bg-zinc-900/80 hover:bg-zinc-800 border border-zinc-700/80 text-white">
                        Explore Task Management
                    </flux:button>
                </div>

                <!-- Real-time Live Metric Banner -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    <div class="p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800 backdrop-blur-md">
                        <div class="text-2xl sm:text-3xl font-black text-indigo-400">{{ $totalTasks }}</div>
                        <div class="text-xs text-zinc-400 font-medium mt-0.5">Total System Tasks</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800 backdrop-blur-md">
                        <div class="text-2xl sm:text-3xl font-black text-amber-400">{{ $pendingTasks }}</div>
                        <div class="text-xs text-zinc-400 font-medium mt-0.5">Pending Action</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800 backdrop-blur-md">
                        <div class="text-2xl sm:text-3xl font-black text-sky-400">{{ $inProgressTasks }}</div>
                        <div class="text-xs text-zinc-400 font-medium mt-0.5">In Production</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-zinc-900/60 border border-zinc-800 backdrop-blur-md">
                        <div class="text-2xl sm:text-3xl font-black text-emerald-400">{{ $completionPercentage }}%</div>
                        <div class="text-xs text-zinc-400 font-medium mt-0.5">Completion Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Dashboard Live Preview & Gateway Hub -->
        <section id="dashboard-preview" class="py-16 bg-slate-900/50 border-t border-zinc-800/80 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-400 mb-1.5 block">Live Workspace Hub</span>
                        <h2 class="text-3xl font-extrabold text-white">Executive Dashboard Preview</h2>
                        <p class="text-sm text-zinc-400 mt-1">Get immediate visibility into your office deliverables and deadlines.</p>
                    </div>
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon="arrow-right" class="font-semibold bg-indigo-600 hover:bg-indigo-700 shadow-md">
                        Launch Full Dashboard
                    </flux:button>
                </div>

                <!-- 5 Dynamic Metric Cards Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                    <!-- Total Tasks -->
                    <div class="relative overflow-hidden rounded-2xl bg-zinc-900/90 border border-zinc-800 p-5 shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Total</span>
                            <flux:icon name="inbox-stack" class="size-5 text-indigo-400" />
                        </div>
                        <div class="text-3xl font-black text-white">{{ $totalTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1">Live tasks tracked</div>
                    </div>

                    <!-- Pending -->
                    <div class="relative overflow-hidden rounded-2xl bg-zinc-900/90 border border-zinc-800 p-5 shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Pending</span>
                            <flux:icon name="clock" class="size-5 text-amber-400" />
                        </div>
                        <div class="text-3xl font-black text-amber-400">{{ $pendingTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1">Queued items</div>
                    </div>

                    <!-- In Progress -->
                    <div class="relative overflow-hidden rounded-2xl bg-zinc-900/90 border border-zinc-800 p-5 shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-400 to-cyan-500"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-400">In Progress</span>
                            <flux:icon name="arrow-path" class="size-5 text-sky-400" />
                        </div>
                        <div class="text-3xl font-black text-sky-400">{{ $inProgressTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1">Under execution</div>
                    </div>

                    <!-- Completed -->
                    <div class="relative overflow-hidden rounded-2xl bg-zinc-900/90 border border-zinc-800 p-5 shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Completed</span>
                            <flux:icon name="check-badge" class="size-5 text-emerald-400" />
                        </div>
                        <div class="text-3xl font-black text-emerald-400">{{ $completedTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1">Successfully resolved</div>
                    </div>

                    <!-- High Priority -->
                    <div class="relative overflow-hidden rounded-2xl bg-zinc-900/90 border border-zinc-800 p-5 shadow-sm col-span-2 sm:col-span-1">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-red-600"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-rose-400">High Priority</span>
                            <flux:icon name="fire" class="size-5 text-rose-400" />
                        </div>
                        <div class="text-3xl font-black text-rose-400">{{ $highPriorityTasks }}</div>
                        <div class="text-[11px] text-zinc-400 mt-1">Immediate focus</div>
                    </div>
                </div>

                <!-- Direct CTA to Dashboard Features -->
                <div class="rounded-3xl bg-gradient-to-r from-indigo-950/80 via-slate-900 to-violet-950/80 border border-indigo-800/40 p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-2xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center shrink-0 border border-indigo-500/30">
                            <flux:icon name="bolt" class="size-7" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Full Workspace Dashboard Ready</h3>
                            <p class="text-xs text-zinc-300 mt-0.5">Explore interactive Kanban boards, detailed audit logs, and instant status transitions.</p>
                        </div>
                    </div>
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon="arrow-right" class="shrink-0 font-bold bg-indigo-500 hover:bg-indigo-600 shadow-md">
                        Open Dashboard Now
                    </flux:button>
                </div>
            </div>
        </section>

        <!-- 4. Key SaaS Modules Showcase -->
        <section id="features" class="py-20 border-t border-zinc-800/80 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-400 block mb-2">Built for Performance</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Enterprise Productivity Features</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="rounded-3xl bg-zinc-900/60 border border-zinc-800 p-8 hover:border-indigo-500/50 transition-colors group">
                        <div class="size-12 rounded-2xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon name="view-columns" class="size-6" />
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Interactive Kanban Board</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed mb-6">
                            Visual 3-column agile workflow for seamless status transitions: Pending ➔ In Progress ➔ Completed.
                        </p>
                        <flux:button href="{{ route('tasks.kanban') }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs text-indigo-400 font-semibold p-0">
                            Launch Kanban
                        </flux:button>
                    </div>

                    <!-- Feature 2 -->
                    <div class="rounded-3xl bg-zinc-900/60 border border-zinc-800 p-8 hover:border-amber-500/50 transition-colors group">
                        <div class="size-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon name="exclamation-triangle" class="size-6" />
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Deadline & Overdue Intelligence</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed mb-6">
                            Automated live detection of upcoming deadlines and prominent pulsing warning alerts for overdue deliverables.
                        </p>
                        <flux:button href="{{ route('tasks.index', ['filter' => 'overdue']) }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs text-amber-400 font-semibold p-0">
                            View Overdue Tasks
                        </flux:button>
                    </div>

                    <!-- Feature 3 -->
                    <div class="rounded-3xl bg-zinc-900/60 border border-zinc-800 p-8 hover:border-emerald-500/50 transition-colors group">
                        <div class="size-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon name="funnel" class="size-6" />
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Advanced Search & Multi-Filters</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed mb-6">
                            Instant multi-field search across titles and assignees, paired with status and priority compound filters.
                        </p>
                        <flux:button href="{{ route('tasks.index') }}" variant="ghost" size="sm" icon-trailing="arrow-right" class="text-xs text-emerald-400 font-semibold p-0">
                            Open Task Table
                        </flux:button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Corporate Footer -->
        <footer class="mt-auto border-t border-zinc-800/80 bg-slate-950 py-8 px-6 text-center text-xs text-zinc-500">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 flex-wrap">
                    <span>&copy; {{ date('Y') }} <strong class="font-semibold text-zinc-300">{{ config('tracker.company_name', 'ASTGD') }}</strong>. All rights reserved.</span>
                    <span>&bull;</span>
                    <a href="mailto:{{ config('tracker.company_email', 'info@astgd.com') }}" class="hover:text-indigo-400 transition-colors">
                        {{ config('tracker.company_email', 'info@astgd.com') }}
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @if(app()->environment('local'))
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-950/60 text-amber-300 border border-amber-800/80 font-mono text-[10px] font-semibold">
                            Environment: Development
                        </span>
                    @endif
                    <a href="{{ route('dashboard') }}" class="hover:text-zinc-300 font-medium">Dashboard</a>
                    <a href="{{ route('tasks.kanban') }}" class="hover:text-zinc-300 font-medium">Kanban</a>
                    <a href="{{ route('tasks.index') }}" class="hover:text-zinc-300 font-medium">Tasks</a>
                </div>
            </div>
        </footer>

        @fluxScripts
    </body>
</html>
