<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    /**
     * Store a newly created discussion comment on a task.
     */
    public function store(Request $request, Task $task): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:2000',
        ], [
            'comment.required' => 'Please write a message before submitting.',
            'comment.max' => 'Your comment cannot exceed 2,000 characters.',
        ]);

        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $comment = $task->comments()->create([
            'user_id' => $userId,
            'comment' => $validated['comment'],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully.',
                'comment' => $comment->load('user'),
            ]);
        }

        return back()->with('success', 'Comment posted to discussion.');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Request $request, TaskComment $comment): RedirectResponse
    {
        // Only author can delete comment if authenticated
        if ($request->user() && $request->user()->id !== $comment->user_id) {
            abort(403, 'You are not authorized to delete this comment.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
