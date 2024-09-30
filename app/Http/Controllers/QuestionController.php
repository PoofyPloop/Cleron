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
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject, Quiz $quiz)
    {
        $validated = $request->validate([
            'label' => "required|string",
            'value' => "nullable|max:200",
            'type' => "required|in:text,radio,textarea",
            'options' => "required_if:type,radio|array",
            'options.*.label' => 'string|max:200',
            'options.*.value' => 'nullable|max:200',
            'points' => 'sometimes|integer|min:1|max:25',
        ]);
        
        $question = $quiz->questions()->create($validated);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject, Quiz $quiz, Question $question)
    {

        $validated = $request->validate([
            'label' => 'required|string|max:200',
            'value' => 'nullable|string|max:200',
            'type' => 'required|in:text,radio,textarea',
            'points' => 'sometimes|integer|min:1|max:25',
            'options' => "required_if:type,radio|array|min:2|max:4",
            'options.*.label' => 'string|max:200',
            'options.*.value' => 'nullable|string|max:200',
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
