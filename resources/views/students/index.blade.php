@extends('layouts.app')

@section('title', 'Student Roster')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">Student Management</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-900">Student Roster</h1>
        <p class="mt-1 text-sm text-slate-500">View student records and manage course enrollment.</p>
    </div>
    <a href="{{ route('students.create') }}" class="rounded bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">+ Register Student</a>
</div>

<div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-slate-200 text-xs uppercase tracking-wide text-slate-700">
                <tr>
                    <th class="p-4">Student Number</th>
                    <th class="p-4">Full Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Courses</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
            @forelse ($students as $student)
                <tr class="hover:bg-slate-50">
                    <td class="whitespace-nowrap p-4 font-mono text-xs font-bold text-slate-600">{{ $student->student_number }}</td>
                    <td class="whitespace-nowrap p-4 font-semibold text-slate-900">{{ $student->full_name }}</td>
                    <td class="p-4 text-slate-600">{{ $student->email }}</td>
                    <td class="p-4"><span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-800">{{ $student->courses_count }}</span></td>
                    <td class="p-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('students.show', $student) }}" class="rounded bg-slate-200 px-3 py-1.5 text-xs font-bold hover:bg-slate-300">View / Enroll</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student and related enrollment/submission records?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-200">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-8 text-center text-slate-500">No student records found. Register the first student to begin.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $students->links() }}</div>
@endsection
