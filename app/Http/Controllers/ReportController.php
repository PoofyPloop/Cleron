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
        \Log::info('Report Store Method Started', [
            'current_user_id' => auth()->user()->id,
            'current_user_role' => auth()->user()->role,
            'subject_slug' => $subject->slug,
            'quiz_slug' => $quiz->slug
        ]);

        $validated = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        try {
            $report = $quiz->reports()->create([
                'description' => $validated['description'],
                'user_id' => auth()->user()->id,
            ]);

            \Log::info('Report Created Successfully', [
                'report_id' => $report->id,
                'user_id' => $report->user_id,
                'quiz_id' => $report->quiz_id,
                'description' => $report->description
            ]);

            return Inertia::location(route('home'));
        } catch (\Exception $e) {
            \Log::error('Report Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to submit report');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Quiz $quiz, Report $report)
    {
        $report->delete();

        return back()->with('success', 'Report removed successfully');
    }
}
