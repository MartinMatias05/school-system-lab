@extends('layouts.app')

@section('title', 'Activities')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div><p class="text-sm font-semibold uppercase tracking-wider text-blue-700">Assignments</p><h1 class="mt-1 text-2xl font-bold text-slate-900">Student Activities</h1><p class="mt-1 text-sm text-slate-500">Create assignments and monitor student submissions.</p></div>
    <a href="{{ route('activities.create') }}" class="rounded bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">+ Create Activity</a>
</div>
<div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-slate-200 text-xs uppercase tracking-wide text-slate-700"><tr><th class="p-4">Activity Title</th><th class="p-4">Course</th><th class="p-4">Max Points</th><th class="p-4">Due Date</th><th class="p-4">Submissions</th><th class="p-4">Actions</th></tr></thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($activities as $activity)
                    <tr class="hover:bg-slate-50"><td class="p-4 font-semibold text-slate-900">{{ $activity->title }}</td><td class="p-4"><span class="font-mono text-xs font-bold">{{ $activity->course->code }}</span><div class="mt-1 text-xs text-slate-500">{{ $activity->course->title }}</div></td><td class="p-4 font-bold">{{ $activity->max_points }} pts</td><td class="whitespace-nowrap p-4 text-slate-600">{{ $activity->due_date->format('M d, Y h:i A') }}</td><td class="p-4"><span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold text-green-800">{{ $activity->submissions_count }} submitted</span></td><td class="p-4"><a href="{{ route('activities.show', $activity) }}" class="whitespace-nowrap rounded bg-slate-200 px-3 py-1.5 text-xs font-bold hover:bg-slate-300">View / Grade</a></td></tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-slate-500">No activities created yet. Add a course first, then create an activity.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $activities->links() }}</div>
@endsection
