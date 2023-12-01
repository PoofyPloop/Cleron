<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;
;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject, Quiz $quiz, Question $question)
    {
        return Inertia::render("Quiz/Index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject, Quiz $quiz, Question $question)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'answers' => 'required|array'
        ]);
        collect($validated['answers'])->each(function (array $answer) use ($question) {
            $question->answes()->create([
                'user_id' => auth()->id(),
                'value' => "required|string",
            ]);
        });

        return redirect()->route('/quizzes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Quiz $quiz, Question $question, Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject, Quiz $quiz, Question $question, Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject, Quiz $quiz, Question $question, Answer $answer)
    {
        $validated = $request->validate([
            'value' => 'required_if:type,textbox|string|max:200',
        ]);

        $answer->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Quiz $quiz, Question $question, Answer $answer)
    {
        $answer->delete();

        return redirect()->back();
    }
}
