@extends('layouts.app')

@section('title', 'Create New Task - ' . config('office.app_name', 'Office Task Tracker'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Task</li>
            </ol>
        </nav>

        <div class="card-custom p-4 p-md-5 shadow-lg">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div class="avatar-circle me-3" style="width: 50px; height: 50px; font-size: 1.3rem;">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 font-heading">Create New Task</h3>
                    <p class="text-muted small mb-0">Fill in task parameters, tags, priority, and time budget.</p>
                </div>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <!-- Task Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">
                        Task Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           placeholder="e.g. Implement Multi-Theme SaaS Engine"
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
                              placeholder="Provide detailed instructions, acceptance criteria, or relevant links..."
                              style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">{{ old('description') }}</textarea>
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
                                   value="{{ old('assigned_to', 'Emon Ahmed') }}" 
                                   placeholder="e.g. Emon Ahmed"
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
                            <option value="Frontend" {{ old('category') == 'Frontend' ? 'selected' : '' }}>Frontend</option>
                            <option value="Backend" {{ old('category') == 'Backend' ? 'selected' : '' }}>Backend</option>
                            <option value="DevOps" {{ old('category') == 'DevOps' ? 'selected' : '' }}>DevOps</option>
                            <option value="Security" {{ old('category') == 'Security' ? 'selected' : '' }}>Security</option>
                            <option value="UI/UX" {{ old('category') == 'UI/UX' ? 'selected' : '' }}>UI/UX Design</option>
                            <option value="QA Testing" {{ old('category') == 'QA Testing' ? 'selected' : '' }}>QA Testing</option>
                            <option value="Finance" {{ old('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Marketing" {{ old('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Management" {{ old('category') == 'Management' ? 'selected' : '' }}>Management</option>
                            <option value="General" {{ old('category', 'General') == 'General' ? 'selected' : '' }}>General</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tags & Pinned Option -->
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label for="tags" class="form-label fw-bold">
                            Tags (Comma separated)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted" style="border-color: var(--border-color);"><i class="fa-solid fa-tags"></i></span>
                            <input type="text" 
                                   class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" 
                                   name="tags" 
                                   value="{{ old('tags') }}" 
                                   placeholder="e.g. Frontend, Bug, HighPriority"
                                   style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 0 12px 12px 0;">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check p-3 rounded-3 w-100" style="background: var(--surface-hover); border: 1px solid var(--border-color);">
                            <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="is_pinned" {{ old('is_pinned') ? 'checked' : '' }} style="cursor: pointer;">
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
                            <input type="radio" class="btn-check" name="priority" id="p_urgent" value="Urgent" {{ old('priority') == 'Urgent' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger w-100 py-2 fw-bold" for="p_urgent" style="border-radius: 12px;">
                                <i class="fa-solid fa-fire-flame-curved me-1"></i> Urgent 🔥
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_high" value="High" {{ old('priority') == 'High' ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning w-100 py-2 fw-bold" for="p_high" style="border-radius: 12px;">
                                <i class="fa-solid fa-angles-up me-1"></i> High
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_medium" value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'checked' : '' }}>
                            <label class="btn btn-outline-info w-100 py-2 fw-bold" for="p_medium" style="border-radius: 12px;">
                                <i class="fa-solid fa-equals me-1"></i> Medium
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="radio" class="btn-check" name="priority" id="p_low" value="Low" {{ old('priority') == 'Low' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success w-100 py-2 fw-bold" for="p_low" style="border-radius: 12px;">
                                <i class="fa-solid fa-angles-down me-1"></i> Low
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <!-- Status -->
                    <div class="col-md-4">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                            <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-4">
                        <label for="due_date" class="form-label fw-bold">Due Date <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" 
                               name="due_date" 
                               value="{{ old('due_date', date('Y-m-d', strtotime('+3 days'))) }}" 
                               required
                               style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    </div>

                    <!-- Estimated Hours -->
                    <div class="col-md-4">
                        <label for="estimated_hours" class="form-label fw-bold">Estimated Hours</label>
                        <input type="number" 
                               class="form-control @error('estimated_hours') is-invalid @enderror" 
                               id="estimated_hours" 
                               name="estimated_hours" 
                               value="{{ old('estimated_hours', 8) }}" 
                               min="1" 
                               max="1000"
                               style="background: var(--surface); color: var(--text-main); border-color: var(--border-color); border-radius: 12px;">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top border-secondary border-opacity-25">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold rounded-pill">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow" style="background: linear-gradient(135deg, var(--primary), var(--accent)); border: none;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
