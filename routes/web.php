<?php


use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;

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
    Route::resource('subjects.categories', CategoryController::class);
    // Route::resource('subjects.quizzes', QuizController::class);
    // Route::post('/subjects/quizzes/{quiz}/submit', [QuizController::class, "submit"])->name('subjects.quizzes.submit');
    // Route::get('/subjects/quizzes/{quiz}/complete', [QuizController::class, "complete"])->name('subjects.quizzes.complete');
    // Route::get('/subjects/quizzes/{quiz}/results', [QuizController::class, "result"])->name('subjects.quizzes.result');
    // Route::delete('/subjects/quizzes/{quiz}/destroy', [QuizController::class, 'destroy'])->name('quiz.destroy');

    Route::resource('quizzes', QuizController::class);
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, "submit"])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/complete', [QuizController::class, "complete"])->name('quizzes.complete');
    Route::get('/quizzes/{quiz}/results', [QuizController::class, "result"])->name('quizzes.result');
    Route::delete('/quizzes/{quiz}/destroy', [QuizController::class, 'destroy'])->name('quizzes.destroy');

    Route::resource('subjects.quizzes.reports', ReportController::class);
    Route::resource('subjects.quizzes.questions', QuestionController::class);
    Route::resource('subjects.quizzes.questions.answers', AnswerController::class);


    Route::resource('threads', ThreadController::class);
    Route::resource('threads.comments', CommentController::class);
});

require __DIR__ . '/auth.php';
