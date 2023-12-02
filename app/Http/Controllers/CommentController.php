<?php

namespace App\Http\Controllers;

// StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.
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
