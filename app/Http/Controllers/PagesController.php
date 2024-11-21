<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Scores;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Discussion;
use App\Models\DiscussionComment;

class PagesController extends Controller
{
    // public function home(Request $request)
    public function home()
    {
        // $search = $request->input('search');
        // $type = $request->input('type');
        $search = request('search');
        $type = request('type');

        // $quizzes = $request->user()->quizzes()
        //     ->with(['category', 'subject'])
        //     ->where('title', 'LIKE', "%$search%")
        //     ->latest()
        //     ->paginate(10);

        // $statistics = [
        //     'quizzes' => $request->user()->quizzes()->count(),
        //     'threads' => $request->user()->threads()->count(),
        //     'comments' => $request->user()->comments()->count(),
        //     'average' => $request->user()->answers()->avg('score'),
        // ];

        // return Inertia::render('Home', [
        //     'statistics' => $statistics,
        //     'quizzes' => $quizzes,
        //     'subject' => Subject::first(),
        // ]);

        return Inertia::render('Home', [
            'statistics' => [
                'quizzes' => request()->user()->quizzes()->count() ?? 0,
                'threads' => request()->user()->threads()->count() ?? 0,
                'comments' => request()->user()->comments()->count() ?? 0,
                'average' => request()->user()->answers()->avg('score') ?? 0,
            ],

            'quizzes' => request()->user()->quizzes()
                ->with(['category', 'subject'])
                ->where('title', 'LIKE', "%$search%")
                ->orderBy('created_at', 'DESC')
                ->paginate(10),

                'subject' => Subject::first(),
        ]);
    }

    public function subjects()
    {
        $subjects = Subject::with(['quizzes.user', 'quizzes.category'])->get();

        return Inertia::render('Subjects', [
            'subjects' => $subjects
        ]);
    }
}