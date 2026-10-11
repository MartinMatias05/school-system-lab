@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="mb-5"><a href="{{ route('students.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">← Back to students</a></div>
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">Student Profile</p>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $student->full_name }}</h1>
            <dl class="mt-5 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-500">Student Number</dt><dd class="mt-1 font-mono font-bold">{{ $student->student_number }}</dd></div>
                <div><dt class="text-slate-500">Email</dt><dd class="mt-1 font-semibold">{{ $student->email }}</dd></div>
                <div><dt class="text-slate-500">Date of Birth</dt><dd class="mt-1 font-semibold">{{ $student->date_of_birth->format('F d, Y') }}</dd></div>
                <div><dt class="text-slate-500">Registered</dt><dd class="mt-1 font-semibold">{{ $student->created_at->format('F d, Y') }}</dd></div>
            </dl>
        </section>
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-bold">Enrolled Courses <span class="text-slate-500">({{ $student->courses->count() }})</span></h2>
            <div class="mt-4 space-y-3">
                @forelse ($student->courses as $course)
                    <div class="flex flex-wrap items-center justify-between gap-3 rounded border border-slate-200 bg-slate-50 p-4">
                        <div><p class="font-mono text-sm font-bold">{{ $course->code }}</p><p class="mt-1 text-sm text-slate-600">{{ $course->title }} · {{ $course->credits }} credits</p><p class="mt-1 text-xs text-slate-500">Enrolled: {{ \Illuminate\Support\Carbon::parse($course->pivot->enrolled_at)->format('M d, Y') }}</p></div>
                        <span class="rounded bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">Enrolled</span>
                    </div>
                @empty
                    <p class="rounded bg-slate-50 p-4 text-sm text-slate-500">This student is not enrolled in any courses yet.</p>
                @endforelse
            </div>
        </section>
    </div>
    <aside class="h-fit rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-lg font-bold">Enroll in Course</h2>
        <p class="mb-4 mt-1 text-sm text-slate-500">Choose a course not yet assigned to this student.</p>
        @if ($availableCourses->isNotEmpty())
            <form action="{{ route('students.enroll', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="course_id" class="mb-1 block text-sm font-semibold">Select Course</label>
                    <select id="course_id" name="course_id" required class="w-full rounded border border-slate-300 p-3 text-sm">
                        <option value="">-- Choose Course --</option>
                        @foreach ($availableCourses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->code }} — {{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full rounded bg-blue-600 px-4 py-3 text-sm font-bold text-white hover:bg-blue-700">Enroll Student</button>
            </form>
        @else
            <p class="rounded bg-green-50 p-3 text-sm text-green-800">The student is enrolled in every available course.</p>
        @endif
        <a href="{{ route('courses.create') }}" class="mt-4 block text-center text-sm font-semibold text-blue-700 hover:underline">+ Create a course</a>
    </aside>
</div>
@endsection
