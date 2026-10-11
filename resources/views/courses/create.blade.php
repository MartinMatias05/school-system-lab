@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
    <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">← Back to courses</a>
    <h1 class="mt-3 text-2xl font-bold text-slate-900">Create Course</h1>
    <p class="mb-6 mt-1 text-sm text-slate-500">Courses are used for enrollments and activities.</p>
    <form action="{{ route('courses.store') }}" method="POST" class="space-y-5">
        @csrf
        <div><label for="code" class="mb-1 block text-sm font-semibold">Course Code</label><input id="code" name="code" value="{{ old('code') }}" required maxlength="30" placeholder="e.g. IT101" class="w-full rounded border border-slate-300 p-3 text-sm"></div>
        <div><label for="title" class="mb-1 block text-sm font-semibold">Course Title</label><input id="title" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="e.g. Introduction to Information Technology" class="w-full rounded border border-slate-300 p-3 text-sm"></div>
        <div><label for="credits" class="mb-1 block text-sm font-semibold">Credits</label><input id="credits" type="number" name="credits" value="{{ old('credits', 3) }}" min="1" max="30" required class="w-full rounded border border-slate-300 p-3 text-sm"></div>
        <div class="flex flex-wrap gap-3 pt-2"><button type="submit" class="rounded bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Save Course</button><a href="{{ route('courses.index') }}" class="rounded bg-slate-200 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300">Cancel</a></div>
    </form>
</div>
@endsection
