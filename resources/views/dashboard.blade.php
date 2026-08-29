@extends('layouts.app')

@section('title', 'Executive Dashboard')

@section('content')
<div class="mb-4">
    <!-- Executive Welcome Banner -->
    <div class="card-custom p-4 mb-4" style="background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.12) 0%, rgba(var(--accent-rgb), 0.08) 100%); border-left: 6px solid var(--primary) !important;">
        <div class="row align-items-center gy-3">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle" style="width: 52px; height: 52px; font-size: 1.2rem;">
                        EA
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1 font-heading">
                            Welcome back, Emon Ahmed 👋
                        </h3>
                        <p class="text-muted mb-0 small">
                            Lead Architect & Executive Lead at <span class="fw-bold text-primary">{{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                <button type="button" class="btn btn-sm btn-outline-light px-3 py-2 fw-bold" onclick="openCommandPalette()" style="border-radius: 12px;">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> <span class="kbd-key">Ctrl + K</span>
                </button>
                <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary px-3 py-2 fw-bold" style="border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--accent)); border: none;">
                    <i class="fa-solid fa-plus me-1"></i> New Task
                </a>
            </div>
        </div>
    </div>

    <!-- 6 Executive KPI Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Tasks -->
        <div class="col-6 col-lg-4 col-xl-2">
            <div class="stat-card-enterprise">
                <i class="fa-solid fa-layer-group stat-bg-icon"></i>
                <div class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">Total Tasks</div>
                <h3 class="fw-bold my-1 font-heading">{{ $totalTasks }}</h3>
                <div class="small text-success fw-bold">
                    <i class="fa-solid fa-chart-line me-1"></i> {{ $completionPercentage }}% Done
                </div>
            </div>
        </div>

        <!-- 2. Urgent / Critical -->
        <div class="col-6 col-lg-4 col-xl-2">
            <div class="stat-card-enterprise" style="border-color: rgba(239, 68, 68, 0.35);">
                <i class="fa-solid fa-fire-flame-curved stat-bg-icon text-danger"></i>
                <div class="text-uppercase fw-bold text-danger" style="font-size: 0.72rem;">Urgent 🔥</div>
                <h3 class="fw-bold my-1 font-heading text-danger">{{ $urgentPriorityTasks }}</h3>
                <div class="small text-muted">
                    <a href="{{ route('tasks.index', ['priority' => 'Urgent']) }}" class="text-danger text-decoration-none fw-bold">View Critical &rarr;</a>
                </div>
            </div>
        </div>

        <!-- 3. In Progress -->
        <div class="col-6 col-lg-4 col-xl-2">
            <div class="stat-card-enterprise">
                <i class="fa-solid fa-arrows-spin stat-bg-icon text-info"></i>
                <div class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">In Progress</div>
                <h3 class="fw-bold my-1 font-heading">{{ $inProgressTasks }}</h3>
                <div class="small text-info fw-bold">
                    <span class="pulse-dot me-1" style="width: 6px; height: 6px;"></span> Active Sprint
                </div>
            </div>
        </div>

        <!-- 4. Completed -->
        <div class="col-6 col-lg-4 col-xl-2">
            <div class="stat-card-enterprise">
                <i class="fa-solid fa-circle-check stat-bg-icon text-success"></i>
                <div class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">Completed</div>
                <h3 class="fw-bold my-1 font-heading">{{ $completedTasks }}</h3>
                <div class="small text-success fw-bold">
                    <i class="fa-solid fa-trophy me-1"></i> Delivered
                </div>
            </div>
        </div>

        <!-- 5. Time Tracked -->
        <div class="col-6 col-lg-4 col-xl-2">
            <div class="stat-card-enterprise">
                <i class="fa-solid fa-stopwatch stat-bg-icon text-warning"></i>
                <div class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">Logged Hours</div>
                <h3 class="fw-bold my-1 font-heading">{{ $totalSpentHours }} <span class="fs-6 text-muted fw-normal">/ {{ $totalEstimatedHours }}h</span></h3>
                <div class="small text-warning fw-bold">
                    <i class="fa-solid fa-gauge-high me-1"></i> {{ $timeEfficiency }}% Budget
                </div>
            </div>
        </div>

        <!-- 6. Overdue / Due Soon -->
        <div class="col-6 col-lg-4 col-xl-2">
            <div class="stat-card-enterprise" style="{{ $overdueCount > 0 ? 'border-color: rgba(239, 68, 68, 0.4);' : '' }}">
                <i class="fa-regular fa-calendar-xmark stat-bg-icon text-danger"></i>
                <div class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">Deadlines</div>
                <h3 class="fw-bold my-1 font-heading {{ $overdueCount > 0 ? 'text-danger' : 'text-success' }}">
                    {{ $overdueCount }} <span class="fs-6 text-muted fw-normal">Overdue</span>
                </h3>
                <div class="small text-muted">
                    <span class="badge bg-warning text-dark rounded-pill">{{ $dueSoonCount }} Due Soon</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pinned / Critical Focus Tasks Banner -->
    @if($pinnedTasks->count() > 0)
    <div class="card-custom p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 font-heading text-warning">
                <i class="fa-solid fa-thumbtack me-2"></i> Pinned & High Focus Tasks ({{ $pinnedTasks->count() }})
            </h5>
            <a href="{{ route('tasks.index', ['filter' => 'pinned']) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">
                View All Pinned &rarr;
            </a>
        </div>
        <div class="row g-3">
            @foreach($pinnedTasks as $task)
            <div class="col-md-6 col-xl-4">
                <div class="card-custom p-3 h-100 card-custom-interactive position-relative">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge-cat {{ $task->category_color }}">{{ $task->category ?? 'General' }}</span>
                        <span class="badge {{ $task->priority_badge_class }} rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                            <i class="{{ $task->priority_icon }} me-1"></i> {{ $task->priority }}
                        </span>
                    </div>
                    <h6 class="fw-bold mb-1">
                        <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-reset stretched-link">
                            {{ $task->title }}
                        </a>
                    </h6>
                    <p class="text-muted small mb-2 text-truncate">{{ $task->description ?? 'No description provided.' }}</p>
                    
                    <!-- Progress & Time -->
                    <div class="d-flex align-items-center justify-content-between text-muted small mt-auto pt-2 border-top border-secondary border-opacity-25">
                        <div class="d-flex align-items-center">
                            <span class="avatar-circle me-1" style="width: 24px; height: 24px; font-size: 0.65rem;">
                                {{ substr($task->assigned_to, 0, 1) }}
                            </span>
                            <span>{{ $task->assigned_to }}</span>
                        </div>
                        <div class="fw-bold font-monospace text-primary">
                            <i class="fa-regular fa-clock me-1"></i> {{ $task->spent_hours }}h / {{ $task->estimated_hours ?? 8 }}h
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Visual Analytics & Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Chart 1: Priority & Workload Breakdown -->
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-1 font-heading">
                            <i class="fa-solid fa-chart-pie text-primary me-2"></i> Task Status & Priority Distribution
                        </h5>
                        <p class="text-muted small mb-0">Real-time status overview across team sprints</p>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-bold">Live Data</span>
                </div>
                <div style="height: 280px; position: relative;">
                    <canvas id="taskStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart 2: Category Distribution -->
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-1 font-heading">
                            <i class="fa-solid fa-chart-column text-accent me-2"></i> Tasks by Department / Category
                        </h5>
                        <p class="text-muted small mb-0">Resource allocation by business domain</p>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3 py-1 fw-bold">Categories</span>
                </div>
                <div style="height: 280px; position: relative;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Workload & Recent Activity Feed -->
    <div class="row g-4">
        <!-- Team Workload Distribution -->
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <h5 class="fw-bold mb-3 font-heading">
                    <i class="fa-solid fa-users text-primary me-2"></i> Team Workload & Performance
                </h5>
                <div class="d-flex flex-column gap-3">
                    @foreach($teamWorkload as $member)
                    @php
                        $memberProgress = $member->total > 0 ? round(($member->completed / $member->total) * 100) : 0;
                    @endphp
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2" style="width: 28px; height: 28px; font-size: 0.72rem;">
                                    {{ substr($member->assigned_to, 0, 1) }}
                                </div>
                                <span class="fw-bold">{{ $member->assigned_to }}</span>
                            </div>
                            <span class="small text-muted fw-bold">
                                {{ $member->completed }} / {{ $member->total }} Tasks ({{ $memberProgress }}%)
                            </span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 9999px; background: var(--surface-hover);">
                            <div class="progress-bar" role="progressbar" style="width: {{ $memberProgress }}%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 9999px;" aria-valuenow="{{ $memberProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Tasks Stream -->
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0 font-heading">
                        <i class="fa-solid fa-clock-rotate-left text-accent me-2"></i> Recent Task Feed
                    </h5>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">
                        View All ({{ $totalTasks }}) &rarr;
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($recentTasks as $task)
                    <div class="list-group-item px-0 py-2 bg-transparent border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="{{ $task->priority_icon }} fs-6"></i>
                            <div>
                                <a href="{{ route('tasks.show', $task) }}" class="fw-bold text-decoration-none text-reset d-block">
                                    {{ $task->title }}
                                </a>
                                <small class="text-muted">{{ $task->category ?? 'General' }} • {{ $task->assigned_to }}</small>
                            </div>
                        </div>
                        <span class="status-pill badge-status-{{ str_replace(' ', '', $task->status) }}">
                            {{ $task->status }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">No recent tasks found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Chart 1: Status Doughnut
        const statusCtx = document.getElementById('taskStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending', 'Urgent 🔥'],
                datasets: [{
                    data: [{{ $completedTasks }}, {{ $inProgressTasks }}, {{ $pendingTasks }}, {{ $urgentPriorityTasks }}],
                    backgroundColor: ['#10b981', '#06b6d4', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', weight: 'bold' } }
                    }
                },
                cutout: '70%'
            }
        });

        // Chart 2: Category Distribution
        const catData = @json($categoryCounts);
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(catData),
                datasets: [{
                    label: 'Tasks Count',
                    data: Object.values(catData),
                    backgroundColor: '#6366f1',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans' } }, grid: { display: false } },
                    y: { ticks: { color: '#94a3b8', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.05)' } }
                }
            }
        });
    });
</script>
@endsection
