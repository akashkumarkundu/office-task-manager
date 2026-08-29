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
        'is_pinned',
        'title',
        'description',
        'assigned_to',
        'category',
        'tags',
        'priority',
        'status',
        'due_date',
        'estimated_hours',
        'spent_hours',
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
            'estimated_hours' => 'integer',
            'spent_hours' => 'float',
            'is_pinned' => 'boolean',
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
     * Parsed Tags array accessor.
     *
     * @return array<int, string>
     */
    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->tags))));
    }

    /**
     * Time budget / spent efficiency percentage.
     */
    public function getTimeProgressAttribute(): int
    {
        $estimate = (float) ($this->estimated_hours ?: 8);
        $spent = (float) ($this->spent_hours ?: 0);
        
        if ($estimate <= 0) return 0;
        return (int) min(100, round(($spent / $estimate) * 100));
    }

    /**
     * Priority badge class accessor.
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'Urgent' => 'badge-priority-urgent',
            'High' => 'badge-priority-high',
            'Medium' => 'badge-priority-medium',
            'Low' => 'badge-priority-low',
            default => 'badge-priority-medium',
        };
    }

    /**
     * Priority icon accessor.
     */
    public function getPriorityIconAttribute(): string
    {
        return match ($this->priority) {
            'Urgent' => 'fa-solid fa-fire-flame-curved text-danger',
            'High' => 'fa-solid fa-angles-up text-danger',
            'Medium' => 'fa-solid fa-equals text-warning',
            'Low' => 'fa-solid fa-angles-down text-info',
            default => 'fa-solid fa-circle-dot text-secondary',
        };
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
     * Formatted Estimated Hours accessor.
     */
    public function getFormattedEstimateAttribute(): string
    {
        return ($this->estimated_hours ?? 8) . ' hrs';
    }

    /**
     * Dynamic Category Styling Badge accessor.
     */
    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'Development', 'Frontend', 'Backend' => 'badge-cat-dev',
            'DevOps', 'Security', 'Cloud' => 'badge-cat-ops',
            'Design', 'UI/UX' => 'badge-cat-design',
            'Finance', 'Accounts' => 'badge-cat-finance',
            'Marketing', 'Growth' => 'badge-cat-marketing',
            default => 'badge-cat-general',
        };
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
     * Scope for searching by title, assigned person, category, or tags.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!empty($term)) {
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('assigned_to', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%")
                  ->orWhere('tags', 'like', "%{$term}%");
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
        if (!empty($priority) && in_array($priority, ['Urgent', 'High', 'Medium', 'Low'])) {
            $query->where('priority', $priority);
        }

        return $query;
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeFilterCategory($query, ?string $category)
    {
        if (!empty($category)) {
            $query->where('category', $category);
        }

        return $query;
    }

    /**
     * Scope for filtering by tag.
     */
    public function scopeFilterTag($query, ?string $tag)
    {
        if (!empty($tag)) {
            $query->where('tags', 'like', "%{$tag}%");
        }

        return $query;
    }

    /**
     * Scope for pinned tasks.
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
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
