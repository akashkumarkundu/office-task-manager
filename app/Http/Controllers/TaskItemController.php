<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskItemController extends Controller
{
    /**
     * Store a newly created checklist item for a task.
     */
    public function store(Request $request, Task $task): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $item = $task->items()->create([
            'title' => $validated['title'],
            'is_completed' => false,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Checklist item added.',
                'item' => $item,
                'checklist_progress' => $task->fresh()->checklist_progress,
            ]);
        }

        return back()->with('success', 'Checklist item added.');
    }

    /**
     * Toggle the completion status of a checklist item.
     */
    public function toggle(Request $request, TaskItem $item): RedirectResponse|JsonResponse
    {
        $item->update([
            'is_completed' => ! $item->is_completed,
        ]);

        /** @var Task $task */
        $task = $item->task;
        $task->refresh();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_completed' => $item->is_completed,
                'checklist_progress' => $task->checklist_progress,
                'completed_items_count' => $task->completed_items_count,
                'total_items_count' => $task->total_items_count,
            ]);
        }

        return back()->with('success', $item->is_completed ? 'Checklist item marked as completed.' : 'Checklist item marked as pending.');
    }

    /**
     * Remove the specified checklist item.
     */
    public function destroy(Request $request, TaskItem $item): RedirectResponse|JsonResponse
    {
        /** @var Task $task */
        $task = $item->task;
        $item->delete();
        $task->refresh();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Checklist item deleted.',
                'checklist_progress' => $task->checklist_progress,
            ]);
        }

        return back()->with('success', 'Checklist item removed.');
    }
}
