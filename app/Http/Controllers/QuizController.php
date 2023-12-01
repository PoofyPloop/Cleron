<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Points;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject)
    {
        return Inertia::render('Quiz/Index', [
            'quizzes' => $subject -> quizzes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject)
    {
        if ($request->user()->role == 2) {
            $categories = Category::all();

            return Inertia::render('Quiz/Create', [
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:50'],
            'subject' => ['required'],
            'category' => ['required'],
        ]);

        $subject->create([
            'user_id' => auth()->user()->id,
            'title' => $validated['title'],
            'category_id' => $validated['category']
        ]);

        return back()->with([
            'data' => 'Quiz created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Quiz $quiz)
    {
        return Inertia::render('Quiz/Show', [
            'quiz' => fn() => $quiz -> load(['questions'])
        ]);
    }

    public function result(Request $request, Subject $subject, Quiz $quiz)
    {        
        return Inertia::render('Quiz/Result', [
            'questions' => $quiz->results(request()->user())
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        
        if ($request->user()->role == 2) {

            $categories = Category::all();
            $subjects = Subject::all();
            $quiz = Quiz::findOrFail($id);

            return Inertia::render('Quiz/Edit', [
                'categories' => $categories,
                'subjects' => $subjects,
                'quiz' => $quiz
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:50'],
            'subject' => ['required'],
            'category' => ['required'],
        ]);

        Quiz::where('id', $id)->update([
            'title' => $validated['title'],
            'subject_id' => $validated['subject'],
            'category_id' => $validated['category']
        ]);
        
        return back()->with([
            'data' => 'Quiz updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Quiz::where('id', $id)->delete();

        return back()->with([
            'data' => 'Quiz deleted',
        ]);
    }
}
