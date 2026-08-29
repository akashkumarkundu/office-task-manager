@extends('layouts.app')

@section('title', 'Dashboard - ' . config('office.app_name', 'Office Task Tracker'))

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-md-7">
        <h2 class="fw-bold mb-1">
            <i class="fa-solid fa-gauge-high text-primary me-2"></i>Workspace Overview
        </h2>
        <p class="text-muted mb-0">Live task metrics, performance indicators, and urgent priorities for {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}.</p>
    </div>
    <div class="col-md-5 text-md-end d-flex gap-2 justify-content-md-end">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 fw-semibold">
            <i class="fa-solid fa-table-list me-1"></i> Task List
        </a>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary px-3 py-2 rounded-3 fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> New Task
        </a>
    </div>
</div>

<!-- 5 Real-Time Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Total Tasks -->
    <div class="col-sm-6 col-lg-4 col-xl-2.4 col-md-4">
        <div class="card stat-card bg-gradient-total shadow-sm">
            <div class="stat-label">Total Tasks</div>
            <div class="stat-value">{{ $totalTasks }}</div>
            <div class="stat-icon">
                <i class="fa-solid fa-list-check"></i>
            </div>
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="col-sm-6 col-lg-4 col-xl-2.4 col-md-4">
        <div class="card stat-card bg-gradient-pending shadow-sm">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $pendingTasks }}</div>
            <div class="stat-icon">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- In Progress Tasks -->
    <div class="col-sm-6 col-lg-4 col-xl-2.4 col-md-4">
        <div class="card stat-card bg-gradient-progress shadow-sm">
            <div class="stat-label">In Progress</div>
            <div class="stat-value">{{ $inProgressTasks }}</div>
            <div class="stat-icon">
                <i class="fa-solid fa-spinner"></i>
            </div>
        </div>
    </div>

    <!-- Completed Tasks -->
    <div class="col-sm-6 col-lg-6 col-xl-2.4 col-md-6">
        <div class="card stat-card bg-gradient-completed shadow-sm">
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $completedTasks }}</div>
            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- High Priority Tasks -->
    <div class="col-sm-6 col-lg-6 col-xl-2.4 col-md-6">
        <div class="card stat-card bg-gradient-urgent shadow-sm">
            <div class="stat-label">High Priority</div>
            <div class="stat-value">{{ $highPriorityTasks }}</div>
            <div class="stat-icon">
                <i class="fa-solid fa-fire"></i>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Analytics Charts Row -->
<div class="row g-4 mb-4">
    <!-- Status Breakdown Donut Chart -->
    <div class="col-lg-6">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-chart-pie text-primary me-2"></i>Task Status Breakdown
                </h5>
                <span class="badge bg-light text-dark border px-2 py-1">Real-Time</span>
            </div>
            <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 250px;">
                @if($totalTasks > 0)
                    <canvas id="statusChart" style="max-height: 240px; max-width: 100%;"></canvas>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fa-regular fa-folder-open fs-2 mb-2 d-block opacity-50"></i>
                        No tasks available to visualize yet.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Priority Distribution Bar Chart -->
    <div class="col-lg-6">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-chart-column text-info me-2"></i>Priority Distribution
                </h5>
                <span class="badge bg-light text-dark border px-2 py-1">Low / Med / High</span>
            </div>
            <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 250px;">
                @if($totalTasks > 0)
                    <canvas id="priorityChart" style="max-height: 240px; max-width: 100%;"></canvas>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fa-regular fa-folder-open fs-2 mb-2 d-block opacity-50"></i>
                        No tasks available to visualize yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Completion Rate Progress Card -->
<div class="card card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h5 class="fw-bold mb-0">
                <i class="fa-solid fa-chart-line text-success me-2"></i>Overall Completion Rate
            </h5>
            <small class="text-muted">{{ $completedTasks }} of {{ $totalTasks }} total tasks resolved</small>
        </div>
        <div class="fs-4 fw-extrabold text-success">
            {{ $completionPercentage }}%
        </div>
    </div>
    <div class="progress" style="height: 14px; border-radius: 9999px; background-color: rgba(148, 163, 184, 0.2);">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
             style="width: {{ $completionPercentage }}%;" 
             aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
</div>

