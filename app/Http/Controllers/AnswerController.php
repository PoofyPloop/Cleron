<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Quiz $quiz, Question $question)
    {
        dd($quiz->questions);
        dd($question->answers);
        return Intertia::render("Quiz/Index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz, Question $question, Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz, Question $question, Answer $answer)
    {
        return Inertia::render("Question/Edit", ['quiz' => $quiz, 'question' => $question, 'answer' => $answer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz, Question $question, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz, Question $question, Answer $answer)
    {
        $answer->delete();
        return redirect()->back();
    }
}
