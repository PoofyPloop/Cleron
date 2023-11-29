<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;
;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Quiz $quiz, Question $question)
    {
        return Inertia::render("Quiz/Index");
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
        $validated = $request->validate([
            'answers' => 'required|array'
        ]);
        collect($validated['answers'])->each(function (array $answer) use ($question) {
            $question->answes()->create([
                'user_id' => auth()->id(),
                'value' => "required|string",
                'options' => "required_if:type,radio|array",
                'options.*.value' => 'required_if:type,radio|string|max:200',
            ]);
        });

        return redirect()->route('WHATEVER UR QUIZ SUCCESS URL IS');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz, Question $question, Answer $answer)
    {
        $validated = $request->validate([
            // Add answer rules
            'options' => "required_if:type,radio|array",
            'options.*.value' => 'required_if:type,radio|string|max:200',
            'value' => 'required_if:type,textbox|string|max:200',
        ]);

        $answer->update($validated);
// a wild justin has been sighted --->  
        return redirect()->back();
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
