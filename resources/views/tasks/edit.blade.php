@extends('layouts.app')

@section('title', 'Edit Task: ' . $task->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit #{{ $task->id }}</li>
            </ol>
        </nav>

        <div class="card-custom p-4 p-md-5 shadow-lg">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div class="avatar-circle me-3" style="width: 50px; height: 50px; font-size: 1.3rem;">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 font-heading">Edit Task #{{ $task->id }}</h3>
                    <p class="text-muted small mb-0">Modify task status, priority, hours, or tags.</p>
                </div>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Task Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">
                        Task Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $task->title) }}" 
                           required
                           style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">
                        Description / Deliverables
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3" 
                              style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <!-- Assigned To -->
                    <div class="col-md-6">
                        <label for="assigned_to" class="form-label fw-bold">
                            Assigned To <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted" style="border-color: var(--border-color);"><i class="fa-solid fa-user"></i></span>
                            <input type="text" 
                                   class="form-control @error('assigned_to') is-invalid @enderror" 
                                   id="assigned_to" 
                                   name="assigned_to" 
                                   value="{{ old('assigned_to', $task->assigned_to) }}" 
                                   required
                                   style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 0 12px 12px 0;">
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category" class="form-label fw-bold">
                            Category / Department
                        </label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                            <option value="Frontend" {{ old('category', $task->category) == 'Frontend' ? 'selected' : '' }}>Frontend</option>
                            <option value="Backend" {{ old('category', $task->category) == 'Backend' ? 'selected' : '' }}>Backend</option>
                            <option value="DevOps" {{ old('category', $task->category) == 'DevOps' ? 'selected' : '' }}>DevOps</option>
                            <option value="Security" {{ old('category', $task->category) == 'Security' ? 'selected' : '' }}>Security</option>
                            <option value="UI/UX" {{ old('category', $task->category) == 'UI/UX' ? 'selected' : '' }}>UI/UX Design</option>
                            <option value="QA Testing" {{ old('category', $task->category) == 'QA Testing' ? 'selected' : '' }}>QA Testing</option>
                            <option value="Finance" {{ old('category', $task->category) == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Marketing" {{ old('category', $task->category) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Management" {{ old('category', $task->category) == 'Management' ? 'selected' : '' }}>Management</option>
                            <option value="General" {{ old('category', $task->category ?? 'General') == 'General' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>
                </div>

                <!-- Tags & Pinned -->
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label for="tags" class="form-label fw-bold">
                            Tags (Comma separated)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted" style="border-color: var(--border-color);"><i class="fa-solid fa-tags"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="tags" 
                                   name="tags" 
                                   value="{{ old('tags', $task->tags) }}" 
                                   placeholder="e.g. Frontend, Bug, HighPriority"
                                   style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 0 12px 12px 0;">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check p-3 rounded-3 w-100" style="background: var(--surface-hover); border: 1px solid var(--border-color);">
                            <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="is_pinned" {{ old('is_pinned', $task->is_pinned) ? 'checked' : '' }} style="cursor: pointer;">
                            <label class="form-check-label fw-bold small ms-1 text-warning" for="is_pinned" style="cursor: pointer;">
                                <i class="fa-solid fa-thumbtack me-1"></i> Pin Task to Top
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Priority Selection Pills -->
                <div class="mb-3">
                    <label class="form-label fw-bold d-block">
                        Priority Level <span class="text-danger">*</span>
                    </label>
                    <div class="row g-2">
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_urgent" value="Urgent" {{ old('priority', $task->priority) == 'Urgent' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger w-100 py-2 fw-bold" for="p_urgent" style="border-radius: 12px;">
                                <i class="fa-solid fa-fire-flame-curved me-1"></i> Urgent 🔥
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_high" value="High" {{ old('priority', $task->priority) == 'High' ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning w-100 py-2 fw-bold" for="p_high" style="border-radius: 12px;">
                                <i class="fa-solid fa-angles-up me-1"></i> High
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_medium" value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'checked' : '' }}>
                            <label class="btn btn-outline-info w-100 py-2 fw-bold" for="p_medium" style="border-radius: 12px;">
                                <i class="fa-solid fa-equals me-1"></i> Medium
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_low" value="Low" {{ old('priority', $task->priority) == 'Low' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="p_low" style="border-radius: 12px;">
                                <i class="fa-solid fa-angles-down me-1"></i> Low
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <!-- Status -->
                    <div class="col-md-3">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                            <option value="Pending" {{ old('status', $task->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-3">
                        <label for="due_date" class="form-label fw-bold">Due Date <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" 
                               name="due_date" 
                               value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" 
                               required
                               style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    </div>

                    <!-- Estimated Hours -->
                    <div class="col-md-3">
                        <label for="estimated_hours" class="form-label fw-bold">Est. Hours</label>
                        <input type="number" 
                               class="form-control @error('estimated_hours') is-invalid @enderror" 
                               id="estimated_hours" 
                               name="estimated_hours" 
                               value="{{ old('estimated_hours', $task->estimated_hours ?? 8) }}" 
                               min="1" 
                               max="1000"
                               style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    </div>

                    <!-- Spent Hours -->
                    <div class="col-md-3">
                        <label for="spent_hours" class="form-label fw-bold">Spent Hours</label>
                        <input type="number" 
                               step="0.1"
                               class="form-control @error('spent_hours') is-invalid @enderror" 
                               id="spent_hours" 
                               name="spent_hours" 
                               value="{{ old('spent_hours', $task->spent_hours ?? 0) }}" 
                               min="0" 
                               max="9999"
                               style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top border-secondary border-opacity-25">
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold rounded-pill">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow" style="background: linear-gradient(135deg, var(--primary), var(--accent)); border: none;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