<!-- Widgets Row: Due Soon (Bonus) + Recent Tasks -->
<div class="row g-4 mb-4">
    <!-- Due Soon Widget (Next 3 Days) -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header bg-transparent border-bottom p-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-warning-emphasis">
                    <i class="fa-regular fa-clock text-warning me-2"></i>Due Soon (Next 3 Days)
                </h5>
                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1">
                    {{ $dueSoonCount }} {{ Str::plural('Task', $dueSoonCount) }}
                </span>
            </div>
            <div class="card-body p-0">
                @forelse($dueSoonTasks as $task)
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center hover-bg">
                        <div>
                            <a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-decoration-none text-body">
                                {{ $task->title }}
                            </a>
                            <div class="small text-muted mt-1">
                                <span class="me-2"><i class="fa-regular fa-user me-1"></i>{{ $task->assigned_to }}</span>
                                <span><i class="fa-regular fa-calendar me-1"></i>Due: {{ $task->due_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div>
                            @if($task->is_overdue)
                                <span class="badge badge-overdue">OVERDUE</span>
                            @else
                                <span class="badge badge-due-soon">Due Soon</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i>
                        No urgent tasks due in the next 3 days. All clear!
                    </div>
                @endforelse
            </div>
            @if($dueSoonCount > 0)
                <div class="card-footer bg-transparent border-0 p-3 text-end">
                    <a href="{{ route('tasks.index', ['filter' => 'due_soon']) }}" class="btn btn-sm btn-outline-warning fw-semibold">
                        View All Due Soon <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent 5 Tasks Widget -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header bg-transparent border-bottom p-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-bolt text-primary me-2"></i>Recent Activity
                </h5>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-link text-decoration-none fw-semibold">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentTasks as $task)
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @php
                                $words = explode(' ', trim($task->assigned_to));
                                $initials = strtoupper(substr($words[0] ?? 'U', 0, 1) . substr($words[1] ?? '', 0, 1));
                            @endphp
                            <div class="avatar-circle">{{ $initials ?: 'U' }}</div>
                            <div>
                                <a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-decoration-none text-body d-block">
                                    {{ $task->title }}
                                </a>
                                <small class="text-muted">
                                    Assigned to <span class="fw-medium">{{ $task->assigned_to }}</span> &bull; {{ $task->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge badge-priority-{{ $task->priority }} px-2 py-1">
                                {{ $task->priority }}
                            </span>
                            <span class="badge badge-status-{{ str_replace(' ', '', $task->status) }} px-2 py-1">
                                {{ $task->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="fa-regular fa-folder-open fs-2 mb-2 d-block"></i>
                        No recent tasks created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Initialization Script -->
@if($totalTasks > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        const textColor = isDark ? '#94a3b8' : '#64748b';

        // Status Donut Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In Progress', 'Completed'],
                datasets: [{
                    data: [{{ $pendingTasks }}, {{ $inProgressTasks }}, {{ $completedTasks }}],
                    backgroundColor: ['#f59e0b', '#0284c7', '#10b981'],
                    borderWidth: 2,
                    borderColor: isDark ? '#1e293b' : '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, font: { family: 'Inter', weight: 600 } }
                    }
                },
                cutout: '70%'
            }
        });

        // Priority Bar Chart
        const priorityCtx = document.getElementById('priorityChart').getContext('2d');
        const priorityChart = new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: ['Low', 'Medium', 'High'],
                datasets: [{
                    label: 'Tasks by Priority',
                    data: [{{ $lowPriorityTasks }}, {{ $mediumPriorityTasks }}, {{ $highPriorityTasks }}],
                    backgroundColor: ['#94a3b8', '#f59e0b', '#ef4444'],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: textColor },
                        grid: { color: isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)' }
                    },
                    x: {
                        ticks: { color: textColor, font: { family: 'Inter', weight: 600 } },
                        grid: { display: false }
                    }
                }
            }
        });

        // Update charts on theme toggle
        window.addEventListener('themeChanged', function() {
            const dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            const color = dark ? '#94a3b8' : '#64748b';
            
            statusChart.data.datasets[0].borderColor = dark ? '#1e293b' : '#ffffff';
            statusChart.options.plugins.legend.labels.color = color;
            statusChart.update();

            priorityChart.options.scales.y.ticks.color = color;
            priorityChart.options.scales.x.ticks.color = color;
            priorityChart.options.scales.y.grid.color = dark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
            priorityChart.update();
        });
    });
</script>
@endif
@endsection
