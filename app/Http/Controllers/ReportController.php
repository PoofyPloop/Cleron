<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Report;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subject $subject, Quiz $quiz)
    {
        return Inertia::render('Reports/Index', [
            'reports' => $quiz->reports()->with('user')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject, Quiz $quiz)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $quiz->reports()->create([
            'description' => $validated['description'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Quiz $quiz, Report $report)
    {
        $report->delete();

        return redirect()->back();
    }
}
