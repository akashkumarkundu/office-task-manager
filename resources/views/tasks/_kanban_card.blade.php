<div class="card-custom p-3 card-custom-interactive position-relative {{ $task->is_pinned ? 'border-warning' : '' }}">
    <!-- Top Row: Category, Pin, and Priority -->
    <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="badge-cat {{ $task->category_color }}">{{ $task->category ?? 'General' }}</span>
        <div class="d-flex align-items-center gap-1">
            @if($task->is_pinned)
                <i class="fa-solid fa-thumbtack text-warning fs-6" title="Pinned to top"></i>
            @endif
            <span class="badge {{ $task->priority_badge_class }} rounded-pill px-2 py-1" style="font-size: 0.68rem;">
                <i class="{{ $task->priority_icon }} me-1"></i> {{ $task->priority }}
            </span>
        </div>
    </div>

    <!-- Title -->
    <h6 class="fw-bold mb-2">
        <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-reset">
            {{ $task->title }}
        </a>
    </h6>

    <!-- Tags -->
    @if(!empty($task->tags))
        <div class="d-flex flex-wrap gap-1 mb-2">
            @foreach($task->tags_array as $tag)
                <span class="tag-pill">#{{ $tag }}</span>
            @endforeach
        </div>
    @endif

    <!-- Subtasks Progress -->
    @if($task->subtasks->count() > 0)
        <div class="mb-2">
            <div class="d-flex justify-content-between small text-muted mb-1" style="font-size: 0.72rem;">
                <span>Subtasks</span>
                <span class="fw-bold">{{ $task->subtask_progress }}%</span>
            </div>
            <div class="progress" style="height: 5px; background: var(--surface-hover);">
                <div class="progress-bar bg-info" style="width: {{ $task->subtask_progress }}%;"></div>
            </div>
        </div>
    @endif

    <!-- Bottom Row: Assignee, Hours, Quick Move -->
    <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary border-opacity-25 mt-2">
        <div class="d-flex align-items-center">
            <div class="avatar-circle me-1" style="width: 24px; height: 24px; font-size: 0.65rem;">
                {{ substr($task->assigned_to, 0, 1) }}
            </div>
            <span class="small text-muted">{{ $task->assigned_to }}</span>
        </div>

        <div class="d-flex align-items-center gap-1">
            <!-- 1-Click Timer Start -->
            <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0 rounded-pill small" style="font-size: 0.7rem;" title="Start Stopwatch" onclick="startTaskTimer({{ $task->id }}, '{{ addslashes($task->title) }}')">
                <i class="fa-solid fa-play"></i> {{ $task->spent_hours }}h
            </button>

            <!-- Quick Kanban Column Move Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary px-2 py-0 rounded-circle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical" style="font-size: 0.75rem;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end theme-dropdown-menu shadow">
                    <li class="dropdown-header text-uppercase small text-muted">Move to Status</li>
                    <li>
                        <button class="dropdown-item small" onclick="quickUpdateStatus({{ $task->id }}, 'Pending')">
                            <i class="fa-solid fa-clock text-warning me-2"></i> Pending
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item small" onclick="quickUpdateStatus({{ $task->id }}, 'In Progress')">
                            <i class="fa-solid fa-arrows-spin text-info me-2"></i> In Progress
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item small" onclick="quickUpdateStatus({{ $task->id }}, 'Completed')">
                            <i class="fa-solid fa-circle-check text-success me-2"></i> Completed
                        </button>
                    </li>
                    <li><hr class="dropdown-divider my-1 border-secondary opacity-25"></li>
                    <li>
                        <button class="dropdown-item small text-danger" onclick="openDeleteModal({{ $task->id }}, '{{ addslashes($task->title) }}')">
                            <i class="fa-regular fa-trash-can me-2"></i> Delete Task
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof window.quickUpdateStatus === 'undefined') {
        window.quickUpdateStatus = async function(taskId, newStatus) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const res = await fetch(`/tasks/${taskId}/status`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ status: newStatus })
                });
                const data = await res.json();
                if (data.success) {
                    if (newStatus === 'Completed') triggerConfetti();
                    showToast(data.message);
                    setTimeout(() => window.location.reload(), 400);
                }
            } catch (e) {
                console.error(e);
            }
        };
    }
</script>
