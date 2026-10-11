@extends('layouts.app')

@section('title', $activity->title)

@section('content')
<div class="mb-5"><a href="{{ route('activities.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">← Back to activities</a></div>
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <span class="rounded bg-blue-100 px-2.5 py-1 font-mono text-xs font-bold text-blue-800">{{ $activity->course->code }}</span>
            <h1 class="mt-3 text-2xl font-bold text-slate-900">{{ $activity->title }}</h1>
            <p class="mt-2 text-sm text-slate-500">Due: {{ $activity->due_date->format('F d, Y h:i A') }} · Maximum points: {{ $activity->max_points }}</p>
            <hr class="my-5">
            <div class="whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $activity->description }}</div>
        </section>
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-bold">Submitted Works <span class="text-slate-500">({{ $activity->submissions->count() }})</span></h2>
            <div class="mt-4 space-y-4">
                @forelse ($activity->submissions as $submission)
                    <article class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <div class="flex flex-wrap items-start justify-between gap-2"><div><h3 class="font-bold text-slate-900">{{ $submission->student->full_name }}</h3><p class="text-xs text-slate-500">{{ $submission->student->student_number }}</p></div><span class="text-xs text-slate-500">Submitted {{ $submission->submitted_at->format('M d, Y h:i A') }}</span></div>
                        @if ($submission->submission_text)
                            <p class="mt-3 whitespace-pre-line break-words rounded border border-slate-200 bg-white p-3 text-sm text-slate-700">{{ $submission->submission_text }}</p>
                        @endif
                        @if ($submission->file_path)
                            <p class="mt-3"><a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($submission->file_path) }}" target="_blank" rel="noopener" class="text-sm font-semibold text-blue-700 underline">View uploaded file</a></p>
                        @endif
                        <form action="{{ route('activities.grade', [$activity, $submission]) }}" method="POST" class="mt-4 grid grid-cols-1 gap-3 border-t border-slate-200 pt-4 sm:grid-cols-3">
                            @csrf
                            <div><label for="score-{{ $submission->id }}" class="mb-1 block text-xs font-bold uppercase text-slate-600">Score / {{ $activity->max_points }}</label><input id="score-{{ $submission->id }}" type="number" name="score" min="0" max="{{ $activity->max_points }}" value="{{ old('score', $submission->score) }}" class="w-full rounded border border-slate-300 bg-white p-2 text-sm"></div>
                            <div class="sm:col-span-2"><label for="feedback-{{ $submission->id }}" class="mb-1 block text-xs font-bold uppercase text-slate-600">Feedback</label><input id="feedback-{{ $submission->id }}" name="feedback" value="{{ old('feedback', $submission->feedback) }}" maxlength="5000" class="w-full rounded border border-slate-300 bg-white p-2 text-sm"></div>
                            <div class="sm:col-span-3"><button type="submit" class="rounded bg-slate-800 px-4 py-2 text-xs font-bold text-white hover:bg-slate-700">Save Grade &amp; Feedback</button></div>
                        </form>
                    </article>
                @empty
                    <p class="rounded bg-slate-50 p-4 text-sm text-slate-500">No student submissions recorded yet.</p>
                @endforelse
            </div>
        </section>
    </div>
    <aside class="h-fit rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-lg font-bold">Turn In Activity</h2>
        <p class="mb-4 mt-1 text-sm text-slate-500">Only students enrolled in {{ $activity->course->code }} can submit. You can enter an answer, upload a file, or do both.</p>
        @if ($pendingStudents->isNotEmpty())
            <form action="{{ route('activities.submit', $activity) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div><label for="student_id" class="mb-1 block text-sm font-semibold">Select Student</label><select id="student_id" name="student_id" required class="w-full rounded border border-slate-300 p-3 text-sm"><option value="">-- Enrolled Students --</option>@foreach ($pendingStudents as $student)<option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->student_number }} — {{ $student->full_name }}</option>@endforeach</select></div>
                <div><label for="submission_text" class="mb-1 block text-sm font-semibold">Submission Text / Answer / Link</label><textarea id="submission_text" name="submission_text" rows="4" maxlength="20000" class="w-full rounded border border-slate-300 p-3 text-sm" placeholder="Type an answer or paste a link here...">{{ old('submission_text') }}</textarea></div>
                <div><label for="submission_file" class="mb-1 block text-sm font-semibold">Optional File</label><input id="submission_file" type="file" name="submission_file" accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg,.zip" class="block w-full text-sm"><p class="mt-1 text-xs text-slate-500">PDF, DOC/DOCX, TXT, PNG/JPG, or ZIP; maximum 10 MB.</p></div>
                <button type="submit" class="w-full rounded bg-green-600 px-4 py-3 text-sm font-bold text-white hover:bg-green-700">Submit Work</button>
            </form>
        @else
            <p class="rounded bg-green-50 p-3 text-sm text-green-800">All enrolled students have submitted, or no students are enrolled in this course.</p>
        @endif
        <a href="{{ route('students.create') }}" class="mt-4 block text-center text-sm font-semibold text-blue-700 hover:underline">+ Register a student</a>
    </aside>
</div>
@endsection
