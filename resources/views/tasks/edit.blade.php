<x-layouts::app title="Edit Task - {{ $task->title }}">
    <flux:main container>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-mono px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-500">TASK-{{ $task->id }}</span>
                    <flux:heading size="xl" level="1" class="font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Edit Task</flux:heading>
                </div>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400">
                    Modify task details, priority, due date or transition workflow status for: <span class="font-medium text-zinc-800 dark:text-zinc-200">"{{ $task->title }}"</span>
                </flux:subheading>
            </div>
            
            <div class="flex items-center gap-2">
                <flux:button href="{{ route('tasks.show', $task) }}" variant="ghost" icon="eye">
                    View Details
                </flux:button>
                <flux:button href="{{ route('tasks.index') }}" variant="ghost" icon="arrow-left">
                    Back to Tasks
                </flux:button>
            </div>
        </div>

        <flux:card class="shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 max-w-4xl p-6 sm:p-8">
            <form method="POST" action="{{ route('tasks.update', $task) }}" novalidate>
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- 1. Task Title (Required) -->
                    <div>
                        <flux:input 
                            label="Task Title *" 
                            name="title" 
                            value="{{ old('title', $task->title) }}" 
                            placeholder="e.g. Prepare Q3 Financial Summary" 
                            icon="document-text"
                            required 
                        />
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- 2. Description (Optional with Character Counter) -->
                    <div x-data="{ count: {{ strlen(old('description', $task->description ?? '')) }} }">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                Description <span class="text-xs text-zinc-400 font-normal">(Optional)</span>
                            </label>
                            <span class="text-xs text-zinc-400 font-mono" x-text="count + ' / 2000 characters'"></span>
                        </div>
                        <flux:textarea 
                            name="description" 
                            rows="4" 
                            maxlength="2000"
                            placeholder="Add task context, deliverables, guidelines or notes..." 
                            x-on:input="count = $el.value.length"
                        >{{ old('description', $task->description) }}</flux:textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 3. Desktop Two-Column Layout (Assigned To & Due Date) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Assigned To (Required) -->
                        <div>
                            <flux:input 
                                label="Assigned To *" 
                                name="assigned_to" 
                                value="{{ old('assigned_to', $task->assigned_to) }}" 
                                placeholder="e.g. John Doe, Sarah Jenkins..." 
                                icon="user" 
                                required 
                            />
                            @error('assigned_to')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Due Date (Required) -->
                        <div>
                            <flux:input 
                                type="date" 
                                label="Due Date *" 
                                name="due_date" 
                                value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}" 
                                icon="calendar" 
                                required 
                            />
                            @error('due_date')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 4. Desktop Two-Column Layout (Priority & Status) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Priority (Required) -->
                        <div>
                            <flux:select label="Priority *" name="priority">
                                <option value="Low" {{ old('priority', $task->priority) == 'Low' ? 'selected' : '' }}>Low Priority</option>
                                <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                                <option value="High" {{ old('priority', $task->priority) == 'High' ? 'selected' : '' }}>High Priority</option>
                            </flux:select>
                            @error('priority')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status (Required) -->
                        <div>
                            <flux:select label="Status *" name="status">
                                <option value="Pending" {{ old('status', $task->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </flux:select>
                            @error('status')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-zinc-100 dark:border-zinc-800 pt-6">
                    <!-- Delete Modal Trigger -->
                    <flux:modal.trigger name="delete-task-{{ $task->id }}">
                        <flux:button variant="danger" icon="trash" size="sm">
                            Delete Task
                        </flux:button>
                    </flux:modal.trigger>

                    <div class="flex items-center justify-end gap-3">
                        <flux:button href="{{ route('tasks.index') }}" variant="ghost">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="primary" icon="check" class="shadow-sm font-semibold">
                            Save Changes
                        </flux:button>
                    </div>
                </div>
            </form>
        </flux:card>

        <!-- Delete Confirmation Modal -->
        <flux:modal name="delete-task-{{ $task->id }}" class="max-w-md">
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400 rounded-full">
                        <flux:icon name="exclamation-triangle" class="size-6" />
                    </div>
                    <div>
                        <flux:heading size="lg">Delete Task</flux:heading>
                        <flux:subheading>Are you sure you want to delete this task?</flux:subheading>
                    </div>
                </div>

                <p class="text-sm text-zinc-600 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-800/60 p-3.5 rounded-xl border border-zinc-200/60 dark:border-zinc-700/60">
                    <strong>"{{ $task->title }}"</strong> will be permanently deleted. This action cannot be undone.
                </p>

                <div class="flex justify-end gap-3">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <flux:button type="submit" variant="danger" icon="trash">
                            Yes, Delete Task
                        </flux:button>
                    </form>
                </div>
            </div>
        </flux:modal>
    </flux:main>
</x-layouts::app>
