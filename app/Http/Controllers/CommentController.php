<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\Comment;

class CommentController extends Controller
{

    public function index(Thread $thread)
    {
        echo "hello world echo";
        return Inertia::render('Thread/Index', [
            'threads' => $thread->comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Thread $thread)
    {
        echo "hello world echo post";
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = $thread->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);
        
        Log::info(['thread +++++++' => $thread]);
        Log::info(['validated --------' => $validated]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread, Comment $comment)
    {
        \Log::info('Updating comment', ['comment' => $comment->toArray(), 'thread' => $thread->toArray()]);

        if ($comment->thread_id !== $thread->id) {
            abort(404);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        \Log::info('Validated request data', ['data' => $validated]);

        $comment->body = $validated['body'];
        $comment->save();

        \Log::info('Comment updated successfully', ['comment' => $comment->toArray()]);

        return response()->json(['message' => 'Comment updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread, Comment $comment)
    {
        // Check if the comment belongs to the thread
        if ($comment->thread_id !== $thread->id) {
            abort(404, 'Comment not found in this thread.');
        }

        // Proceed with deletion
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }


}
