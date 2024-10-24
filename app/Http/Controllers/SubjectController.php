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
            'subjects' => fn() => Subject::with(['quizzes.user', 'quizzes.category', 'quizzes.subject'])->get(),
            // 'categories' => fn() => Category::select(['title', 'subject_id'])->get(),
        ]);

        // $subjects = Subject::with(['quizzes.user', 'quizzes.category', 'quizzes.subject'])->get();
        // $categories = Category::select(['id', 'title', 'subject_id'])->get(); // Fetch categories correctly

        // return Inertia::render('Subjects/Index', [
        //     'subjects' => fn() => $subjects,
        //     'categories' => fn() => $categories, // Ensure categories are included
        // ]);
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
