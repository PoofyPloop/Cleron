<?php

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
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // quiz
    // Route::get('/quiz/test/{id}', [QuizController::class, 'test'])->name('quiz.test');
    // Route::post('/quiz/test/{id}', [QuizController::class, 'result'])->name('quiz.result');
    // Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    // Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
    // Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
    // Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])->name('quiz.show');
    // Route::post('/quiz', [QuizController::class, 'store'])->name('quiz.store');
    // Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('quiz.update');
    // Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy');

    // question
    // Route::get('/question', [QuestionController::class, 'index'])->name('question.index');
    // Route::get('/question/{id}', [QuestionController::class, 'show'])->name('question.show');
    // Route::get('/question/create', [QuestionController::class, 'create'])->name('question.create');
    // Route::post('/question', [QuestionController::class, 'store'])->name('question.store');
    // Route::put('/question/{id}', [QuestionController::class, 'update'])->name('question.update');
    // Route::delete('/question/{id}', [QuestionController::class, 'destroy'])->name('question.destroy');

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

    // messages
    Route::get('/messages', [ChatsController::class, 'index']);
    Route::get('/messages/inbox', [ChatsController::class, 'fetchMessages']);
});

require __DIR__.'/auth.php';
