<x-layouts::app title="Kanban Board">
    <flux:main container>
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400">
                        <flux:icon name="view-columns" class="size-5" />
                    </span>
                    <flux:heading size="xl" level="1" class="font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Interactive Kanban Board</flux:heading>
                </div>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    Drag and drop cards across sprint columns or use quick transition buttons.
                </flux:subheading>
            </div>

            <div class="flex items-center gap-3">
                <flux:button href="{{ route('tasks.index') }}" variant="ghost" icon="table-cells">
                    Table View
                </flux:button>
                <flux:button href="{{ route('tasks.create') }}" variant="primary" icon="plus" class="shadow-sm">
                    Add New Task
                </flux:button>
            </div>
        </div>

        <!-- Alpine Drag and Drop Kanban Board -->
        <div
            x-data="{
                draggedId: null,
                isDragging: false,
                targetColumn: null,
                pendingCount: {{ $pendingTasks->count() }},
                inProgressCount: {{ $inProgressTasks->count() }},
                completedCount: {{ $completedTasks->count() }},
                toastMsg: '',
                showToast: false,

                startDrag(id, event) {
                    this.draggedId = id;
                    this.isDragging = true;
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', id);
                },
                endDrag() {
                    this.isDragging = false;
                    this.targetColumn = null;
                },
                onDragOver(column, event) {
                    event.preventDefault();
                    this.targetColumn = column;
                },
                onDragLeave(column) {
                    if (this.targetColumn === column) {
                        this.targetColumn = null;
                    }
                },
                async dropTask(newStatus, event) {
                    event.preventDefault();
                    const taskId = this.draggedId || event.dataTransfer.getData('text/plain');
                    this.targetColumn = null;
                    this.isDragging = false;

                    if (!taskId) return;

                    try {
                        const csrfToken = document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}';
                        const res = await fetch(`/tasks/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ status: newStatus })
                        });

                        if (res.ok) {
                            window.location.reload();
                        } else {
                            window.location.reload();
                        }
                    } catch (e) {
                        window.location.reload();
                    }
                }
            }"
            class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start pb-12"
        >
            <!-- 1. PENDING COLUMN (Amber) -->
            <div
                @dragover="onDragOver('Pending', $event)"
                @dragleave="onDragLeave('Pending')"
                @drop="dropTask('Pending', $event)"
                :class="{ 'ring-2 ring-amber-400 bg-amber-50/50 dark:bg-amber-950/20': targetColumn === 'Pending' }"
                class="rounded-3xl bg-zinc-100/70 dark:bg-zinc-900/60 border border-amber-200/60 dark:border-amber-900/40 p-4 sm:p-5 flex flex-col shadow-xs transition-all duration-200 min-h-[500px]"
            >
                <!-- Column Header -->
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-amber-200/50 dark:border-amber-900/40">
                    <div class="flex items-center gap-2.5">
                        <div class="size-3.5 rounded-full bg-amber-500 ring-4 ring-amber-100 dark:ring-amber-950/60"></div>
                        <h2 class="font-bold text-sm text-zinc-900 dark:text-zinc-100 tracking-wide uppercase">Pending</h2>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                        {{ $pendingTasks->count() }}
                    </span>
                </div>

                <!-- Cards List -->
                <div class="space-y-3.5 flex-1">
                    @forelse($pendingTasks as $task)
                        <div
                            draggable="true"
                            @dragstart="startDrag({{ $task->id }}, $event)"
                            @dragend="endDrag()"
                            class="cursor-grab active:cursor-grabbing transform transition-all duration-150"
                        >
                            <flux:card class="p-4! shadow-xs hover:shadow-md transition-all duration-200 rounded-2xl bg-white dark:bg-zinc-800 border-zinc-200/80 dark:border-zinc-700/80 group">
                                <!-- Overdue, Category and Priority Row -->
                                <div class="flex items-center justify-between gap-1.5 mb-2.5 flex-wrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @if($task->is_overdue)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-700 dark:bg-rose-900/50 dark:text-rose-300 animate-pulse">
                                                <flux:icon name="exclamation-triangle" class="size-3" />
                                                OVERDUE
                                            </span>
                                        @endif

                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-700/60 dark:text-zinc-300 border border-zinc-200/60 dark:border-zinc-700">
                                            {{ $task->category ?? 'Operations' }}
                                        </span>

                                        @if($task->priority === 'High')
                                            <flux:badge size="sm" color="red" icon="fire">{{ $task->priority }}</flux:badge>
                                        @elseif($task->priority === 'Medium')
                                            <flux:badge size="sm" color="indigo">{{ $task->priority }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="zinc">{{ $task->priority }}</flux:badge>
                                        @endif
                                    </div>

                                    <span class="text-[11px] font-mono text-zinc-400">#{{ $task->id }}</span>
                                </div>

                                <!-- Title & Description -->
                                <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 dark:hover:text-indigo-400 block mb-1.5 leading-snug">
                                    {{ $task->title }}
                                </a>
                                @if($task->description)
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2 mb-3">
                                        {{ $task->description }}
                                    </p>
                                @endif

                                <!-- Checklist Progress Bar (if items exist) -->
                                @if($task->total_items_count > 0)
                                    <div class="mb-3 p-2 bg-zinc-50 dark:bg-zinc-900/60 rounded-xl border border-zinc-100 dark:border-zinc-800">
                                        <div class="flex items-center justify-between text-[11px] font-medium text-zinc-500 dark:text-zinc-400 mb-1">
                                            <span class="flex items-center gap-1">
                                                <flux:icon name="check-circle" class="size-3 text-indigo-500" />
                                                Checklist
                                            </span>
                                            <span>{{ $task->completed_items_count }}/{{ $task->total_items_count }} ({{ $task->checklist_progress }}%)</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-500 rounded-full transition-all duration-300" style="width: {{ $task->checklist_progress }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Meta Footer & Fast Move Action -->
                                <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700/60 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-1.5 text-xs text-zinc-600 dark:text-zinc-300">
                                        <div class="size-6 rounded-full bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold text-[10px]">
                                            {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                        </div>
                                        <span class="truncate max-w-[90px] text-[11px] font-medium">{{ $task->assigned_to }}</span>
                                    </div>

                                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="In Progress">
                                        <flux:button type="submit" size="xs" variant="subtle" icon-trailing="arrow-right" class="text-[11px]">
                                            Start
                                        </flux:button>
                                    </form>
                                </div>
                            </flux:card>
                        </div>
                    @empty
                        <div class="text-center py-12 text-zinc-400 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                            <flux:icon name="inbox" class="size-6 mx-auto mb-1 opacity-60" />
                            <span class="text-xs">No pending tasks (Drag here)</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. IN PROGRESS COLUMN (Sky Blue) -->
            <div
                @dragover="onDragOver('In Progress', $event)"
                @dragleave="onDragLeave('In Progress')"
                @drop="dropTask('In Progress', $event)"
                :class="{ 'ring-2 ring-sky-400 bg-sky-50/50 dark:bg-sky-950/20': targetColumn === 'In Progress' }"
                class="rounded-3xl bg-zinc-100/70 dark:bg-zinc-900/60 border border-sky-200/60 dark:border-sky-900/40 p-4 sm:p-5 flex flex-col shadow-xs transition-all duration-200 min-h-[500px]"
            >
                <!-- Column Header -->
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-sky-200/50 dark:border-sky-900/40">
                    <div class="flex items-center gap-2.5">
                        <div class="size-3.5 rounded-full bg-sky-500 ring-4 ring-sky-100 dark:ring-sky-950/60"></div>
                        <h2 class="font-bold text-sm text-zinc-900 dark:text-zinc-100 tracking-wide uppercase">In Progress</h2>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300">
                        {{ $inProgressTasks->count() }}
                    </span>
                </div>

                <!-- Cards List -->
                <div class="space-y-3.5 flex-1">
                    @forelse($inProgressTasks as $task)
                        <div
                            draggable="true"
                            @dragstart="startDrag({{ $task->id }}, $event)"
                            @dragend="endDrag()"
                            class="cursor-grab active:cursor-grabbing transform transition-all duration-150"
                        >
                            <flux:card class="p-4! shadow-xs hover:shadow-md transition-all duration-200 rounded-2xl bg-white dark:bg-zinc-800 border-zinc-200/80 dark:border-zinc-700/80 group">
                                <!-- Overdue, Category and Priority Row -->
                                <div class="flex items-center justify-between gap-1.5 mb-2.5 flex-wrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @if($task->is_overdue)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-700 dark:bg-rose-900/50 dark:text-rose-300 animate-pulse">
                                                <flux:icon name="exclamation-triangle" class="size-3" />
                                                OVERDUE
                                            </span>
                                        @endif

                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-700/60 dark:text-zinc-300 border border-zinc-200/60 dark:border-zinc-700">
                                            {{ $task->category ?? 'Operations' }}
                                        </span>

                                        @if($task->priority === 'High')
                                            <flux:badge size="sm" color="red" icon="fire">{{ $task->priority }}</flux:badge>
                                        @elseif($task->priority === 'Medium')
                                            <flux:badge size="sm" color="indigo">{{ $task->priority }}</flux:badge>
                                        @else
                                            <flux:badge size="sm" color="zinc">{{ $task->priority }}</flux:badge>
                                        @endif
                                    </div>

                                    <span class="text-[11px] font-mono text-zinc-400">#{{ $task->id }}</span>
                                </div>

                                <!-- Title & Description -->
                                <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 dark:hover:text-indigo-400 block mb-1.5 leading-snug">
                                    {{ $task->title }}
                                </a>
                                @if($task->description)
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2 mb-3">
                                        {{ $task->description }}
                                    </p>
                                @endif

                                <!-- Checklist Progress Bar (if items exist) -->
                                @if($task->total_items_count > 0)
                                    <div class="mb-3 p-2 bg-zinc-50 dark:bg-zinc-900/60 rounded-xl border border-zinc-100 dark:border-zinc-800">
                                        <div class="flex items-center justify-between text-[11px] font-medium text-zinc-500 dark:text-zinc-400 mb-1">
                                            <span class="flex items-center gap-1">
                                                <flux:icon name="check-circle" class="size-3 text-sky-500" />
                                                Checklist
                                            </span>
                                            <span>{{ $task->completed_items_count }}/{{ $task->total_items_count }} ({{ $task->checklist_progress }}%)</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-sky-500 rounded-full transition-all duration-300" style="width: {{ $task->checklist_progress }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Meta Footer & Fast Move Action -->
                                <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700/60 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-1.5 text-xs text-zinc-600 dark:text-zinc-300">
                                        <div class="size-6 rounded-full bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 flex items-center justify-center font-bold text-[10px]">
                                            {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                        </div>
                                        <span class="truncate max-w-[90px] text-[11px] font-medium">{{ $task->assigned_to }}</span>
                                    </div>

                                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Completed">
                                        <flux:button type="submit" size="xs" variant="primary" icon-trailing="check" class="text-[11px] bg-emerald-600 hover:bg-emerald-700">
                                            Done
                                        </flux:button>
                                    </form>
                                </div>
                            </flux:card>
                        </div>
                    @empty
                        <div class="text-center py-12 text-zinc-400 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                            <flux:icon name="arrow-path" class="size-6 mx-auto mb-1 opacity-60" />
                            <span class="text-xs">No active tasks in progress (Drag here)</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. COMPLETED COLUMN (Emerald) -->
            <div
                @dragover="onDragOver('Completed', $event)"
                @dragleave="onDragLeave('Completed')"
                @drop="dropTask('Completed', $event)"
                :class="{ 'ring-2 ring-emerald-400 bg-emerald-50/50 dark:bg-emerald-950/20': targetColumn === 'Completed' }"
                class="rounded-3xl bg-zinc-100/70 dark:bg-zinc-900/60 border border-emerald-200/60 dark:border-emerald-900/40 p-4 sm:p-5 flex flex-col shadow-xs transition-all duration-200 min-h-[500px]"
            >
                <!-- Column Header -->
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-emerald-200/50 dark:border-emerald-900/40">
                    <div class="flex items-center gap-2.5">
                        <div class="size-3.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100 dark:ring-emerald-950/60"></div>
                        <h2 class="font-bold text-sm text-zinc-900 dark:text-zinc-100 tracking-wide uppercase">Completed</h2>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                        {{ $completedTasks->count() }}
                    </span>
                </div>

                <!-- Cards List -->
                <div class="space-y-3.5 flex-1">
                    @forelse($completedTasks as $task)
                        <div
                            draggable="true"
                            @dragstart="startDrag({{ $task->id }}, $event)"
                            @dragend="endDrag()"
                            class="cursor-grab active:cursor-grabbing transform transition-all duration-150 opacity-90 hover:opacity-100"
                        >
                            <flux:card class="p-4! shadow-xs hover:shadow-md transition-all duration-200 rounded-2xl bg-white dark:bg-zinc-800 border-zinc-200/80 dark:border-zinc-700/80 group">
                                <!-- Category & Priority Row -->
                                <div class="flex items-center justify-between gap-1.5 mb-2.5 flex-wrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <flux:badge size="sm" color="emerald" icon="check">Done</flux:badge>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-700/60 dark:text-zinc-300">
                                            {{ $task->category ?? 'Operations' }}
                                        </span>
                                    </div>
                                    <span class="text-[11px] font-mono text-zinc-400">#{{ $task->id }}</span>
                                </div>

                                <!-- Title & Description -->
                                <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-sm text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 dark:hover:text-indigo-400 block mb-1.5 leading-snug line-through text-zinc-500 dark:text-zinc-400">
                                    {{ $task->title }}
                                </a>

                                <!-- Checklist Summary (if items exist) -->
                                @if($task->total_items_count > 0)
                                    <div class="mb-3 text-[11px] text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                                        <flux:icon name="check-badge" class="size-3.5" />
                                        All {{ $task->total_items_count }} subtasks completed
                                    </div>
                                @endif

                                <!-- Meta Footer & Reopen Action -->
                                <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700/60 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-1.5 text-xs text-zinc-500">
                                        <div class="size-6 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 flex items-center justify-center font-bold text-[10px]">
                                            {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                        </div>
                                        <span class="truncate max-w-[90px] text-[11px]">{{ $task->assigned_to }}</span>
                                    </div>

                                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="In Progress">
                                        <flux:button type="submit" size="xs" variant="ghost" icon="arrow-path" class="text-[11px] text-zinc-400 hover:text-zinc-700" title="Reopen task">
                                            Reopen
                                        </flux:button>
                                    </form>
                                </div>
                            </flux:card>
                        </div>
                    @empty
                        <div class="text-center py-12 text-zinc-400 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                            <flux:icon name="check-circle" class="size-6 mx-auto mb-1 opacity-60" />
                            <span class="text-xs">No completed tasks yet (Drag here to complete)</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <x-footer />
    </flux:main>
</x-layouts::app>
