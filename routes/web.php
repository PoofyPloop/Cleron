<?php

// StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SubjectController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', [PagesController::class, 'home'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::get('/quiz/demo', [QuizController::class, 'demo'])->name('quiz.demo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('subjects', SubjectController::class);

    Route::resource('subjects.quizzes', QuizController::class);
    Route::get('/subjects/{subject}/quizzes/{quiz}/results', [QuizController::class,"result"]);
    Route::resource('subjects.quizzes.questions', QuestionController::class);
    Route::resource('subjects.quizzes.questions.answers', AnswerController::class);

    // discussions/comment
    Route::post('/discussions/{id}/comment', [DiscussionController::class, 'comment'])->name('discussions.comment');
    Route::put('/discussions/{id}/comment/{cid}', [DiscussionController::class, 'commentUpdate'])->name('discussions.comment.update');
    Route::delete('/discussions/{id}/comment/{cid}', [DiscussionController::class, 'commentDelete'])->name('discussions.comment.delete');
    
    // discussions
    Route::get('/discussions', [DiscussionController::class, 'index'])->name('discussions');
    Route::get('/discussions/create', [DiscussionController::class, 'create'])->name('discussions.create');
    Route::get('/discussions/{id}', [DiscussionController::class, 'show'])->name('discussions.show');
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::put('/discussions/{id}', [DiscussionController::class, 'update'])->name('discussions.update');
    Route::delete('/discussions/{id}', [DiscussionController::class, 'destroy'])->name('discussions.destroy');
});

require __DIR__.'/auth.php';
