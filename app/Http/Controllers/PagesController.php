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
use App\Models\Report;

class PagesController extends Controller
{

    public function home()
    {
        $search = request('search');
        $type = request('type');

        $statistics = [
            'quizzes' => request()->user()->quizzes()->count() ?? 0,
            'threads' => request()->user()->threads()->count() ?? 0,
            'comments' => request()->user()->comments()->count() ?? 0,
            'average' => request()->user()->answers()->avg('score') ?? 0,
        ];

        $pendingReports = [];

        if (auth()->user()->role == 2) {

            $pendingReports = Report::with(['quiz', 'user'])->get();

            \Log::info('Fetched Pending Reports Count:', [$pendingReports->count()]);
        }

        return Inertia::render('Home', [
            'statistics' => $statistics,
            'quizzes' => request()->user()->quizzes()
                ->with(['category', 'subject'])
                ->where('title', 'LIKE', "%$search%")
                ->orderBy('created_at', 'DESC')
                ->paginate(10),
            'subject' => Subject::first(),
            'pendingReports' => $pendingReports,
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