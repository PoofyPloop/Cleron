<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Subjects/Index', [
            // 'subjects' => fn() => Subject::with(['quizzes.user', 'quizzes.category', 'quizzes.subject'])->paginate(15), // Fetches 10 records per page
            // 'categories' => fn() => Category::select('subject_id', 'title')->get(),
            'subjects' => fn() => Subject::with(['quizzes.user', 'quizzes.category', 'quizzes.subject'])->get(),
            // 'categories' => fn() => Category::select('subject_id', 'title')->get(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**@s
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
