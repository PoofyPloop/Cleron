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

        $quizzes = Quiz::where('user_id', auth()->user()->id)
        ->orderBy('id', 'desc')
        ->when($search, function ($query) use ($search){
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->get();

        $discussions = Discussion::where('user_id', auth()->user()->id)
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('Home', [
            'quizzes' => $quizzes,
            'discussions' => $discussions
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
