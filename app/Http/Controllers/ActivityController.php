<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::with('course')
            ->withCount('submissions')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('activities.index', compact('activities'));
    }

    public function create(): View
    {
        $courses = Course::orderBy('code')->get();

        return view('activities.create', compact('courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'max_points' => ['required', 'integer', 'min:1', 'max:100000'],
            'due_date' => ['required', 'date', 'after:now'],
        ]);

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity): View
    {
        $activity->load(['course', 'submissions.student']);

        $pendingStudents = $activity->course->students()
            ->whereDoesntHave('submissions', fn ($query) => $query->where('activity_id', $activity->id))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('activities.show', compact('activity', 'pendingStudents'));
    }

    public function submit(Request $request, Activity $activity): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'integer',
                Rule::exists('enrollments', 'student_id')->where('course_id', $activity->course_id),
                Rule::unique('submissions', 'student_id')->where(fn ($query) => $query->where('activity_id', $activity->id)),
            ],
            'submission_text' => ['nullable', 'string', 'max:20000', 'required_without:submission_file'],
            'submission_file' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,txt,png,jpg,jpeg,zip', 'required_without:submission_text'],
        ], [
            'student_id.exists' => 'The selected student is not enrolled in this activity’s course.',
            'student_id.unique' => 'This student has already submitted this activity.',
            'submission_text.required_without' => 'Provide an answer or upload a file.',
            'submission_file.required_without' => 'Provide an answer or upload a file.',
        ]);

        $filePath = null;
        if ($request->hasFile('submission_file')) {
            $filePath = $request->file('submission_file')->store('submissions', 'public');
        }

        Submission::create([
            'activity_id' => $activity->id,
            'student_id' => $validated['student_id'],
            'submission_text' => $validated['submission_text'] ?? null,
            'file_path' => $filePath,
            'submitted_at' => now(),
        ]);

        return redirect()->route('activities.show', $activity)->with('success', 'Activity submission recorded.');
    }

    public function grade(Request $request, Activity $activity, Submission $submission): RedirectResponse
    {
        abort_unless($submission->activity_id === $activity->id, 404);

        $validated = $request->validate([
            'score' => ['nullable', 'integer', 'min:0', 'max:'.$activity->max_points],
            'feedback' => ['nullable', 'string', 'max:5000'],
        ]);

        $submission->update($validated);

        return redirect()->route('activities.show', $activity)->with('success', 'Submission grade and feedback saved.');
    }
}
