<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    /**
     * Store a new comment for a task.
     */
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'comment' => 'required|string|max:1000',
        ]);

        $task->comments()->create([
            'user_name' => $validated['user_name'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Comment posted to task discussion!');
    }
}
