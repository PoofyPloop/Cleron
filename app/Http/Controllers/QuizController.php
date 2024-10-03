<?php


namespace App\Http\Controllers;

use App\Models\Quiz;
use Inertia\Inertia;
use App\Models\Points;
use App\Models\Subject;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject)
    {
        return Inertia::render('Quiz/Index', [
            'quizzes' => $subject->quizzes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Subject $subject)
    {
        if ($request->user()->role == 1)
            return redirect()->back();
        
        return Inertia::render('Quiz/Create', [
            'categories' => $subject->categories,
            'subjects' => Subject::all()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['slug'] = Str::slug($validated['title']);

        $subject->questions()->create($validated);

        return redirect()->back();
    }

    public function submit(Request $request, Subject $subject, Quiz $quiz)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.user_answer' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $validated, $quiz) {
            collect($validated['questions'])->each(function ($question) use ($request) {

                $currentQuestion = Question::find($question['id']);

                $question['user_id'] = $request->user()->id;
                $question['is_correct'] = $question['user_answer'] == $currentQuestion->value;

                $answer = $currentQuestion->answers()->updateOrCreate([
                    'user_id' => $request->user()->id,
                ], [
                    'score' => $question['is_correct'] ? $currentQuestion->points : 0,
                    'value' => $question['user_answer'],
                ]);
            });
        });

        $quiz->update([
            'ended_at' => now()
        ]);

        return redirect()->route('subjects.quizzes.complete', [$subject, $quiz]);
    }

    public function complete(Request $request, Subject $subject, Quiz $quiz)
    {

        return Inertia::render('Quiz/Complete', [
            'quiz' => $quiz->append('score'),
            'questions' => $quiz->questions->each(function ($question) {
                $question->append('answer');
            })
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Quiz $quiz)
    {

        if (!$quiz->started_at) {
            $quiz->update([
                'started_at' => now()
            ]);
        }

        return Inertia::render('Quiz/Show', [
            'quiz' => fn() => $quiz->load(['questions'])
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
    public function edit(Request $request, Subject $subject, Quiz $quiz)
    {
        if ($request->user()->role == 1)
            return redirect()->back();



        if ($request->has('subject')) {
            $subject = Subject::where('slug', $request->subject)->get();
        }

        return Inertia::render('Quiz/Edit', [
            'categories' => $subject->categories,
            'subjects' => Subject::all(),
            'quiz' => fn() => $quiz->load(['questions'])
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'subject_id' => 'required|exists:subjects,id',
            'category_id' => 'required|exists:categories,id'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $quiz->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        echo "Quiz Controller Delete Reached";

        // $subject = Subject::where('slug', request('subject_slug'))->firstOrFail();
    
        // $quiz = Quiz::findOrFail($quiz);

        $quiz->delete();

        return redirect()->back();
    }
}
