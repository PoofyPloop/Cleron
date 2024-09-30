<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use App\Models\Subject;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject)
    {
        return Inertia::render('Categories/Index', [
            'subject' => $subject,
            'categories' => $subject->categories()->withCount('quizzes')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject)
    {
        return Inertia::render('Categories/Create', [
            'subject' => $subject,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        $subject->categories()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Category $category)
    {
        return Inertia::render('Categories/Show', [
            'subject' => $subject,
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject, Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'subject' => $subject,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        $category->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Category $category)
    {
        $category->delete();

        return redirect()->back();
    }
}
