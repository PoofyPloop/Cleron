<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Category;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Answer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Question::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();

        return Inertia::render('Question/Index', [
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

        return Inertia::render('Question/Create', [
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
            'quiz_id' => ['required'],
            'questions' => ['required', 'array'],
            'types' => ['required'],
            'scores' => ['required'],
            'options1' => ['nullable'],
            'options2' => ['nullable'],
            'options3' => ['nullable'],
            'options4' => ['nullable'],
            'answers' => ['nullable']
        ]);

        $i = 0;
        foreach($validated['questions'] as $question) {
            $question = Question::create([
                'quiz_id' => $validated['quiz_id'],
                'text' => $validated['questions'][$i],
                'type' => $validated['types'][$i],
                'score' => $validated['scores'][$i]
            ]);

            $answer = null;
            if($validated['answers'][$i] == 'option1') { $answer = $validated['options1'][$i]; }
            if($validated['answers'][$i] == 'option2') { $answer = $validated['options2'][$i]; }
            if($validated['answers'][$i] == 'option3') { $answer = $validated['options3'][$i]; }
            if($validated['answers'][$i] == 'option4') { $answer = $validated['options4'][$i]; }

            $choices = [];
            if($validated['options1'][$i]) { array_push($choices, $validated['options1'][$i]); }
            if($validated['options2'][$i]) { array_push($choices, $validated['options2'][$i]); }
            if($validated['options3'][$i]) { array_push($choices, $validated['options3'][$i]); }
            if($validated['options4'][$i]) { array_push($choices, $validated['options4'][$i]); }

            Answer::create([
                'question_id' => $question->id,
                'choices' => json_encode($choices),
                'answer' => $answer
            ]);

            $i = $i + 1;
        }
  
        return back()->with([
            'data' => 'Questions created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::all();
        $subjects = Subject::all();
        $quiz = Question::where('id', $id)->first();

        return Inertia::render('Question/Show', [
            'categories' => $categories,
            'subjects' => $subjects,
            'quiz' => $quiz
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::where('id', $id)->delete();

        return back()->with([
            'data' => 'Question deleted',
        ]);
    }
}
