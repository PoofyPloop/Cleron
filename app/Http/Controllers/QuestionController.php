<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Quiz $quiz)
    {
        dd($quiz->questions);
        return Intertia::render("Quiz/Index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Quiz $quiz)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {   
        $validated = $request -> validate([
            'label' => "required|string",
            'value' => "nullable",
            'type' => "required|in:text,radio,textarea",
            'options' => "nullable|array",
            'points'=> "required|integer",
        ]);

        $quiz->questions()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz, Question $question)
    {
        return Inertia::render("Question/Edit", ['quiz' => $quiz, 'question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->back();
    }
}
