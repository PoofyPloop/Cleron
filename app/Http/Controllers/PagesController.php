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
    public function home()
    {
        $search = request('search');
        $type = request('type');

        return Inertia::render('Home', [
            'statistics' => [
                'quizzes' => request()->user()->quizzes()->count(),
                'threads' => request()->user()->threads()->count(),
                'comments' => request()->user()->comments()->count(),
                'average' => request()->user()->answers()->avg('score'),
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
