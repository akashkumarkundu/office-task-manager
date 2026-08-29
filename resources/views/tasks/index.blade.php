@extends('layouts.app')

@section('title', 'Tasks Management - ' . config('office.app_name', 'Office Task Tracker'))

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="fa-solid fa-tasks text-primary me-2"></i>Task Directory
        </h2>
        <p class="text-muted mb-0">Manage, filter, and track all office assignments in real time.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <!-- View Mode Switcher -->
        <div class="btn-group shadow-sm me-2" role="group" aria-label="View Mode">
            <button type="button" class="btn btn-outline-primary active fw-semibold" id="tableViewBtn" onclick="switchView('table')">
                <i class="fa-solid fa-table me-1"></i> Table
            </button>
            <button type="button" class="btn btn-outline-primary fw-semibold" id="kanbanViewBtn" onclick="switchView('kanban')">
                <i class="fa-solid fa-table-columns me-1"></i> Kanban
            </button>
        </div>

        @if(config('office.enable_task_export', true))
            <a href="{{ route('tasks.export', request()->query()) }}" class="btn btn-outline-success px-3 py-2 rounded-3 fw-semibold shadow-sm">
                <i class="fa-solid fa-file-csv me-1"></i> Export CSV
            </a>
        @endif
        <a href="{{ route('tasks.create') }}" class="btn btn-primary px-3 py-2 rounded-3 fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Task
        </a>
    </div>
</div>

<!-- Search & Multi-Filter Bar -->
<div class="card card-custom p-3 mb-4 shadow-sm">
    <form action="{{ route('tasks.index') }}" method="GET" class="row g-2 align-items-center">
        <!-- Search Input -->
        <div class="col-md-4 col-lg-5">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 text-muted">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" 
                       placeholder="Search by task title or assigned person..." 
                       value="{{ request('search') }}">
            </div>
        </div>

        <!-- Status Filter -->
        <div class="col-6 col-md-3 col-lg-2">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <!-- Priority Filter -->
        <div class="col-6 col-md-3 col-lg-2">
            <select name="priority" class="form-select">
                <option value="">All Priorities</option>
                <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low Priority</option>
                <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High Priority</option>
            </select>
        </div>

        <!-- Quick Filter Preset Keep -->
        @if(request('filter'))
            <input type="hidden" name="filter" value="{{ request('filter') }}">
        @endif

        <!-- Filter Actions -->
        <div class="col-12 col-md-2 col-lg-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100 fw-semibold">
                <i class="fa-solid fa-filter me-1"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'priority', 'filter']))
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary fw-semibold px-3" title="Clear Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Active Filter Indicator (if any) -->
@if(request('filter') == 'overdue')
    <div class="alert alert-danger py-2 px-3 rounded-3 d-flex justify-content-between align-items-center mb-3">
        <span><i class="fa-solid fa-triangle-exclamation me-1"></i> Showing only <strong>Overdue Tasks</strong></span>
        <a href="{{ route('tasks.index') }}" class="btn-close btn-sm" aria-label="Close"></a>
    </div>
@elseif(request('filter') == 'due_soon')
    <div class="alert alert-warning py-2 px-3 rounded-3 d-flex justify-content-between align-items-center mb-3">
        <span><i class="fa-regular fa-clock me-1"></i> Showing tasks <strong>Due Soon (Next 3 Days)</strong></span>
        <a href="{{ route('tasks.index') }}" class="btn-close btn-sm" aria-label="Close"></a>
    </div>
@endif

