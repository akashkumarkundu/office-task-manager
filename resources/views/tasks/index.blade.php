@extends('layouts.app')

@section('title', 'All Office Tasks')

@section('content')
<div class="mb-4">
    <!-- Top Action Bar & Multi-View Switcher -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 font-heading">
                <i class="fa-solid fa-list-check text-primary me-2"></i>Task Management
            </h3>
            <p class="text-muted small mb-0">Track, prioritize, and log hours across all active office projects.</p>
        </div>

        <div class="d-flex flex-wrap gap-2 align-items-center">
            <!-- View Mode Switcher (Table / Kanban / Focus) -->
            <div class="btn-group p-1 rounded-4 shadow-sm" role="group" style="background: var(--surface); border: 1px solid var(--border-color);">
                <button type="button" class="btn btn-sm px-3 fw-bold rounded-3 {{ request('view', 'table') === 'table' ? 'btn-primary shadow-sm' : 'btn-transparent text-muted' }}" id="tableViewBtn">
                    <i class="fa-solid fa-table-list me-1"></i> Table
                </button>
                <button type="button" class="btn btn-sm px-3 fw-bold rounded-3 {{ request('view') === 'kanban' ? 'btn-primary shadow-sm' : 'btn-transparent text-muted' }}" id="kanbanViewBtn">
                    <i class="fa-solid fa-table-columns me-1"></i> Kanban
                </button>
            </div>

            <!-- CSV Export Feature Flag -->
            @if(config('office.enable_task_export', true))
                <a href="{{ route('tasks.export', request()->query()) }}" class="btn btn-outline-success btn-sm px-3 py-2 fw-bold rounded-3" style="border-radius: 12px;">
                    <i class="fa-solid fa-file-csv me-1"></i> Export CSV
                </a>
            @endif

            <!-- Create Task Button -->
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--accent)); border: none;">
                <i class="fa-solid fa-plus me-1"></i> New Task
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card-custom p-3 p-md-4 mb-4">
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-center" id="filterForm">
            <!-- Retain current view mode -->
            <input type="hidden" name="view" id="viewModeInput" value="{{ request('view', 'table') }}">

            <!-- Search input -->
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted" style="border-color: var(--border-color);">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="Search title, tags, assignee..." 
                           value="{{ request('search') }}"
                           style="background: var(--surface); color: var(--text-main); border-color: var(--border-color);">
                </div>
            </div>

            <!-- Status filter -->
            <div class="col-6 col-md-2 col-lg-2">
                <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color);">
                    <option value="">All Statuses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <!-- Priority filter (Supports Urgent) -->
            <div class="col-6 col-md-2 col-lg-2">
                <select name="priority" class="form-select" onchange="document.getElementById('filterForm').submit()" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color);">
                    <option value="">All Priorities</option>
                    <option value="Urgent" {{ request('priority') == 'Urgent' ? 'selected' : '' }}>🔥 Urgent</option>
                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>

            <!-- Category filter -->
            <div class="col-6 col-md-2 col-lg-2">
                <select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color);">
                    <option value="">All Categories</option>
                    @foreach($availableCategories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Quick Filter Preset -->
            <div class="col-6 col-md-2 col-lg-2">
                <select name="filter" class="form-select" onchange="document.getElementById('filterForm').submit()" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color);">
                    <option value="">Filter Mode</option>
                    <option value="pinned" {{ request('filter') == 'pinned' ? 'selected' : '' }}>📌 Pinned Tasks</option>
                    <option value="overdue" {{ request('filter') == 'overdue' ? 'selected' : '' }}>⚠️ Overdue Only</option>
                    <option value="due_soon" {{ request('filter') == 'due_soon' ? 'selected' : '' }}>⏰ Due in 3 Days</option>
                </select>
            </div>

            <!-- Submit & Reset -->
            <div class="col-12 col-md-auto d-flex gap-1 ms-auto">
                <button type="submit" class="btn btn-primary fw-semibold px-3" style="border-radius: 10px;">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'priority', 'category', 'filter', 'tag']))
                    <a href="{{ route('tasks.index', ['view' => request('view', 'table')]) }}" class="btn btn-outline-secondary" title="Clear Filters" style="border-radius: 10px;">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Active Filters Badges -->
    @if(request()->hasAny(['search', 'status', 'priority', 'category', 'filter', 'tag']))
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <small class="text-muted fw-bold">Active Filters:</small>
            @if(request('search'))
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
                    Search: "{{ request('search') }}"
                </span>
            @endif
            @if(request('status'))
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
                    Status: {{ request('status') }}
                </span>
            @endif
            @if(request('priority'))
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
                    Priority: {{ request('priority') }}
                </span>
            @endif
            @if(request('filter'))
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                    Preset: {{ ucfirst(str_replace('_', ' ', request('filter'))) }}
                </span>
            @endif
            <a href="{{ route('tasks.index', ['view' => request('view', 'table')]) }}" class="text-danger small text-decoration-none fw-bold ms-2">
                <i class="fa-solid fa-xmark me-1"></i> Clear all
            </a>
        </div>
    @endif

    <!-- ==========================================================
         VIEW 1: DATAGRID TABLE VIEW
         ========================================================== -->
    <div id="tableContainer" class="{{ request('view', 'table') === 'table' ? 'd-block' : 'd-none' }}">
        <div class="card-custom overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="color: var(--text-main);">
                    <thead style="background: var(--surface-hover); border-bottom: 1px solid var(--border-color);">
                        <tr>
                            <th class="ps-3 py-3" style="width: 40px;"></th>
                            <th class="py-3">Task Title & Tags</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Assigned To</th>
                            <th class="py-3">Priority</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Time & Budget</th>
                            <th class="py-3">Due Date</th>
                            <th class="pe-3 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr class="{{ $task->is_pinned ? 'table-warning bg-opacity-10' : '' }}" style="border-bottom: 1px solid var(--border-color);">
                            <!-- Pin Toggle Button -->
                            <td class="ps-3">
                                <button type="button" class="pin-btn {{ $task->is_pinned ? 'pinned' : '' }}" title="{{ $task->is_pinned ? 'Unpin task' : 'Pin to top' }}" onclick="togglePinTask({{ $task->id }}, this)">
                                    <i class="fa-solid fa-thumbtack"></i>
                                </button>
                            </td>

                            <!-- Title & Subtask Progress -->
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('tasks.show', $task) }}" class="fw-bold text-decoration-none text-reset">
                                        {{ $task->title }}
                                    </a>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach($task->tags_array as $t)
                                            <span class="tag-pill">#{{ $t }}</span>
                                        @endforeach
                                        @if($task->subtasks->count() > 0)
                                            <span class="badge bg-secondary bg-opacity-25 text-body small rounded-pill px-2 py-0" style="font-size: 0.68rem;">
                                                <i class="fa-solid fa-list-check me-1"></i> {{ $task->subtask_progress }}% Subtasks
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td>
                                <span class="badge-cat {{ $task->category_color }}">{{ $task->category ?? 'General' }}</span>
                            </td>

                            <!-- Assigned To -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle">
                                        {{ substr($task->assigned_to, 0, 1) }}
                                    </div>
                                    <span class="small fw-semibold">{{ $task->assigned_to }}</span>
                                </div>
                            </td>

                            <!-- Priority -->
                            <td>
                                <span class="badge {{ $task->priority_badge_class }} rounded-pill px-3 py-2" style="font-size: 0.75rem;">
                                    <i class="{{ $task->priority_icon }} me-1"></i> {{ $task->priority }}
                                </span>
                            </td>

                            <!-- Quick Status Dropdown -->
                            <td>
                                <select class="form-select form-select-sm quick-status-dropdown fw-bold status-pill badge-status-{{ str_replace(' ', '', $task->status) }}" 
                                        data-task-id="{{ $task->id }}" 
                                        style="width: auto; cursor: pointer; border-radius: 9999px;">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </td>

                            <!-- Time & Budget -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="font-monospace small fw-bold text-primary">
                                        {{ $task->spent_hours }}h / {{ $task->estimated_hours ?? 8 }}h
                                    </div>
                                    <!-- Quick 1-Click Stopwatch Trigger -->
                                    <button type="button" class="btn btn-sm btn-outline-primary px-2 py-1 rounded-circle" title="Start Live Stopwatch" onclick="startTaskTimer({{ $task->id }}, '{{ addslashes($task->title) }}')">
                                        <i class="fa-solid fa-play" style="font-size: 0.65rem;"></i>
                                    </button>
                                </div>
                            </td>

                            <!-- Due Date -->
                            <td>
                                <div class="small fw-bold {{ $task->is_overdue ? 'text-danger' : ($task->is_due_soon ? 'text-warning' : '') }}">
                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No Date' }}
                                    @if($task->is_overdue)
                                        <span class="badge bg-danger text-white rounded-pill px-2" style="font-size: 0.65rem;">OVERDUE</span>
                                    @elseif($task->is_due_soon)
                                        <span class="badge bg-warning text-dark rounded-pill px-2" style="font-size: 0.65rem;">DUE SOON</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="pe-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-info rounded-circle" title="View details">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit task">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete task" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content card-custom text-start">
                                            <div class="modal-header border-bottom border-secondary border-opacity-25">
                                                <h5 class="modal-title font-heading text-danger">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Delete Task
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-4">
                                                Are you sure you want to permanently delete task <strong>"{{ $task->title }}"</strong>? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer border-top border-secondary border-opacity-25">
                                                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger rounded-3 fw-bold">Confirm Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fs-1 mb-3 d-block opacity-50"></i>
                                <h6 class="fw-bold">No tasks found matching your filters.</h6>
                                <p class="small mb-3">Try adjusting your search criteria or create a new task.</p>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm px-3 rounded-pill fw-bold">
                                    <i class="fa-solid fa-plus me-1"></i> Create First Task
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Container -->
            @if($tasks->hasPages())
                <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
                    </small>
                    <div>
                        {{ $tasks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- ==========================================================
         VIEW 2: INTERACTIVE KANBAN BOARD VIEW
         ========================================================== -->
    <div id="kanbanContainer" class="{{ request('view') === 'kanban' ? 'd-block' : 'd-none' }}">
        <div class="row g-4">
            <!-- Column 1: Pending -->
            <div class="col-lg-4">
                <div class="card-custom p-3" style="border-top: 4px solid #f59e0b !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="fw-bold font-heading d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark rounded-pill px-2">Pending</span>
                            <span class="text-muted small">({{ $allFilteredTasks->where('status', 'Pending')->count() }})</span>
                        </div>
                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-outline-warning rounded-circle px-2 py-1"><i class="fa-solid fa-plus"></i></a>
                    </div>
                    <div class="kanban-col-body d-flex flex-column gap-3" style="min-height: 500px;">
                        @foreach($allFilteredTasks->where('status', 'Pending') as $task)
                            @include('tasks._kanban_card', ['task' => $task])
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Column 2: In Progress -->
            <div class="col-lg-4">
                <div class="card-custom p-3" style="border-top: 4px solid #06b6d4 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="fw-bold font-heading d-flex align-items-center gap-2">
                            <span class="badge bg-info text-dark rounded-pill px-2">In Progress</span>
                            <span class="text-muted small">({{ $allFilteredTasks->where('status', 'In Progress')->count() }})</span>
                        </div>
                        <span class="pulse-dot"></span>
                    </div>
                    <div class="kanban-col-body d-flex flex-column gap-3" style="min-height: 500px;">
                        @foreach($allFilteredTasks->where('status', 'In Progress') as $task)
                            @include('tasks._kanban_card', ['task' => $task])
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Column 3: Completed -->
            <div class="col-lg-4">
                <div class="card-custom p-3" style="border-top: 4px solid #10b981 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="fw-bold font-heading d-flex align-items-center gap-2">
                            <span class="badge bg-success text-white rounded-pill px-2">Completed</span>
                            <span class="text-muted small">({{ $allFilteredTasks->where('status', 'Completed')->count() }})</span>
                        </div>
                        <i class="fa-solid fa-circle-check text-success"></i>
                    </div>
                    <div class="kanban-col-body d-flex flex-column gap-3" style="min-height: 500px;">
                        @foreach($allFilteredTasks->where('status', 'Completed') as $task)
                            @include('tasks._kanban_card', ['task' => $task])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // View Switcher Handlers
    const tableViewBtn = document.getElementById('tableViewBtn');
    const kanbanViewBtn = document.getElementById('kanbanViewBtn');
    const tableContainer = document.getElementById('tableContainer');
    const kanbanContainer = document.getElementById('kanbanContainer');
    const viewModeInput = document.getElementById('viewModeInput');

    tableViewBtn.addEventListener('click', () => {
        tableContainer.classList.replace('d-none', 'd-block');
        kanbanContainer.classList.replace('d-block', 'd-none');
        tableViewBtn.className = 'btn btn-sm px-3 fw-bold rounded-3 btn-primary shadow-sm';
        kanbanViewBtn.className = 'btn btn-sm px-3 fw-bold rounded-3 btn-transparent text-muted';
        viewModeInput.value = 'table';
    });

    kanbanViewBtn.addEventListener('click', () => {
        kanbanContainer.classList.replace('d-none', 'd-block');
        tableContainer.classList.replace('d-block', 'd-none');
        kanbanViewBtn.className = 'btn btn-sm px-3 fw-bold rounded-3 btn-primary shadow-sm';
        tableViewBtn.className = 'btn btn-sm px-3 fw-bold rounded-3 btn-transparent text-muted';
        viewModeInput.value = 'kanban';
    });
</script>
@endsection
