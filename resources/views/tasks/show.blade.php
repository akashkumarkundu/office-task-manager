@extends('layouts.app')

@section('title', 'Task Details: ' . $task->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Breadcrumb & Top Actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Task #{{ $task->id }}</li>
                </ol>
            </nav>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-1 fw-semibold" onclick="window.print()">
                    <i class="fa-solid fa-print me-1"></i> Print Task Sheet
                </button>
            </div>
        </div>

        <!-- Main Task Card -->
        <div class="card card-custom overflow-hidden shadow-sm mb-4" id="printableTaskSheet">
            <!-- Printable Letterhead Header (Visible only on print or clean view) -->
            <div class="p-4 p-md-5 border-bottom">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <!-- Priority Badge -->
                        <span class="badge badge-priority-{{ $task->priority }} px-3 py-2 rounded-pill fw-semibold fs-6">
                            @if($task->priority == 'High')
                                <i class="fa-solid fa-fire me-1"></i>
                            @elseif($task->priority == 'Medium')
                                <i class="fa-solid fa-minus me-1"></i>
                            @else
                                <i class="fa-solid fa-arrow-down me-1"></i>
                            @endif
                            {{ $task->priority }} Priority
                        </span>

                        <!-- Status Badge -->
                        @if($task->status == 'Completed')
                            <span class="badge badge-status-Completed px-3 py-2 rounded-pill fw-semibold fs-6">
                                <i class="fa-solid fa-circle-check me-1"></i> Completed
                            </span>
                        @elseif($task->status == 'In Progress')
                            <span class="badge badge-status-InProgress px-3 py-2 rounded-pill fw-semibold fs-6">
                                <i class="fa-solid fa-spinner me-1"></i> In Progress
                            </span>
                        @else
                            <span class="badge badge-status-Pending px-3 py-2 rounded-pill fw-semibold fs-6">
                                <i class="fa-regular fa-clock me-1"></i> Pending
                            </span>
                        @endif

                        <!-- Overdue or Due Soon Badge -->
                        @if($task->is_overdue)
                            <span class="badge badge-overdue fs-6">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> OVERDUE
                            </span>
                        @elseif($task->is_due_soon)
                            <span class="badge badge-due-soon fs-6">
                                <i class="fa-regular fa-clock me-1"></i> Due Soon
                            </span>
                        @endif
                    </div>

                    <div class="text-muted small">
                        Task Reference: <strong>#TSK-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                </div>

                <h2 class="fw-bold mb-3">{{ $task->title }}</h2>

                <!-- Description Block -->
                <div class="p-3 rounded-3 border mb-4" style="line-height: 1.7; background: rgba(148, 163, 184, 0.08);">
                    @if($task->description)
                        {!! nl2br(e($task->description)) !!}
                    @else
                        <em class="text-muted">No additional notes or description provided for this task.</em>
                    @endif
                </div>

                <!-- Metadata Grid -->
                <div class="row g-3 py-2">
                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 card-custom">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1">Assigned Person</small>
                            <div class="d-flex align-items-center">
                                @php
                                    $w = explode(' ', trim($task->assigned_to));
                                    $init = strtoupper(substr($w[0] ?? 'U', 0, 1) . substr($w[1] ?? '', 0, 1));
                                @endphp
                                <div class="avatar-circle">
                                    {{ $init ?: 'U' }}
                                </div>
                                <span class="fw-bold fs-6">{{ $task->assigned_to }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 card-custom">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1">Deadline / Due Date</small>
                            <div class="fw-bold fs-6 d-flex align-items-center">
                                <i class="fa-regular fa-calendar-days text-primary me-2"></i>
                                {{ $task->due_date ? $task->due_date->format('F d, Y') : 'N/A' }}
                                <span class="text-muted small fw-normal ms-2">({{ $task->due_date ? $task->due_date->diffForHumans() : '' }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 card-custom">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1">Created At</small>
                            <div class="small">
                                <i class="fa-regular fa-clock me-1 text-muted"></i>
                                {{ $task->created_at ? $task->created_at->format('M d, Y h:i A') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 card-custom">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1">Last Updated</small>
                            <div class="small">
                                <i class="fa-solid fa-arrows-rotate me-1 text-muted"></i>
                                {{ $task->updated_at ? $task->updated_at->format('M d, Y h:i A') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SUBTASKS / CHECKLIST SECTION -->
            <div class="p-4 p-md-5 border-bottom bg-body-tertiary">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-list-check text-primary me-2"></i>Subtasks & Checklist
                    </h5>
                    <span class="badge bg-primary rounded-pill px-3 py-1" id="subtaskCounter">
                        {{ $task->subtasks->where('is_completed', true)->count() }} / {{ $task->subtasks->count() }} Completed
                    </span>
                </div>

                <!-- Subtask Progress Bar -->
                <div class="progress mb-4" style="height: 8px; border-radius: 9999px;">
                    <div class="progress-bar bg-primary progress-bar-striped" id="subtaskProgressBar" 
                         role="progressbar" 
                         style="width: {{ $task->subtask_progress }}%;" 
                         aria-valuenow="{{ $task->subtask_progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Subtasks Items List -->
                <div class="list-group mb-3" id="subtasksList">
                    @forelse($task->subtasks as $subtask)
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3 card-custom border mb-2 rounded-3">
                            <div class="form-check d-flex align-items-center mb-0">
                                <input class="form-check-input me-2 subtask-toggle" type="checkbox" 
                                       data-subtask-id="{{ $subtask->id }}" 
                                       id="subtaskCheck{{ $subtask->id }}"
                                       {{ $subtask->is_completed ? 'checked' : '' }}
                                       style="width: 1.2rem; height: 1.2rem; cursor: pointer;">
                                <label class="form-check-label {{ $subtask->is_completed ? 'text-decoration-line-through text-muted' : 'fw-medium' }}" 
                                       for="subtaskCheck{{ $subtask->id }}" 
                                       id="subtaskLabel{{ $subtask->id }}"
                                       style="cursor: pointer;">
                                    {{ $subtask->title }}
                                </label>
                            </div>
                            <form action="{{ route('subtasks.destroy', $subtask) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger opacity-75 hover-opacity-100 p-0" title="Delete subtask">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted small" id="noSubtasksText">
                            <i class="fa-regular fa-square-check me-1"></i> No checklist items yet. Add subtasks below to track detailed progress!
                        </div>
                    @endforelse
                </div>

                <!-- Add Subtask Inline Form -->
                <form action="{{ route('subtasks.store', $task) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="title" class="form-control" placeholder="+ Add a new subtask / checklist item..." required>
                    <button type="submit" class="btn btn-outline-primary fw-semibold px-4">Add</button>
                </form>
            </div>

            <!-- COMMENTS & DISCUSSION THREAD -->
            <div class="p-4 p-md-5 border-bottom">
                <h5 class="fw-bold mb-3">
                    <i class="fa-regular fa-comments text-primary me-2"></i>Task Discussion & Activity Notes
                </h5>

                <!-- Comments List -->
                <div class="mb-4">
                    @forelse($task->comments as $comment)
                        <div class="d-flex mb-3 align-items-start">
                            @php
                                $w = explode(' ', trim($comment->user_name));
                                $cInit = strtoupper(substr($w[0] ?? 'U', 0, 1) . substr($w[1] ?? '', 0, 1));
                            @endphp
                            <div class="avatar-circle mt-1" style="width:34px;height:34px;font-size:0.75rem;">{{ $cInit ?: 'U' }}</div>
                            <div class="p-3 rounded-3 card-custom border flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-6">{{ $comment->user_name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-body" style="line-height: 1.5;">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted small">
                            <i class="fa-regular fa-comment-dots me-1"></i> No comments yet. Post the first update or question below.
                        </div>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="card-custom p-3 border rounded-3">
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-md-5">
                            <input type="text" name="user_name" class="form-control form-control-sm" placeholder="Your Name (e.g. Emon Ahmed)" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <textarea name="comment" rows="2" class="form-control" placeholder="Write a note, update, or feedback on this task..." required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold shadow-sm">
                            <i class="fa-solid fa-paper-plane me-1"></i> Post Comment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card Actions -->
            <div class="card-footer bg-transparent p-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Tasks
                </a>

                <div class="d-flex gap-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary px-3 py-2 fw-semibold shadow-sm">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Task
                    </a>
                    <button type="button" class="btn btn-outline-danger px-3 py-2 fw-semibold" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal">
                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-custom border-0 shadow">
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
                <p class="text-muted mb-0">"{{ $task->title }}"</p>
                <div class="alert alert-warning small text-start mt-3 mb-0">
                    <i class="fa-solid fa-circle-info me-1"></i> This action is permanent and cannot be undone.
                </div>
            </div>
            <div class="modal-footer border-0 bg-transparent p-3 justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
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

<!-- AJAX Subtask Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        document.querySelectorAll('.subtask-toggle').forEach(checkbox => {
            checkbox.addEventListener('change', async function() {
                const subtaskId = this.dataset.subtaskId;
                const isChecked = this.checked;
                const label = document.getElementById('subtaskLabel' + subtaskId);

                try {
                    const response = await fetch(`/subtasks/${subtaskId}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        if (data.is_completed) {
                            label.classList.add('text-decoration-line-through', 'text-muted');
                            label.classList.remove('fw-medium');
                        } else {
                            label.classList.remove('text-decoration-line-through', 'text-muted');
                            label.classList.add('fw-medium');
                        }

                        // Update progress bar
                        const progressBar = document.getElementById('subtaskProgressBar');
                        if (progressBar) {
                            progressBar.style.width = data.progress + '%';
                            progressBar.setAttribute('aria-valuenow', data.progress);
                        }

                        if (data.progress === 100) {
                            triggerConfetti();
                        }
                    }
                } catch (e) {
                    console.error('Subtask toggle failed', e);
                }
            });
        });
    });
</script>
@endsection