<!-- VIEW 1: Traditional Responsive Table View -->
<div id="tableViewContainer">
    <div class="card card-custom overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30%;">TASK DETAILS</th>
                        <th style="width: 20%;">ASSIGNED TO</th>
                        <th style="width: 12%;">PRIORITY</th>
                        <th style="width: 18%;">STATUS (QUICK UPDATE)</th>
                        <th style="width: 10%;">DUE DATE</th>
                        <th style="width: 10%;" class="text-end pe-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="{{ $task->is_overdue ? 'table-danger-subtle' : '' }}">
                            <!-- Task Details -->
                            <td>
                                <div class="d-flex align-items-start">
                                    <div class="me-2 mt-1">
                                        @if($task->status === 'Completed')
                                            <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                        @elseif($task->is_overdue)
                                            <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
                                        @else
                                            <i class="fa-regular fa-circle-dot text-primary fs-5"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('tasks.show', $task) }}" class="fw-bold text-decoration-none text-body fs-6 d-block">
                                            {{ $task->title }}
                                        </a>
                                        @if($task->description)
                                            <small class="text-muted d-block text-truncate" style="max-width: 320px;">
                                                {{ $task->description }}
                                            </small>
                                        @endif
                                        @if($task->is_overdue)
                                            <span class="badge badge-overdue mt-1">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> OVERDUE
                                            </span>
                                        @elseif($task->is_due_soon)
                                            <span class="badge badge-due-soon mt-1">
                                                <i class="fa-regular fa-clock me-1"></i> Due Soon
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Assigned To with Avatar -->
                            <td>
                                @php
                                    $words = explode(' ', trim($task->assigned_to));
                                    $initials = strtoupper(substr($words[0] ?? 'U', 0, 1) . substr($words[1] ?? '', 0, 1));
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle">{{ $initials ?: 'U' }}</div>
                                    <span class="fw-medium">{{ $task->assigned_to }}</span>
                                </div>
                            </td>

                            <!-- Priority -->
                            <td>
                                <span class="badge badge-priority-{{ $task->priority }} px-3 py-2 fw-semibold">
                                    @if($task->priority == 'High')
                                        <i class="fa-solid fa-fire me-1"></i>
                                    @endif
                                    {{ $task->priority }}
                                </span>
                            </td>

                            <!-- Status with Quick Selector -->
                            <td>
                                <select class="form-select form-select-sm status-select-sm quick-status-dropdown" 
                                        data-task-id="{{ $task->id }}" 
                                        title="Click to instantly change status">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>⚡ In Progress</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                </select>
                            </td>

                            <!-- Due Date -->
                            <td>
                                <div class="{{ $task->is_overdue ? 'text-danger fw-bold' : '' }}">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ $task->due_date->format('M d, Y') }}
                                </div>
                                <small class="text-muted d-block">
                                    {{ $task->due_date->diffForHumans() }}
                                </small>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-secondary" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary" title="Edit Task">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete Task"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-start" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content card-custom">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel{{ $task->id }}">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Confirm Deletion
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                <p class="mb-2">Are you sure you want to delete this task?</p>
                                                <div class="p-3 bg-light rounded-3 border">
                                                    <strong>{{ $task->title }}</strong>
                                                    <div class="small text-muted mt-1">
                                                        Assigned to: {{ $task->assigned_to }} | Due: {{ $task->due_date->format('M d, Y') }}
                                                    </div>
                                                </div>
                                                <small class="text-danger mt-2 d-block">
                                                    <i class="fa-solid fa-info-circle me-1"></i> This action cannot be undone.
                                                </small>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                                                        <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fs-1 text-muted opacity-50 mb-3 d-block"></i>
                                <h5>No tasks found matching your criteria.</h5>
                                <p class="small mb-3">Try adjusting your search keywords or resetting filters.</p>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm px-3">
                                    <i class="fa-solid fa-plus me-1"></i> Create First Task
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Controls -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="small text-muted">
            Showing <strong>{{ $tasks->firstItem() ?? 0 }}</strong> to <strong>{{ $tasks->lastItem() ?? 0 }}</strong> of <strong>{{ $tasks->total() }}</strong> tasks
            (Page limit: {{ config('office.tasks_per_page', 10) }})
        </div>
        <div>
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- VIEW 2: Interactive Kanban Board View (Hidden by default) -->
<div id="kanbanViewContainer" style="display: none;">
    <div class="row g-4 mb-4">
        <!-- Column 1: Pending -->
        <div class="col-lg-4">
            <div class="kanban-col">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h6 class="fw-bold mb-0 text-warning-emphasis">
                        <i class="fa-regular fa-clock me-1"></i> PENDING
                    </h6>
                    <span class="badge bg-warning text-dark rounded-pill">
                        {{ $tasks->where('status', 'Pending')->count() }}
                    </span>
                </div>
                @forelse($tasks->where('status', 'Pending') as $task)
                    <div class="kanban-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge badge-priority-{{ $task->priority }} px-2 py-1">{{ $task->priority }}</span>
                            @if($task->is_overdue)
                                <span class="badge badge-overdue">OVERDUE</span>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-body">{{ $task->title }}</a>
                        </h6>
                        <p class="small text-muted mb-3 text-truncate">{{ $task->description }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div class="d-flex align-items-center">
                                @php
                                    $w = explode(' ', trim($task->assigned_to));
                                    $init = strtoupper(substr($w[0] ?? 'U', 0, 1) . substr($w[1] ?? '', 0, 1));
                                @endphp
                                <div class="avatar-circle" style="width:26px;height:26px;font-size:0.7rem;">{{ $init ?: 'U' }}</div>
                                <small class="fw-medium">{{ $task->assigned_to }}</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 quick-status-dropdown" 
                                    value="In Progress" data-task-id="{{ $task->id }}" title="Move to In Progress">
                                Start &rarr;
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No pending tasks.</div>
                @endforelse
            </div>
        </div>

        <!-- Column 2: In Progress -->
        <div class="col-lg-4">
            <div class="kanban-col">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h6 class="fw-bold mb-0 text-info-emphasis">
                        <i class="fa-solid fa-spinner me-1"></i> IN PROGRESS
                    </h6>
                    <span class="badge bg-info text-white rounded-pill">
                        {{ $tasks->where('status', 'In Progress')->count() }}
                    </span>
                </div>
                @forelse($tasks->where('status', 'In Progress') as $task)
                    <div class="kanban-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge badge-priority-{{ $task->priority }} px-2 py-1">{{ $task->priority }}</span>
                            @if($task->is_overdue)
                                <span class="badge badge-overdue">OVERDUE</span>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-body">{{ $task->title }}</a>
                        </h6>
                        <p class="small text-muted mb-3 text-truncate">{{ $task->description }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div class="d-flex align-items-center">
                                @php
                                    $w = explode(' ', trim($task->assigned_to));
                                    $init = strtoupper(substr($w[0] ?? 'U', 0, 1) . substr($w[1] ?? '', 0, 1));
                                @endphp
                                <div class="avatar-circle" style="width:26px;height:26px;font-size:0.7rem;">{{ $init ?: 'U' }}</div>
                                <small class="fw-medium">{{ $task->assigned_to }}</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success py-0 px-2 quick-status-dropdown" 
                                    value="Completed" data-task-id="{{ $task->id }}" title="Mark Complete">
                                Complete &#10003;
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No tasks in progress.</div>
                @endforelse
            </div>
        </div>

        <!-- Column 3: Completed -->
        <div class="col-lg-4">
            <div class="kanban-col">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h6 class="fw-bold mb-0 text-success-emphasis">
                        <i class="fa-solid fa-circle-check me-1"></i> COMPLETED
                    </h6>
                    <span class="badge bg-success text-white rounded-pill">
                        {{ $tasks->where('status', 'Completed')->count() }}
                    </span>
                </div>
                @forelse($tasks->where('status', 'Completed') as $task)
                    <div class="kanban-card opacity-75">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge badge-priority-{{ $task->priority }} px-2 py-1">{{ $task->priority }}</span>
                            <i class="fa-solid fa-check-double text-success"></i>
                        </div>
                        <h6 class="fw-bold mb-2 text-decoration-line-through text-muted">
                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-muted">{{ $task->title }}</a>
                        </h6>
                        <p class="small text-muted mb-3 text-truncate">{{ $task->description }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div class="d-flex align-items-center">
                                @php
                                    $w = explode(' ', trim($task->assigned_to));
                                    $init = strtoupper(substr($w[0] ?? 'U', 0, 1) . substr($w[1] ?? '', 0, 1));
                                @endphp
                                <div class="avatar-circle" style="width:26px;height:26px;font-size:0.7rem;">{{ $init ?: 'U' }}</div>
                                <small class="fw-medium text-muted">{{ $task->assigned_to }}</small>
                            </div>
                            <span class="badge bg-success-subtle text-success py-1 px-2">Done</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No completed tasks yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    function switchView(mode) {
        const tableView = document.getElementById('tableViewContainer');
        const kanbanView = document.getElementById('kanbanViewContainer');
        const tableBtn = document.getElementById('tableViewBtn');
        const kanbanBtn = document.getElementById('kanbanViewBtn');

        if (mode === 'kanban') {
            tableView.style.display = 'none';
            kanbanView.style.display = 'block';
            kanbanBtn.classList.add('active');
            tableBtn.classList.remove('active');
            localStorage.setItem('task_view_mode', 'kanban');
        } else {
            kanbanView.style.display = 'none';
            tableView.style.display = 'block';
            tableBtn.classList.add('active');
            kanbanBtn.classList.remove('active');
            localStorage.setItem('task_view_mode', 'table');
        }
    }

    // Persist View Mode
    document.addEventListener('DOMContentLoaded', () => {
        const savedView = localStorage.getItem('task_view_mode');
        if (savedView === 'kanban') {
            switchView('kanban');
        }
    });
</script>
@endsection
