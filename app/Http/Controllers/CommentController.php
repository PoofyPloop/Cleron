<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'body' => 'required',
        ]);

        $comment = $thread->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread, Comment $comment)
    {
        $validated = $request->validate([
            'body' => 'required',
        ]);

        $comment->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread, Comment $comment)
    {
        $comment->delete();

        return redirect()->back();
    }
}
