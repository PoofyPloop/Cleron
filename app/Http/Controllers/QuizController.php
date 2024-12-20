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
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject)
    {
        // echo "hello world echo";
        // Log::info('subject:');
        
        // return Inertia::render('Quiz/Index', [
        //     'quizzes' => $subject->quizzes
        // ]);
        
        $quizzes = $subject->quizzes()->with('subject')->get();

        return Inertia::render('Quiz/Index', [
            'quizzes' => $quizzes
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
            'subject_id' => 'required|exists:subjects,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['slug'] = Str::slug($validated['title']);

        $quiz = $subject->quizzes()->create($validated);

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

    // public function complete(Request $request, Subject $subject, Quiz $quiz)
    // {

    //     return Inertia::render('Quiz/Complete', [
    //         'quiz' => $quiz->append('score'),
    //         'questions' => $quiz->questions->each(function ($question) {
    //             $question->append('answer');
    //         })
    //     ]);
    // }

    public function complete(Request $request, Subject $subject, Quiz $quiz)
    {
        $questions = $quiz->questions->map(function ($question) {
            $answer = $question->answers()
                ->where('user_id', auth()->id())
                ->latest()
                ->first();
                
            $question->answer = $answer;
            return $question;
        });

        return Inertia::render('Quiz/Complete', [
            'quiz' => $quiz->append('score'),
            'subject' => $subject,
            'questions' => $questions
        ]);
    }
    
    // public function submit(Request $request, Subject $subject, Quiz $quiz)
    // {
    //     $validated = $request->validate([
    //         'questions' => 'required|array',
    //         'questions.*.id' => 'required|exists:questions,id',
    //         'questions.*.user_answer' => 'required|string',
    //     ]);

    //     // Begin a DB transaction to ensure consistency
    //     DB::transaction(function () use ($request, $validated, $quiz) {
    //         collect($validated['questions'])->each(function ($question) use ($request) {

    //             // Find the current question
    //             $currentQuestion = Question::find($question['id']);

    //             // Determine if the user answer is correct
    //             $isCorrect = $question['user_answer'] == $currentQuestion->value;

    //             // Update or create an answer record
    //             $currentQuestion->answers()->updateOrCreate([
    //                 'user_id' => $request->user()->id,
    //             ], [
    //                 'score' => $isCorrect ? $currentQuestion->points : 0,
    //                 'value' => $question['user_answer'],
    //             ]);
    //         });
    //     });

    //     // Mark the quiz as ended
    //     $quiz->update([
    //         'ended_at' => now()
    //     ]);

    //     // Redirect to the complete page
    //     return redirect()->route('subjects.quizzes.complete', [$subject, $quiz]);
    // }

    // public function complete(Request $request, Subject $subject, Quiz $quiz)
    // {
    //     // Load the quiz with questions and the user's answers
    //     $quiz->load(['questions.answers' => function ($query) use ($request) {
    //         // Only fetch answers for the logged-in user
    //         $query->where('user_id', $request->user()->id);
    //     }]);

    //     // Append the 'score' attribute to the quiz
    //     $quiz->append('score'); 

    //     // Return the quiz and questions data to the frontend
    //     return Inertia::render('Quiz/Complete', [
    //         'quiz' => $quiz,
    //         'questions' => $quiz->questions, // Pass the questions with answers for the current user
    //     ]);
    // }



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
        
        Log::info(['validated' => $validated]);
        
        $quiz->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, $quiz)
    {
        $quiz = Quiz::where('slug', $quiz)->firstOrFail();

        // optional check
        if ($quiz->subject_id !== $subject->id) {
            return abort(404, 'Quiz not found for this subject');
        }

        $quiz->delete();

        return redirect()->back()->with('success', 'Quiz deleted successfully.');
    }
}
