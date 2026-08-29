<x-layouts::app title="Task Management">
    <flux:main container>
        <!-- Top Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <flux:heading size="xl" level="1" class="font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Task Management</flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage, track, and collaborate on your office tasks in real time.
                </flux:subheading>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <flux:button href="{{ route('tasks.kanban') }}" icon="view-columns" variant="subtle" class="shadow-xs">
                    Kanban Board
                </flux:button>
                @if(config('tracker.enable_task_export'))
                    <flux:button href="{{ route('tasks.export') }}" icon="arrow-down-tray" variant="subtle" class="shadow-xs hover:shadow-sm transition-all">
                        Export Tasks
                    </flux:button>
                @endif
                <flux:button href="{{ route('tasks.create') }}" icon="plus" variant="primary" class="shadow-sm hover:shadow-md transition-all">
                    Add New Task
                </flux:button>
            </div>
        </div>

        <!-- Flash Notifications -->
        @if(session('success'))
            <flux:toast variant="success" heading="Success" text="{{ session('success') }}" class="mb-6" />
        @endif
        @if(session('error'))
            <flux:toast variant="danger" heading="Error" text="{{ session('error') }}" class="mb-6" />
        @endif

        <!-- Quick Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-4 text-xs font-semibold">
            <a href="{{ route('tasks.index') }}" class="px-3.5 py-1.5 rounded-full transition-colors {{ !request()->has('filter') && !request()->has('priority') ? 'bg-indigo-600 text-white shadow-xs' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200' }}">
                All Tasks
            </a>
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['filter' => 'overdue'])) }}" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full transition-colors {{ request('filter') === 'overdue' ? 'bg-rose-600 text-white shadow-xs' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300 hover:bg-rose-100' }}">
                <flux:icon name="exclamation-triangle" class="size-3" />
                Overdue Tasks
            </a>
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['filter' => 'due_soon'])) }}" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full transition-colors {{ request('filter') === 'due_soon' ? 'bg-amber-600 text-white shadow-xs' : 'bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 hover:bg-amber-100' }}">
                <flux:icon name="fire" class="size-3" />
                Due Soon (3 Days)
            </a>
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['filter' => 'high_priority'])) }}" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full transition-colors {{ request('filter') === 'high_priority' ? 'bg-violet-600 text-white shadow-xs' : 'bg-violet-50 text-violet-700 dark:bg-violet-950/50 dark:text-violet-300 hover:bg-violet-100' }}">
                <flux:icon name="bolt" class="size-3" />
                High Priority
            </a>
        </div>

        <!-- Advanced Search & Filter Bar -->
        <flux:card class="mb-6 shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-700/80 bg-white dark:bg-zinc-900 p-5">
            <form action="{{ route('tasks.index') }}" method="GET" class="space-y-4">
                @if(request()->filled('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                    <!-- Search Input Section -->
                    <div class="lg:col-span-5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1.5">
                            Search Tasks
                        </label>
                        <flux:input 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search by task title or assigned person..." 
                            icon="magnifying-glass"
                            clearable
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1.5">
                            Status
                        </label>
                        <flux:select name="status">
                            <option value="All">All Statuses</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </flux:select>
                    </div>

                    <!-- Priority Filter -->
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1.5">
                            Priority
                        </label>
                        <flux:select name="priority">
                            <option value="All">All Priorities</option>
                            <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low Priority</option>
                            <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                            <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High Priority</option>
                        </flux:select>
                    </div>

                    <!-- Sort By -->
                    <div class="lg:col-span-3">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1.5">
                            Sort Order
                        </label>
                        <flux:select name="sort">
                            <option value="due_date_asc" {{ request('sort', 'due_date_asc') == 'due_date_asc' ? 'selected' : '' }}>Due Date (Earliest)</option>
                            <option value="due_date_desc" {{ request('sort') == 'due_date_desc' ? 'selected' : '' }}>Due Date (Latest)</option>
                            <option value="priority_high" {{ request('sort') == 'priority_high' ? 'selected' : '' }}>Priority (High First)</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A to Z)</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Recently Added</option>
                        </flux:select>
                    </div>
                </div>

                <!-- Action Buttons Row -->
                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center gap-2">
                        <flux:button type="submit" variant="primary" icon="funnel" class="shadow-xs">
                            Apply Filters
                        </flux:button>
                        @if(request()->filled('search') || (request()->filled('status') && request('status') !== 'All') || (request()->filled('priority') && request('priority') !== 'All') || request()->filled('filter'))
                            <flux:button href="{{ route('tasks.index') }}" variant="ghost" icon="arrow-path">
                                Reset Filters
                            </flux:button>
                        @endif
                    </div>

                    <div class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">
                        Showing {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
                    </div>
                </div>

                <!-- Active Search & Filter Indicator Bar -->
                @if(request()->filled('search') || (request()->filled('status') && request('status') !== 'All') || (request()->filled('priority') && request('priority') !== 'All') || request()->filled('filter'))
                    <div class="pt-3.5 mt-2 border-t border-zinc-100 dark:border-zinc-800 flex flex-wrap items-center justify-between gap-3 text-sm">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Active Filters:</span>
                            
                            @if(request()->filled('search'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-800/60">
                                    <flux:icon name="magnifying-glass" class="size-3 text-indigo-500" />
                                    Showing results for: <strong class="font-semibold">"{{ request('search') }}"</strong>
                                    <a href="{{ route('tasks.index', request()->except('search')) }}" class="hover:text-indigo-900 dark:hover:text-indigo-100 ml-1 p-0.5 rounded-full hover:bg-indigo-200/60" title="Remove search term">&times;</a>
                                </span>
                            @endif

                            @if(request()->filled('status') && request('status') !== 'All')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60">
                                    Status: <strong>{{ request('status') }}</strong>
                                    <a href="{{ route('tasks.index', request()->except('status')) }}" class="hover:text-amber-900 dark:hover:text-amber-100 ml-1 p-0.5 rounded-full hover:bg-amber-200/60" title="Remove status filter">&times;</a>
                                </span>
                            @endif

                            @if(request()->filled('priority') && request('priority') !== 'All')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                    Priority: <strong>{{ request('priority') }}</strong>
                                    <a href="{{ route('tasks.index', request()->except('priority')) }}" class="hover:text-zinc-900 dark:hover:text-zinc-100 ml-1 p-0.5 rounded-full hover:bg-zinc-200" title="Remove priority filter">&times;</a>
                                </span>
                            @endif

                            @if(request()->filled('filter'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    Tab: <strong>{{ ucfirst(str_replace('_', ' ', request('filter'))) }}</strong>
                                    <a href="{{ route('tasks.index', request()->except('filter')) }}" class="hover:text-indigo-900 ml-1 p-0.5 rounded-full hover:bg-indigo-200" title="Remove tab filter">&times;</a>
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $tasks->total() }} {{ \Illuminate\Support\Str::plural('task', $tasks->total()) }} found
                            </span>
                            @if(request()->filled('search'))
                                <flux:button href="{{ route('tasks.index', request()->except('search')) }}" size="sm" variant="ghost" icon="x-mark" class="text-xs">
                                    Clear Search
                                </flux:button>
                            @else
                                <flux:button href="{{ route('tasks.index') }}" size="sm" variant="ghost" icon="x-mark" class="text-xs">
                                    Clear Filters
                                </flux:button>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
        </flux:card>

        <!-- Tasks Data Table Card -->
        <flux:card class="p-0! shadow-sm rounded-2xl overflow-hidden border-zinc-200/80 dark:border-zinc-700/80 bg-white dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <flux:table class="min-w-full">
                    <flux:table.columns class="sticky top-0 bg-zinc-50/90 dark:bg-zinc-800/90 backdrop-blur-sm z-10">
                        <flux:table.column class="w-2/5">Task</flux:table.column>
                        <flux:table.column>Assigned To</flux:table.column>
                        <flux:table.column>Priority</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Due Date</flux:table.column>
                        <flux:table.column>Created Date</flux:table.column>
                        <flux:table.column class="text-right">Actions</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse($tasks as $task)
                            <flux:table.row class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors group">
                                <!-- 1. Task (Title + Description Preview + Overdue Indicator) -->
                                <flux:table.cell>
                                    <div class="flex flex-col gap-1 py-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                {{ $task->title }}
                                            </a>
                                            @if($task->is_overdue)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800 animate-pulse">
                                                    <flux:icon name="exclamation-triangle" class="size-3" />
                                                    OVERDUE
                                                </span>
                                            @endif
                                        </div>
                                        @if($task->description)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1 max-w-md">
                                                {{ \Illuminate\Support\Str::limit($task->description, 75) }}
                                            </p>
                                        @endif
                                    </div>
                                </flux:table.cell>

                                <!-- 2. Assigned To -->
                                <flux:table.cell>
                                    <div class="flex items-center gap-2">
                                        <div class="size-7 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 flex items-center justify-center font-medium text-xs">
                                            {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                            {{ $task->assigned_to }}
                                        </span>
                                    </div>
                                </flux:table.cell>

                                <!-- 3. Priority -->
                                <flux:table.cell>
                                    @if($task->priority === 'High')
                                        <flux:badge size="sm" color="red" icon="fire">{{ $task->priority }}</flux:badge>
                                    @elseif($task->priority === 'Medium')
                                        <flux:badge size="sm" color="indigo">{{ $task->priority }}</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="zinc">{{ $task->priority }}</flux:badge>
                                    @endif
                                </flux:table.cell>

                                <!-- 4. Status -->
                                <flux:table.cell>
                                    @if($task->status === 'Completed')
                                        <flux:badge size="sm" color="emerald" icon="check">{{ $task->status }}</flux:badge>
                                    @elseif($task->status === 'In Progress')
                                        <flux:badge size="sm" color="blue" icon="arrow-path">{{ $task->status }}</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="amber" icon="clock">{{ $task->status }}</flux:badge>
                                    @endif
                                </flux:table.cell>

                                <!-- 5. Due Date -->
                                <flux:table.cell>
                                    <span class="text-xs font-medium {{ $task->is_overdue ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-zinc-600 dark:text-zinc-400' }} flex items-center gap-1.5 whitespace-nowrap">
                                        <flux:icon name="calendar" class="size-3.5 opacity-70" />
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'No due date' }}
                                    </span>
                                </flux:table.cell>

                                <!-- 6. Created Date -->
                                <flux:table.cell>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                        {{ $task->created_at->format('d M Y') }}
                                    </span>
                                </flux:table.cell>

                                <!-- 7. Actions -->
                                <flux:table.cell class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <flux:button href="{{ route('tasks.show', $task) }}" variant="ghost" size="sm" icon="eye" class="text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200" title="View Details" />
                                        <flux:button href="{{ route('tasks.edit', $task) }}" variant="ghost" size="sm" icon="pencil-square" class="text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400" title="Edit Task" />
                                        
                                        <!-- Delete Modal Trigger -->
                                        <flux:modal.trigger name="delete-task-{{ $task->id }}">
                                            <flux:button variant="ghost" size="sm" icon="trash" class="text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400" title="Delete Task" />
                                        </flux:modal.trigger>

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

                                                <p class="text-sm text-zinc-600 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-800/60 p-3 rounded-lg border border-zinc-200/60 dark:border-zinc-700/60">
                                                    <strong>"{{ $task->title }}"</strong> will be permanently removed from the system. This action cannot be undone.
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
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="7">
                                    <div class="text-center py-16">
                                        <div class="size-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto text-zinc-400 dark:text-zinc-500 mb-4">
                                            <flux:icon name="magnifying-glass" class="size-8" />
                                        </div>
                                        <flux:heading size="lg" class="font-semibold text-zinc-900 dark:text-zinc-100">No tasks found</flux:heading>
                                        <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                                            @if(request()->filled('search') || (request()->filled('status') && request('status') !== 'All') || (request()->filled('priority') && request('priority') !== 'All') || request()->filled('filter'))
                                                Try changing your search or filters.
                                            @else
                                                Your workspace is clean! Get started by adding a new task to track.
                                            @endif
                                        </flux:text>
                                        <div class="mt-6 flex justify-center gap-3">
                                            @if(request()->filled('search'))
                                                <flux:button href="{{ route('tasks.index', request()->except('search')) }}" variant="ghost" icon="x-mark">Clear Search</flux:button>
                                            @elseif(request()->filled('status') || request()->filled('priority') || request()->filled('filter'))
                                                <flux:button href="{{ route('tasks.index') }}" variant="ghost" icon="x-mark">Clear Filters</flux:button>
                                            @else
                                                <flux:button href="{{ route('tasks.create') }}" variant="primary" icon="plus">Create First Task</flux:button>
                                            @endif
                                        </div>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>
        </flux:card>

        <!-- Pagination -->
        <div class="mt-6 mb-12">
            {{ $tasks->links() }}
        </div>
    </flux:main>
</x-layouts::app>
