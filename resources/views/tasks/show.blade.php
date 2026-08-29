@extends('layouts.app')

@section('title', 'Task: ' . $task->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Breadcrumb & Top Actions -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 260px;" aria-current="page">{{ $task->title }}</li>
                </ol>
            </nav>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-1 fw-bold rounded-pill" onclick="window.print()">
                    <i class="fa-solid fa-print me-1"></i> Print Task Sheet
                </button>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm px-3 py-1 fw-bold rounded-pill">
                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit Task
                </a>
            </div>
        </div>

        <!-- Main Task Workspace Card -->
        <div class="card-custom p-4 p-md-5 mb-4 shadow-lg position-relative" style="{{ $task->is_pinned ? 'border-top: 6px solid #f59e0b !important;' : '' }}">
            <!-- Header Badges Row -->
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <!-- Category Badge -->
                    <span class="badge-cat {{ $task->category_color }} fs-6 px-3 py-2 rounded-pill">
                        <i class="fa-solid fa-tag me-1"></i> {{ $task->category ?? 'General' }}
                    </span>

                    <!-- Priority Badge -->
                    <span class="badge {{ $task->priority_badge_class }} px-3 py-2 rounded-pill fs-6">
                        <i class="{{ $task->priority_icon }} me-1"></i> {{ $task->priority }} Priority
                    </span>

                    <!-- Status Pill -->
                    <span class="status-pill badge-status-{{ str_replace(' ', '', $task->status) }} fs-6 px-3 py-2">
                        @if($task->status === 'In Progress') <span class="pulse-dot me-1"></span> @endif
                        {{ $task->status }}
                    </span>

                    <!-- Overdue or Due Soon Alert -->
                    @if($task->is_overdue)
                        <span class="badge bg-danger text-white fs-6 rounded-pill px-3 py-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> OVERDUE
                        </span>
                    @elseif($task->is_due_soon)
                        <span class="badge bg-warning text-dark fs-6 rounded-pill px-3 py-2">
                            <i class="fa-regular fa-clock me-1"></i> Due Soon
                        </span>
                    @endif
                </div>

                <div class="text-muted small font-monospace">
                    Task Ref: <strong>#TSK-{{ str_pad($task->id, 5, '0', STR_PAD_LEFT) }}</strong>
                </div>
            </div>

            <!-- Title -->
            <h2 class="fw-bold font-heading mb-3">{{ $task->title }}</h2>

            <!-- Tags -->
            @if(!empty($task->tags))
                <div class="d-flex flex-wrap gap-1 mb-4">
                    @foreach($task->tags_array as $tag)
                        <span class="tag-pill fs-6 px-3 py-1">#{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <!-- Description Block -->
            <div class="p-3 rounded-4 mb-4" style="background: var(--surface-hover); border: 1px solid var(--border-color); line-height: 1.7;">
                @if($task->description)
                    {!! nl2br(e($task->description)) !!}
                @else
                    <em class="text-muted">No additional description provided.</em>
                @endif
            </div>

            <!-- 4-Column Metadata & Stopwatch Grid -->
            <div class="row g-3 mb-4">
                <!-- Assignee -->
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 rounded-4 card-custom h-100">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.72rem;">Assigned Member</small>
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-2" style="width: 32px; height: 32px;">
                                {{ substr($task->assigned_to, 0, 1) }}
                            </div>
                            <span class="fw-bold text-truncate">{{ $task->assigned_to }}</span>
                        </div>
                    </div>
                </div>

                <!-- Due Date -->
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 rounded-4 card-custom h-100">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.72rem;">Due Date</small>
                        <div class="fw-bold text-primary">
                            <i class="fa-regular fa-calendar me-1"></i> {{ $task->due_date ? $task->due_date->format('M d, Y') : 'None' }}
                        </div>
                    </div>
                </div>

                <!-- Time Budget -->
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 rounded-4 card-custom h-100">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.72rem;">Spent / Estimate</small>
                        <div class="fw-bold font-monospace text-warning">
                            {{ $task->spent_hours }}h / {{ $task->estimated_hours ?? 8 }}h
                        </div>
                    </div>
                </div>

                <!-- Live Stopwatch Action Widget -->
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 rounded-4 card-custom h-100 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.15), rgba(var(--accent-rgb), 0.15)); border: 1px solid var(--primary);">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.72rem;">Interactive Stopwatch</small>
                        <div class="d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-sm btn-primary fw-bold rounded-pill px-3" onclick="startTaskTimer({{ $task->id }}, '{{ addslashes($task->title) }}')">
                                <i class="fa-solid fa-play me-1"></i> Start
                            </button>
                            <button type="button" class="btn btn-sm btn-danger fw-bold rounded-pill px-3" onclick="stopAndLogTaskTimer({{ $task->id }})">
                                <i class="fa-solid fa-stop me-1"></i> Log
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subtasks Checklist Section -->
            <div class="card-custom p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-1 font-heading">
                            <i class="fa-solid fa-list-check text-primary me-2"></i> Subtasks & Deliverables Checklist
                        </h5>
                        <p class="text-muted small mb-0">{{ $task->subtasks->where('is_completed', true)->count() }} of {{ $task->subtasks->count() }} items completed ({{ $task->subtask_progress }}%)</p>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ $task->subtask_progress }}%</span>
                </div>

                <!-- Progress Bar -->
                <div class="progress mb-3" style="height: 8px; background: var(--surface-hover);">
                    <div class="progress-bar" style="width: {{ $task->subtask_progress }}%; background: linear-gradient(90deg, var(--primary), var(--accent));"></div>
                </div>

                <!-- Subtasks List -->
                <div class="list-group list-group-flush mb-3">
                    @forelse($task->subtasks as $subtask)
                    <div class="list-group-item px-0 py-2 bg-transparent border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <form action="{{ route('subtasks.toggle', $subtask) }}" method="POST" class="d-flex align-items-center gap-2 flex-grow-1">
                            @csrf
                            @method('PATCH')
                            <input class="form-check-input mt-0" type="checkbox" onchange="this.form.submit()" {{ $subtask->is_completed ? 'checked' : '' }} style="cursor: pointer; width: 20px; height: 20px;">
                            <span class="{{ $subtask->is_completed ? 'text-decoration-line-through text-muted' : 'fw-semibold' }}">
                                {{ $subtask->title }}
                            </span>
                        </form>
                        <form action="{{ route('subtasks.destroy', $subtask) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm text-danger" title="Delete subtask"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </div>
                    @empty
                    <div class="text-muted small py-2">No subtasks added yet. Add checklist items below.</div>
                    @endforelse
                </div>

                <!-- Add Subtask Form -->
                <form action="{{ route('subtasks.store', $task) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="title" class="form-control" placeholder="Add a new checklist step..." required style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    <button type="submit" class="btn btn-primary fw-bold px-4" style="border-radius: 12px;">Add</button>
                </form>
            </div>

            <!-- Task Discussion Comments Section -->
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3 font-heading">
                    <i class="fa-solid fa-comments text-accent me-2"></i> Team Discussion & Activity Log ({{ $task->comments->count() }})
                </h5>

                <!-- Comments Feed -->
                <div class="d-flex flex-column gap-3 mb-4">
                    @forelse($task->comments as $comment)
                    <div class="p-3 rounded-4" style="background: var(--surface-hover); border: 1px solid var(--border-color);">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle" style="width: 26px; height: 26px; font-size: 0.7rem;">
                                    {{ substr($comment->user_name, 0, 1) }}
                                </div>
                                <span class="fw-bold">{{ $comment->user_name }}</span>
                            </div>
                            <small class="text-muted">{{ $comment->created_at ? $comment->created_at->diffForHumans() : 'Recently' }}</small>
                        </div>
                        <p class="mb-0 text-body small" style="line-height: 1.6;">{{ $comment->comment }}</p>
                    </div>
                    @empty
                    <div class="text-muted small text-center py-3">No comments posted yet. Start the conversation below.</div>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('tasks.comments.store', $task) }}" method="POST">
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <input type="text" name="user_name" class="form-control" placeholder="Your name (e.g. Emon Ahmed)" value="Emon Ahmed" required style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 10px;">
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="comment" class="form-control" placeholder="Write a note, update, or blocker..." required style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 10px;">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold rounded-pill">
                            <i class="fa-regular fa-paper-plane me-1"></i> Post Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
