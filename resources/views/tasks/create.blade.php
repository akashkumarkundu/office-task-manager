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

        <div class="card card-custom p-4 p-md-5 shadow-sm">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="avatar-circle me-3" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">Create New Task</h3>
                    <p class="text-muted small mb-0">Fill in the assignment details to assign and track a new task.</p>
                </div>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <!-- Task Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">
                        Task Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           placeholder="e.g. Redesign Company Landing Page"
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">
                        Description / Notes
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="4" 
                              placeholder="Provide detailed instructions, acceptance criteria, or relevant links...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <!-- Assigned To -->
                    <div class="col-md-6">
                        <label for="assigned_to" class="form-label fw-semibold">
                            Assigned To <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted"><i class="fa-solid fa-user"></i></span>
                            <input type="text" 
                                   class="form-control @error('assigned_to') is-invalid @enderror" 
                                   id="assigned_to" 
                                   name="assigned_to" 
                                   value="{{ old('assigned_to') }}" 
                                   placeholder="e.g. Emon Ahmed"
                                   required>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-6">
                        <label for="due_date" class="form-label fw-semibold">
                            Due Date <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" 
                                   class="form-control @error('due_date') is-invalid @enderror" 
                                   id="due_date" 
                                   name="due_date" 
                                   value="{{ old('due_date', date('Y-m-d', strtotime('+3 days'))) }}"
                                   required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <!-- Priority -->
                    <div class="col-md-6">
                        <label for="priority" class="form-label fw-semibold">
                            Priority <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low Priority</option>
                            <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High Priority</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                        <i class="fa-solid fa-check me-1"></i> Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
