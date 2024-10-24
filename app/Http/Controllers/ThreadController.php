<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Thread;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Threads/Index', [
            'threads' => Thread::with('user', 'comments')->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Threads/Create');
    }

    /**@s
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $thread = $request->user()->threads()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        $thread->load(['user', 'comments.user']);

        // Ensure the comment data includes the slug
        $comments = $thread->comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'body' => $comment->body,
                'slug' => $comment->slug, 
                'user' => $comment->user,
                'created_at' => $comment->created_at,
            ];
        });

        return Inertia::render('Threads/Show', [
            'thread' => $thread,
            'comments' => $comments, 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        return Inertia::render('Threads/Edit', [
            'thread' => $thread,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|url',
        ]);

        $thread->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return redirect()->back();
    }
}
