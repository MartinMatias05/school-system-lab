@extends('layouts.app')

@section('title', 'Register Student')

@section('content')
<div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
    <a href="{{ route('students.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">← Back to students</a>
    <h1 class="mt-3 text-2xl font-bold text-slate-900">Register New Student</h1>
    <p class="mb-6 mt-1 text-sm text-slate-500">Enter the required student details below.</p>
    <form action="{{ route('students.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label for="student_number" class="mb-1 block text-sm font-semibold">Student Number</label>
            <input id="student_number" name="student_number" value="{{ old('student_number') }}" required maxlength="50" class="w-full rounded border border-slate-300 p-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="first_name" class="mb-1 block text-sm font-semibold">First Name</label>
                <input id="first_name" name="first_name" value="{{ old('first_name') }}" required maxlength="100" class="w-full rounded border border-slate-300 p-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            <div>
                <label for="last_name" class="mb-1 block text-sm font-semibold">Last Name</label>
                <input id="last_name" name="last_name" value="{{ old('last_name') }}" required maxlength="100" class="w-full rounded border border-slate-300 p-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
        </div>
        <div>
            <label for="email" class="mb-1 block text-sm font-semibold">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255" class="w-full rounded border border-slate-300 p-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
            <label for="date_of_birth" class="mb-1 block text-sm font-semibold">Date of Birth</label>
            <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required max="{{ now()->subDay()->toDateString() }}" class="w-full rounded border border-slate-300 p-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="rounded bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Register Student</button>
            <a href="{{ route('students.index') }}" class="rounded bg-slate-200 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300">Cancel</a>
        </div>
    </form>
</div>
@endsection
