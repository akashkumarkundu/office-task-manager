<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'priority',
        'status',
        'due_date',
    ];

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
}
