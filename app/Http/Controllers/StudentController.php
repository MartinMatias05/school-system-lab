<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::withCount('courses')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:50', 'unique:students,student_number'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student registered successfully.');
    }

    public function show(Student $student): View
    {
        $student->load('courses');
        $availableCourses = Course::query()
            ->whereDoesntHave('students', fn ($query) => $query->whereKey($student->id))
            ->orderBy('code')
            ->get();

        return view('students.show', compact('student', 'availableCourses'));
    }

    public function enroll(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => [
                'required',
                'integer',
                'exists:courses,id',
                Rule::unique('enrollments', 'course_id')
                    ->where(fn ($query) => $query->where('student_id', $student->id)),
            ],
        ], [
            'course_id.unique' => 'This student is already enrolled in the selected course.',
        ]);

        $student->courses()->attach($validated['course_id'], [
            'enrolled_at' => now()->toDateString(),
        ]);

        return redirect()->route('students.show', $student)->with('success', 'Course enrollment saved.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        // Related enrollments and submissions are removed by database cascade constraints.
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student record deleted.');
    }
}
