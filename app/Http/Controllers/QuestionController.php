<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject, Quiz $quiz)
    {
        return Inertia::render("Quiz/Index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject, Quiz $quiz)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject, Quiz $quiz)
    {   
        $validated = $request -> validate([
            'label' => "required|string",
            'value' => "nullable",
            'type' => "required|in:text,radio,textarea",
            'options' => "required_if:type,radio|array",
            'options.*.label' => 'required_if:type,radio|string|max:200',
            'options.*.value' => 'required_if:type,radio|string|max:200',
            'points'=> "required|integer",
        ]);

        $quiz->questions()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject, Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject, Quiz $quiz, Question $question)
    {
        $validated = $request -> validate([
            'text' => 'required|string|max:200',
            'type' => 'required|in:text,radio,textarea',
            'points' => 'required|integer|min:1|max:25',
            'options' => "required_if:type,radio|array|min:2|max:4",
            'options.*.label' => 'required_if:type,radio|string|max:200',
            'options.*.value' => 'required_if:type,radio|string|max:200',
            'value' => 'required_if:type,textbox|string|max:200',
        ]);

        $quiz->questions()->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->back();
    }
}
