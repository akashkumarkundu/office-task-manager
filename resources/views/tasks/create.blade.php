<x-layouts::app title="Add New Task">
    <flux:main container>
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <flux:heading size="xl" level="1" class="font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Add New Task</flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    Assign a new deliverable to your workspace with clear priority, deadline, and instructions.
                </flux:subheading>
            </div>
            <flux:button href="{{ route('tasks.index') }}" variant="ghost" icon="arrow-left">
                Back to Tasks
            </flux:button>
        </div>

        <flux:card class="shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 max-w-4xl p-6 sm:p-8">
            <form method="POST" action="{{ route('tasks.store') }}" novalidate>
                @csrf
                
                <div class="space-y-6">
                    <!-- 1. Task Title (Required) -->
                    <div>
                        <flux:input 
                            label="Task Title *" 
                            name="title" 
                            value="{{ old('title') }}" 
                            placeholder="e.g. Prepare Q3 Financial Executive Report" 
                            icon="document-text"
                            required 
                            autofocus 
                        />
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- 2. Description (Optional with Character Counter) -->
                    <div x-data="{ count: {{ strlen(old('description', '')) }} }">
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
                            placeholder="Add task context, key deliverables, acceptance criteria, or team notes..." 
                            x-on:input="count = $el.value.length"
                        >{{ old('description') }}</flux:textarea>
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
                                value="{{ old('assigned_to') }}" 
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
                                value="{{ old('due_date') }}" 
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
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low Priority</option>
                                <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High Priority</option>
                            </flux:select>
                            @error('priority')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status (Required) -->
                        <div>
                            <flux:select label="Status *" name="status">
                                <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </flux:select>
                            @error('status')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="mt-8 flex items-center justify-end gap-3 border-t border-zinc-100 dark:border-zinc-800 pt-6">
                    <flux:button href="{{ route('tasks.index') }}" variant="ghost">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary" icon="check" class="shadow-sm font-semibold">
                        Save Task
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </flux:main>
</x-layouts::app>
