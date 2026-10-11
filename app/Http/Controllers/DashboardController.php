<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'students' => Student::count(),
            'courses' => Course::count(),
            'activities' => Activity::count(),
            'submissions' => Submission::count(),
            'pending_grading' => Submission::whereNull('score')->count(),
        ];

        $recentStudents = Student::query()
            ->latest()
            ->limit(5)
            ->get();

        $recentActivities = Activity::query()
            ->with('course')
            ->withCount('submissions')
            ->latest()
            ->limit(5)
            ->get();

        $upcomingActivities = Activity::query()
            ->with('course')
            ->where('due_date', '>=', now())
            ->orderBy('due_date')
            ->limit(4)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentStudents',
            'recentActivities',
            'upcomingActivities',
        ));
    }
}
