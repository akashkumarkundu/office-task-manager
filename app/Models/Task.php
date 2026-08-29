<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'priority',
        'status',
        'due_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    /**
     * Subtasks relationship.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class)->orderBy('id', 'asc');
    }

    /**
     * Comments relationship.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->latest();
    }

    /**
     * Calculate Subtask completion percentage.
     */
    public function getSubtaskProgressAttribute(): int
    {
        $total = $this->subtasks->count();
        if ($total === 0) {
            return 0;
        }

        $completed = $this->subtasks->where('is_completed', true)->count();
        return (int) round(($completed / $total) * 100);
    }

    /**
     * Check if the task is overdue (past due date and not completed).
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'Completed' || !$this->due_date) {
            return false;
        }

        return $this->due_date->isPast() && !$this->due_date->isToday();
    }

    /**
     * Check if the task is due soon (within next 3 days and not completed).
     */
    public function getIsDueSoonAttribute(): bool
    {
        if ($this->status === 'Completed' || !$this->due_date) {
            return false;
        }

        $today = Carbon::today();
        $threeDaysLater = Carbon::today()->addDays(3);

        return $this->due_date->betweenIncluded($today, $threeDaysLater);
    }

    /**
     * Scope for searching by title or assigned person.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!empty($term)) {
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('assigned_to', 'like', "%{$term}%");
            });
        }

        return $query;
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeFilterStatus($query, ?string $status)
    {
        if (!empty($status) && in_array($status, ['Pending', 'In Progress', 'Completed'])) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Scope for filtering by priority.
     */
    public function scopeFilterPriority($query, ?string $priority)
    {
        if (!empty($priority) && in_array($priority, ['Low', 'Medium', 'High'])) {
            $query->where('priority', $priority);
        }

        return $query;
    }

    /**
     * Scope for overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'Completed')
                     ->whereDate('due_date', '<', Carbon::today());
    }

    /**
     * Scope for due soon tasks (due today or within 3 days).
     */
    public function scopeDueSoon($query)
    {
        return $query->where('status', '!=', 'Completed')
                     ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays(3)]);
    }
}
