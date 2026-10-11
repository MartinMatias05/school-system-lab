@extends('layouts.app')

@section('title', 'Courses')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div><p class="text-sm font-semibold uppercase tracking-wider text-blue-700">Course Catalog</p><h1 class="mt-1 text-2xl font-bold text-slate-900">Courses</h1><p class="mt-1 text-sm text-slate-500">Manage the courses students can enroll in.</p></div>
    <a href="{{ route('courses.create') }}" class="rounded bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">+ Create Course</a>
</div>
<div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-slate-200 text-xs uppercase tracking-wide text-slate-700"><tr><th class="p-4">Code</th><th class="p-4">Course Title</th><th class="p-4">Credits</th><th class="p-4">Students</th><th class="p-4">Activities</th></tr></thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50"><td class="p-4 font-mono font-bold">{{ $course->code }}</td><td class="p-4 font-semibold">{{ $course->title }}</td><td class="p-4">{{ $course->credits }}</td><td class="p-4">{{ $course->students_count }}</td><td class="p-4">{{ $course->activities_count }}</td></tr>
                @empty
                    <tr><td colspan="5" class="p-8 text-center text-slate-500">No courses found. Create the first course.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $courses->links() }}</div>
@endsection
