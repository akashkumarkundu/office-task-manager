<x-layouts::app title="Task Details - {{ $task->title }}">
    <flux:main container>
        <!-- Header & Action Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('tasks.index') }}" variant="ghost" icon="arrow-left">
                    Back to Task List
                </flux:button>
                <flux:button href="{{ route('tasks.kanban') }}" variant="ghost" icon="view-columns">
                    Kanban View
                </flux:button>
            </div>

            <div class="flex items-center gap-3">
                <flux:button href="{{ route('tasks.edit', $task) }}" variant="primary" icon="pencil-square" class="shadow-xs">
                    Edit Task
                </flux:button>

                <!-- Delete Modal Trigger -->
                <flux:modal.trigger name="delete-task-{{ $task->id }}">
                    <flux:button variant="danger" icon="trash">
                        Delete Task
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <!-- Visual Task Progress Indicator (Pending -> In Progress -> Completed) -->
        <flux:card class="mb-8 p-6 shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900">
            <div class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-6">Workflow Stage</div>
            
            <div class="grid grid-cols-3 gap-2 sm:gap-4 relative">
                <!-- Progress Line Background -->
                <div class="absolute top-1/2 left-[16%] right-[16%] -translate-y-1/2 h-1 bg-zinc-100 dark:bg-zinc-800 -z-0 hidden sm:block"></div>
                
                @php
                    $isPendingActive = in_array($task->status, ['Pending', 'In Progress', 'Completed']);
                    $isInProgressActive = in_array($task->status, ['In Progress', 'Completed']);
                    $isCompletedActive = $task->status === 'Completed';
                @endphp

                <!-- Step 1: Pending -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="size-10 sm:size-12 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $isPendingActive ? 'bg-amber-500 text-white ring-4 ring-amber-100 dark:ring-amber-950/60 shadow-xs' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' }}">
                        @if($isInProgressActive && $task->status !== 'Pending')
                            <flux:icon name="check" class="size-5 text-white" />
                        @else
                            <flux:icon name="clock" class="size-5" />
                        @endif
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-semibold {{ $task->status === 'Pending' ? 'text-amber-600 dark:text-amber-400 font-bold' : 'text-zinc-700 dark:text-zinc-300' }}">
                        Pending
                    </span>
                </div>

                <!-- Step 2: In Progress -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="size-10 sm:size-12 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $isInProgressActive ? ($task->status === 'Completed' ? 'bg-emerald-500 text-white' : 'bg-sky-600 text-white ring-4 ring-sky-100 dark:ring-sky-950/60 shadow-xs') : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' }}">
                        @if($isCompletedActive)
                            <flux:icon name="check" class="size-5 text-white" />
                        @else
                            <flux:icon name="arrow-path" class="size-5 {{ $task->status === 'In Progress' ? 'animate-spin' : '' }}" />
                        @endif
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-semibold {{ $task->status === 'In Progress' ? 'text-sky-600 dark:text-sky-400 font-bold' : ($isInProgressActive ? 'text-zinc-700 dark:text-zinc-300' : 'text-zinc-400') }}">
                        In Progress
                    </span>
                </div>

                <!-- Step 3: Completed -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="size-10 sm:size-12 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $isCompletedActive ? 'bg-emerald-600 text-white ring-4 ring-emerald-100 dark:ring-emerald-950/60 shadow-xs' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' }}">
                        <flux:icon name="check-badge" class="size-5" />
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-semibold {{ $isCompletedActive ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-400' }}">
                        Completed
                    </span>
                </div>
            </div>
        </flux:card>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Task Details, Checklist, & Discussions -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Task Primary Information Card -->
                <flux:card class="shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 sm:p-8">
                    <!-- Badges Row -->
                    <div class="flex items-center gap-2 mb-4 flex-wrap">
                        @if($task->is_overdue)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800 animate-pulse">
                                <flux:icon name="exclamation-triangle" class="size-3.5" />
                                OVERDUE ({{ $task->days_overdue }} days)
                            </span>
                        @endif

                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            {{ $task->category ?? 'Operations' }}
                        </span>

                        @if($task->priority === 'High')
                            <flux:badge size="sm" color="red" icon="fire">{{ $task->priority }} Priority</flux:badge>
                        @elseif($task->priority === 'Medium')
                            <flux:badge size="sm" color="indigo">{{ $task->priority }} Priority</flux:badge>
                        @else
                            <flux:badge size="sm" color="zinc">{{ $task->priority }} Priority</flux:badge>
                        @endif

                        @if($task->status === 'Completed')
                            <flux:badge size="sm" color="emerald" icon="check">{{ $task->status }}</flux:badge>
                        @elseif($task->status === 'In Progress')
                            <flux:badge size="sm" color="blue" icon="arrow-path">{{ $task->status }}</flux:badge>
                        @else
                            <flux:badge size="sm" color="amber" icon="clock">{{ $task->status }}</flux:badge>
                        @endif
                    </div>

                    <flux:heading size="xl" level="1" class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 mb-6 leading-tight">
                        {{ $task->title }}
                    </flux:heading>

                    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-6">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">
                            Description & Notes
                        </label>
                        <div class="text-zinc-700 dark:text-zinc-300 text-sm leading-relaxed bg-zinc-50/70 dark:bg-zinc-800/40 p-5 sm:p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800 whitespace-pre-line min-h-[100px]">
                            {{ $task->description ?: 'No additional description provided for this task.' }}
                        </div>
                    </div>
                </flux:card>

                <!-- Sub-tasks / Deliverables Checklist Card -->
                <flux:card class="shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 sm:p-8">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400">
                                <flux:icon name="clipboard-document-check" class="size-5" />
                            </span>
                            <div>
                                <flux:heading size="lg" level="2" class="font-bold text-zinc-900 dark:text-zinc-100">
                                    Sub-tasks & Deliverables Checklist
                                </flux:heading>
                                <flux:subheading size="sm">
                                    Breakdown of deliverables required for completing this task.
                                </flux:subheading>
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                            {{ $task->completed_items_count }} / {{ $task->total_items_count }} Completed ({{ $task->checklist_progress }}%)
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden mb-6">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ $task->checklist_progress }}%"></div>
                    </div>

                    <!-- Checklist Items List -->
                    <div class="space-y-2.5 mb-6">
                        @forelse($task->items as $item)
                            <div class="flex items-center justify-between p-3.5 rounded-xl border border-zinc-200/80 dark:border-zinc-700/80 bg-zinc-50/50 dark:bg-zinc-800/50 hover:bg-white dark:hover:bg-zinc-800 transition-colors">
                                <form action="{{ route('tasks.items.toggle', $item) }}" method="POST" class="flex items-center gap-3 flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="size-5 rounded-md border flex items-center justify-center transition-colors {{ $item->is_completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 hover:border-emerald-500' }}">
                                        @if($item->is_completed)
                                            <flux:icon name="check" class="size-3.5 stroke-[3]" />
                                        @endif
                                    </button>
                                    <span class="text-sm {{ $item->is_completed ? 'line-through text-zinc-400 dark:text-zinc-500' : 'text-zinc-800 dark:text-zinc-200 font-medium' }}">
                                        {{ $item->title }}
                                    </span>
                                </form>

                                <form action="{{ route('tasks.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this checklist item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 p-1 transition-colors" title="Delete item">
                                        <flux:icon name="x-mark" class="size-4" />
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-6 text-zinc-400 bg-zinc-50/50 dark:bg-zinc-800/30 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 text-xs">
                                No checklist items added yet. Add steps below to track sub-deliverables!
                            </div>
                        @endforelse
                    </div>

                    <!-- Add New Checklist Item Form -->
                    <form action="{{ route('tasks.items.store', $task) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <flux:input name="title" placeholder="Add a new deliverable step (e.g. Prepare design drafts)..." required class="flex-1" />
                        <flux:button type="submit" variant="primary" icon="plus" size="sm">
                            Add Step
                        </flux:button>
                    </form>
                </flux:card>

                <!-- Discussion & Comments Feed Card -->
                <flux:card class="shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 sm:p-8">
                    <div class="flex items-center gap-2.5 mb-6">
                        <span class="p-1.5 rounded-lg bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400">
                            <flux:icon name="chat-bubble-left-right" class="size-5" />
                        </span>
                        <div>
                            <flux:heading size="lg" level="2" class="font-bold text-zinc-900 dark:text-zinc-100">
                                Team Discussion & Progress Notes
                            </flux:heading>
                            <flux:subheading size="sm">
                                Real-time activity logs and collaboration thread.
                            </flux:subheading>
                        </div>
                    </div>

                    <!-- New Comment Submission Form -->
                    <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="mb-8">
                        @csrf
                        <flux:textarea name="comment" placeholder="Write an update, note, or reply for team members..." rows="3" required class="mb-3" />
                        <div class="flex justify-end">
                            <flux:button type="submit" variant="primary" icon="paper-airplane" size="sm">
                                Post Update
                            </flux:button>
                        </div>
                    </form>

                    <!-- Comments Stream -->
                    <div class="space-y-4">
                        @forelse($task->comments as $comment)
                            <div class="p-4 rounded-2xl border border-zinc-200/70 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/40">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2.5">
                                        <div class="size-7 rounded-full bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold text-xs">
                                            {{ $comment->user ? $comment->user->initials() : 'U' }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-xs text-zinc-900 dark:text-zinc-100">
                                                {{ $comment->user ? $comment->user->name : 'Team Member' }}
                                            </span>
                                            <span class="text-[11px] text-zinc-400 ml-1.5">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(auth()->check() && auth()->id() === $comment->user_id)
                                        <form action="{{ route('tasks.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete your comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 p-1 text-xs" title="Delete comment">
                                                <flux:icon name="trash" class="size-3.5" />
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="text-xs text-zinc-700 dark:text-zinc-300 leading-relaxed whitespace-pre-line pl-9">
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-zinc-400 bg-zinc-50/30 dark:bg-zinc-800/20 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 text-xs">
                                No comments or discussion notes yet. Start the conversation above!
                            </div>
                        @endforelse
                    </div>
                </flux:card>
            </div>

            <!-- Right 1 Col: Metadata Sidebar -->
            <div class="space-y-6">
                <!-- Metadata Card -->
                <flux:card class="shadow-sm rounded-2xl border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">
                    <div class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-5">Task Details</div>

                    <div class="space-y-5 text-sm">
                        <!-- Assigned To -->
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1.5">Assigned Responsible</span>
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($task->assigned_to, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $task->assigned_to }}</div>
                                    @if($task->assignedUser)
                                        <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">Registered User ({{ $task->assignedUser->email }})</div>
                                    @else
                                        <div class="text-[11px] text-zinc-400">Team Member</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Department / Category -->
                        <div class="border-t border-zinc-100 dark:border-zinc-800 pt-4">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1.5">Department / Category</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200">
                                {{ $task->category ?? 'Operations' }}
                            </span>
                        </div>

                        <!-- Due Date -->
                        <div class="border-t border-zinc-100 dark:border-zinc-800 pt-4">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1.5">Due Date</span>
                            <div class="flex items-center gap-2 font-medium {{ $task->is_overdue ? 'text-rose-600 dark:text-rose-400 font-bold' : 'text-zinc-800 dark:text-zinc-200' }}">
                                <flux:icon name="calendar" class="size-4 opacity-70" />
                                <span>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('l, d M Y') : 'No deadline set' }}</span>
                            </div>
                            @if($task->due_date)
                                <span class="text-xs text-zinc-400 mt-1 block">
                                    ({{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }})
                                </span>
                            @endif
                        </div>

                        <!-- Created Timestamp -->
                        <div class="border-t border-zinc-100 dark:border-zinc-800 pt-4">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">Created Date</span>
                            <div class="text-xs font-medium text-zinc-700 dark:text-zinc-300 flex items-center gap-1.5">
                                <flux:icon name="clock" class="size-3.5 text-zinc-400" />
                                <span>{{ $task->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>

                        <!-- Updated Timestamp -->
                        <div class="border-t border-zinc-100 dark:border-zinc-800 pt-4">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">Last Updated</span>
                            <div class="text-xs font-medium text-zinc-700 dark:text-zinc-300 flex items-center gap-1.5">
                                <flux:icon name="arrow-path" class="size-3.5 text-zinc-400" />
                                <span>{{ $task->updated_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>

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
                    <strong>"{{ $task->title }}"</strong> and all associated checklist items & discussion comments will be permanently removed.
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
