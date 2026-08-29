@extends('layouts.app')

@section('title', 'Task Details: ' . $task->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Task #{{ $task->id }}</li>
            </ol>
        </nav>

        <div class="card card-custom overflow-hidden shadow-sm mb-4">
            <!-- Header with Badges -->
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
                        Task ID: <strong>#{{ $task->id }}</strong>
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
@endsection
