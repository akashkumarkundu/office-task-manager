@extends('layouts.app')

@section('title', 'Tasks Management - ' . config('office.app_name', 'Office Task Tracker'))

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1 text-dark">
            <i class="fa-solid fa-tasks text-primary me-2"></i>Task Directory
        </h2>
        <p class="text-muted mb-0">Manage, filter, and track all office assignments in real time.</p>
    </div>
    <div class="d-flex gap-2">
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
                <span class="input-group-text bg-white border-end-0 text-muted">
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

<!-- Tasks Table Card -->
<div class="card card-custom overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 32%;">TASK DETAILS</th>
                    <th style="width: 20%;">ASSIGNED TO</th>
                    <th style="width: 12%;">PRIORITY</th>
                    <th style="width: 12%;">STATUS</th>
                    <th style="width: 14%;">DUE DATE</th>
                    <th style="width: 10%; text-align: center;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <!-- Task Title & Description -->
                        <td>
                            <div class="fw-bold text-dark fs-6 mb-1">
                                <a href="{{ route('tasks.show', $task) }}" class="text-dark text-decoration-none hover-primary">
                                    {{ $task->title }}
                                </a>
                            </div>
                            @if($task->description)
                                <p class="text-muted small mb-0 text-truncate" style="max-width: 380px;">
                                    {{ $task->description }}
                                </p>
                            @endif
                        </td>

                        <!-- Assigned To -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($task->assigned_to, 0, 1)) }}
                                </div>
                                <span class="fw-medium text-dark">{{ $task->assigned_to }}</span>
                            </div>
                        </td>

                        <!-- Priority Badge -->
                        <td>
                            <span class="badge badge-priority-{{ $task->priority }} px-3 py-2 rounded-pill fw-semibold">
                                @if($task->priority == 'High')
                                    <i class="fa-solid fa-fire me-1"></i>
                                @elseif($task->priority == 'Medium')
                                    <i class="fa-solid fa-minus me-1"></i>
                                @else
                                    <i class="fa-solid fa-arrow-down me-1"></i>
                                @endif
                                {{ $task->priority }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td>
                            @if($task->status == 'Completed')
                                <span class="badge badge-status-Completed px-3 py-2 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-circle-check me-1"></i> Completed
                                </span>
                            @elseif($task->status == 'In Progress')
                                <span class="badge badge-status-InProgress px-3 py-2 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-spinner me-1"></i> In Progress
                                </span>
                            @else
                                <span class="badge badge-status-Pending px-3 py-2 rounded-pill fw-semibold">
                                    <i class="fa-regular fa-clock me-1"></i> Pending
                                </span>
                            @endif
                        </td>

                        <!-- Due Date with Overdue Indicator -->
                        <td>
                            <div>
                                <span class="fw-medium text-dark">{{ $task->due_date->format('M d, Y') }}</span>
                            </div>
                            @if($task->is_overdue)
                                <div class="mt-1">
                                    <span class="badge badge-overdue small">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> OVERDUE
                                    </span>
                                </div>
                            @elseif($task->is_due_soon)
                                <div class="mt-1">
                                    <span class="badge badge-due-soon small">
                                        <i class="fa-regular fa-clock me-1"></i> Due Soon
                                    </span>
                                </div>
                            @endif
                        </td>

                        <!-- Action Buttons -->
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary" title="View Task Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary" title="Edit Task">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-delete-task" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-task-id="{{ $task->id }}" 
                                        data-task-title="{{ $task->title }}"
                                        data-delete-url="{{ route('tasks.destroy', $task) }}"
                                        title="Delete Task">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa-solid fa-folder-open fs-1 mb-3 text-secondary opacity-50"></i>
                                <h5 class="fw-bold text-dark">No tasks found</h5>
                                <p class="small mb-3">Try adjusting your search query or filters to find what you're looking for.</p>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-semibold">
                                    <i class="fa-solid fa-plus me-1"></i> Create First Task
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination & Meta Info -->
    @if($tasks->hasPages() || $tasks->total() > 0)
        <div class="card-footer bg-white border-top py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="text-muted small">
                Showing <strong>{{ $tasks->firstItem() ?? 0 }}</strong> to <strong>{{ $tasks->lastItem() ?? 0 }}</strong> of <strong>{{ $tasks->total() }}</strong> tasks
                <span class="ms-1 badge bg-light text-dark border">Page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }}</span>
            </div>
            <div>
                {{ $tasks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="deleteModalLabel">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Task Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-danger fs-1">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h5 class="fw-bold mb-2">Are you sure you want to delete this task?</h5>
                <p class="text-muted mb-0" id="deleteTaskTitleDisplay"></p>
                <div class="alert alert-warning small text-start mt-3 mb-0">
                    <i class="fa-solid fa-circle-info me-1"></i> This action is permanent and cannot be undone.
                </div>
            </div>
            <div class="modal-footer border-0 bg-light p-3 justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteTaskForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-semibold shadow-sm">
                        <i class="fa-solid fa-trash-can me-1"></i> Yes, Delete Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-task');
        const deleteForm = document.getElementById('deleteTaskForm');
        const deleteTitleDisplay = document.getElementById('deleteTaskTitleDisplay');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const deleteUrl = this.getAttribute('data-delete-url');
                const taskTitle = this.getAttribute('data-task-title');

                deleteForm.action = deleteUrl;
                deleteTitleDisplay.textContent = `Task: "${taskTitle}"`;
            });
        });
    });
</script>
@endsection
