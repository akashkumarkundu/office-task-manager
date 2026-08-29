<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    /**
     * Store a new subtask for a specific task.
     */
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $subtask = $task->subtasks()->create([
            'title' => $validated['title'],
            'is_completed' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask,
                'progress' => $task->fresh()->subtask_progress,
                'message' => 'Subtask added successfully!',
            ]);
        }

        return redirect()->back()->with('success', 'Subtask added successfully!');
    }

    /**
     * Toggle completion status of a subtask.
     */
    public function toggle(Request $request, Subtask $subtask)
    {
        $subtask->update([
            'is_completed' => !$subtask->is_completed,
        ]);

        $task = $subtask->task->fresh();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_completed' => $subtask->is_completed,
                'progress' => $task->subtask_progress,
                'message' => 'Subtask status updated!',
            ]);
        }

        return redirect()->back()->with('success', 'Subtask status updated!');
    }

    /**
     * Remove a subtask.
     */
    public function destroy(Request $request, Subtask $subtask)
    {
        $task = $subtask->task;
        $subtask->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'progress' => $task->fresh()->subtask_progress,
                'message' => 'Subtask deleted!',
            ]);
        }

        return redirect()->back()->with('success', 'Subtask deleted!');
    }
}
