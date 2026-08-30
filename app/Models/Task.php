<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $assigned_to
 * @property string $priority
 * @property string $status
 * @property string|Carbon|null $due_date
 * @property-read bool $is_overdue
 * @property-read int $days_overdue
 * @property string|null $urgency_label
 * @property string|null $urgency_color
 * @property float|int|null $percentage
 * @property int|null $task_count
 * @property int|null $completed_count
 * @property int|null $pending_count
 * @property int|null $in_progress_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @use HasFactory<TaskFactory>
 */
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    /**
     * @var list<string>
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
     * Scope a query to only include overdue tasks.
     * Logic: due_date < today AND status != 'Completed'.
     *
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', Carbon::today());
    }

    /**
     * Scope a query to only include tasks due soon (within $days).
     *
     * @param  Builder<Task>  $query
     * @return Builder<Task>
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
     *
     * @return Attribute<bool, never>
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
     *
     * @return Attribute<int, never>
     */
    protected function daysOverdue(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) $this->getAttribute('is_overdue')
                ? max(1, (int) Carbon::parse($this->due_date)->diffInDays(Carbon::today()))
                : 0,
        );
    }
}
