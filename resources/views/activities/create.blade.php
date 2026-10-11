@extends('layouts.app')

@section('title', 'Create Activity')

@section('content')
<div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
    <a href="{{ route('activities.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">← Back to activities</a>
    <h1 class="mt-3 text-2xl font-bold text-slate-900">Create Course Activity</h1>
    <p class="mb-6 mt-1 text-sm text-slate-500">Set the course, instructions, score limit, and due date.</p>
    @if ($courses->isEmpty())
        <div class="rounded border-l-4 border-amber-500 bg-amber-50 p-4 text-sm text-amber-900">You must create a course before creating an activity. <a href="{{ route('courses.create') }}" class="font-bold underline">Create a course</a>.</div>
    @else
        <form action="{{ route('activities.store') }}" method="POST" class="space-y-5">
            @csrf
            <div><label for="course_id" class="mb-1 block text-sm font-semibold">Target Course</label><select id="course_id" name="course_id" required class="w-full rounded border border-slate-300 p-3 text-sm"><option value="">-- Select Course --</option>@foreach ($courses as $course)<option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->code }} — {{ $course->title }}</option>@endforeach</select></div>
            <div><label for="title" class="mb-1 block text-sm font-semibold">Activity Title</label><input id="title" name="title" value="{{ old('title') }}" required maxlength="255" class="w-full rounded border border-slate-300 p-3 text-sm"></div>
            <div><label for="description" class="mb-1 block text-sm font-semibold">Instructions / Description</label><textarea id="description" name="description" rows="5" required class="w-full rounded border border-slate-300 p-3 text-sm">{{ old('description') }}</textarea></div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2"><div><label for="max_points" class="mb-1 block text-sm font-semibold">Maximum Points</label><input id="max_points" type="number" name="max_points" value="{{ old('max_points', 100) }}" min="1" max="100000" required class="w-full rounded border border-slate-300 p-3 text-sm"></div><div><label for="due_date" class="mb-1 block text-sm font-semibold">Due Date &amp; Time</label><input id="due_date" type="datetime-local" name="due_date" value="{{ old('due_date') }}" min="{{ now()->addMinute()->format('Y-m-d\TH:i') }}" required class="w-full rounded border border-slate-300 p-3 text-sm"></div></div>
            <div class="flex flex-wrap gap-3 pt-2"><button type="submit" class="rounded bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Post Activity</button><a href="{{ route('activities.index') }}" class="rounded bg-slate-200 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300">Cancel</a></div>
        </form>
    @endif
</div>
@endsection
