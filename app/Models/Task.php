<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'assigned_user_id',
        'priority',
        'category',
        'status',
        'due_date',
    ];

    /**
     * Subtask checklist items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(TaskItem::class);
    }

    /**
     * Discussion comments.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->latest();
    }

    /**
     * Optional registered user assignment.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * Scope a query to only include overdue tasks.
     * Logic: due_date < today AND status != 'Completed'.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', Carbon::today());
    }

    /**
     * Scope a query to only include tasks due soon (within $days).
     */
    public function scopeDueSoon(Builder $query, int $days = 3): Builder
    {
        return $query->where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '>=', Carbon::today())
            ->whereDate('due_date', '<=', Carbon::today()->addDays($days));
    }

    /**
     * Determine if the task is overdue.
     * Logic: due_date < today AND status != 'Completed'.
     * Completed tasks are never overdue.
     */
    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->due_date !== null
                && Carbon::parse($this->due_date)->startOfDay()->isBefore(Carbon::today())
                && $this->status !== 'Completed',
        );
    }

    /**
     * Number of days overdue.
     */
    protected function daysOverdue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_overdue
                ? max(1, (int) Carbon::parse($this->due_date)->diffInDays(Carbon::today()))
                : 0,
        );
    }

    /**
     * Checklist completion percentage (0 - 100).
     */
    protected function checklistProgress(): Attribute
    {
        return Attribute::make(
            get: function () {
                $total = $this->relationLoaded('items') ? $this->items->count() : $this->items()->count();
                if ($total === 0) {
                    return 0;
                }
                $completed = $this->relationLoaded('items')
                    ? $this->items->where('is_completed', true)->count()
                    : $this->items()->where('is_completed', true)->count();

                return (int) round(($completed / $total) * 100);
            }
        );
    }

    /**
     * Count of completed checklist items.
     */
    protected function completedItemsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->relationLoaded('items')
                ? $this->items->where('is_completed', true)->count()
                : $this->items()->where('is_completed', true)->count()
        );
    }

    /**
     * Count of total checklist items.
     */
    protected function totalItemsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->relationLoaded('items')
                ? $this->items->count()
                : $this->items()->count()
        );
    }
}
