@extends('layouts.app')

@section('title', 'Dashboard - ' . config('office.app_name', 'Office Task Tracker'))

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-md-7">
        <h2 class="fw-bold mb-1 text-dark">
            <i class="fa-solid fa-gauge-high text-primary me-2"></i>Workspace Overview
        </h2>
        <p class="text-muted mb-0">Live task metrics, performance indicators, and urgent priorities for {{ config('office.company_name', 'Zenith Core Ltd.') }}.</p>
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

<!-- Completion Rate Progress Card -->
<div class="card card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-chart-line text-success me-2"></i>Overall Completion Rate
            </h5>
            <small class="text-muted">{{ $completedTasks }} of {{ $totalTasks }} total tasks resolved</small>
        </div>
        <div class="fs-4 fw-extrabold text-success">
            {{ $completionPercentage }}%
        </div>
    </div>
    <div class="progress" style="height: 14px; border-radius: 9999px; background-color: #e2e8f0;">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
             style="width: {{ $completionPercentage }}%;" 
             aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
</div>

<!-- Two Column Section: Action Center & Recent Tasks -->
<div class="row g-4">
    <!-- Action Alerts: Overdue & Due Soon -->
    <div class="col-lg-5">
        <div class="card card-custom p-4 h-100">
            <h5 class="fw-bold mb-3 text-dark d-flex align-items-center">
                <i class="fa-solid fa-bell text-danger me-2"></i>Attention Required
            </h5>

            <!-- Overdue Alert -->
            <div class="card border-danger-subtle bg-danger-subtle bg-opacity-25 rounded-3 p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-danger">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Overdue Tasks
                        </div>
                        <small class="text-secondary">Passed deadline & not completed</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">{{ $overdueCount }}</span>
                        @if($overdueCount > 0)
                            <a href="{{ route('tasks.index', ['filter' => 'overdue']) }}" class="btn btn-sm btn-outline-danger">
                                View
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Due Soon Alert -->
            <div class="card border-warning-subtle bg-warning-subtle bg-opacity-25 rounded-3 p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-warning-emphasis">
                            <i class="fa-regular fa-clock me-1"></i> Due Soon (Next 3 Days)
                        </div>
                        <small class="text-secondary">Approaching submission deadline</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">{{ $dueSoonCount }}</span>
                        @if($dueSoonCount > 0)
                            <a href="{{ route('tasks.index', ['filter' => 'due_soon']) }}" class="btn btn-sm btn-outline-warning text-dark">
                                View
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Due Soon List Preview -->
            @if($dueSoonTasks->count() > 0)
                <h6 class="fw-bold text-muted small text-uppercase mb-2">Upcoming Deadlines</h6>
                <ul class="list-group list-group-flush rounded-3 border">
                    @foreach($dueSoonTasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <div class="text-truncate me-2" style="max-width: 220px;">
                                <a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-dark text-decoration-none small">
                                    {{ $task->title }}
                                </a>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    {{ $task->assigned_to }} &bull; Due: {{ $task->due_date->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="badge badge-priority-{{ $task->priority }} rounded-pill small">{{ $task->priority }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Recent 5 Tasks -->
    <div class="col-lg-7">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Recent Activity
                </h5>
                <a href="{{ route('tasks.index') }}" class="text-primary text-decoration-none small fw-semibold">
                    View All Tasks <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

            @if($recentTasks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="font-size: 0.8rem;" class="text-muted">TASK</th>
                                <th style="font-size: 0.8rem;" class="text-muted">ASSIGNED</th>
                                <th style="font-size: 0.8rem;" class="text-muted">STATUS</th>
                                <th style="font-size: 0.8rem;" class="text-muted">DUE DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTasks as $task)
                                <tr>
                                    <td>
                                        <a href="{{ route('tasks.show', $task) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $task->assigned_to }}</small>
                                    </td>
                                    <td>
                                        @if($task->status == 'Completed')
                                            <span class="badge badge-status-Completed rounded-pill px-2 py-1">Completed</span>
                                        @elseif($task->status == 'In Progress')
                                            <span class="badge badge-status-InProgress rounded-pill px-2 py-1">In Progress</span>
                                        @else
                                            <span class="badge badge-status-Pending rounded-pill px-2 py-1">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->is_overdue)
                                            <span class="badge badge-overdue small">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $task->due_date->format('M d') }}
                                            </span>
                                        @else
                                            <small class="text-muted">{{ $task->due_date->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-clipboard-check fs-2 mb-2"></i>
                    <p class="mb-0">No tasks created yet. Click "+ New Task" to get started!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
