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
    public function index()
    {
        $quizzes = Quiz::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();

        return Inertia::render('Quiz/Index', [
            'quizzes' => $quizzes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $subjects = Subject::all();

        return Inertia::render('Quiz/Create', [
            'categories' => $categories,
            'subjects' => $subjects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:50'],
            'subject' => ['required'],
            'category' => ['required'],
        ]);

        Quiz::create([
            'user_id' => auth()->user()->id,
            'title' => $validated['title'],
            'subject_id' => $validated['subject'],
            'category_id' => $validated['category']
        ]);

        return back()->with([
            'data' => 'Quiz created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $categories = Category::all();
        $subjects = Subject::all();

        return Inertia::render('Quiz/Show', [
            'categories' => $categories,
            'subjects' => $subjects,
            'quiz' => fn() => $quiz -> load(['questions'])
        ]);
    }

    public function test(string $id)
    {
        $categories = Category::all();
        $subjects = Subject::all();
        // $quiz = Quiz::where('id', $id)->with('questions.answer')->first();
        $quiz = Quiz::findOrFail($id);

        return Inertia::render('Quiz', [
            'categories' => $categories,
            'subjects' => $subjects,
            'quiz' => $quiz
        ]);
    }

    public function result(Request $request, string $id)
    {
        //find quiz by id
        // $quiz = Quiz::where('id', $id)->with('questions.answer')->first();
        $quiz = Quiz::findOrFail($id);
        
        // initializing variables
        $points = 0;
        $totalPoints = 0;

        // loop through questions
        foreach($quiz->questions as $i => $question) {
            // compare user answer with correct answer
            if($question->answer->answer == $request->answers[$i]) {
                $points += $question->points;
            }

            // Sums up total points
            $totalPoints += $question->points;
            $i++;
        }

        // stores the points in the database
        Points::create([
            'user_id' => auth()->user()->id,
            'quiz_id' => $id,
            'points' => $totalPoints
        ]);
        
        //returns the data
        return Inertia::render('Quiz/Result', [
            'quiz' => $quiz,
            'points' => $points,
            'totalPoints' => $totalPoints
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $subjects = Subject::all();
        // $quiz = Quiz::where('id', $id)->with('questions.answer')->first();
        $quiz = Quiz::findOrFail($id);

        return Inertia::render('Quiz/Edit', [
            'categories' => $categories,
            'subjects' => $subjects,
            'quiz' => $quiz
        ]);
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
