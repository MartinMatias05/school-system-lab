@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-heading">
    <div>
        <p class="page-eyebrow">MANAGEMENT OVERVIEW</p>
        <h1>Good day, Administrator <span aria-hidden="true">✦</span></h1>
        <p>Here is a snapshot of your school's academic records and current activity.</p>
    </div>
    <div class="heading-right">
        <span class="live-chip">Workspace active</span>
        <a href="{{ route('students.create') }}" class="btn-primary"><span aria-hidden="true">＋</span> Register student</a>
    </div>
</div>

<div class="metric-grid">
    <article class="metric-card">
        <div class="metric-top">
            <span class="metric-label">Total students</span>
            <span class="metric-icon blue"><svg viewBox="0 0 24 24"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-6A3.5 3.5 0 0 0 3 18.5V20"/><circle cx="9.5" cy="7.5" r="3.5"/><path d="M17 11a3.5 3.5 0 0 0 0-7M17.5 15h.5a3 3 0 0 1 3 3v2"/></svg></span>
        </div>
        <div class="metric-value">{{ number_format($stats['students']) }}</div>
        <div class="metric-caption"><strong>Registered records</strong> in the system</div>
        <span class="metric-spark" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
    </article>
    <article class="metric-card">
        <div class="metric-top">
            <span class="metric-label">Active courses</span>
            <span class="metric-icon green"><svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z"/><path d="M4 17.5A2.5 2.5 0 0 1 6.5 15H20M8 7h8M8 10h6"/></svg></span>
        </div>
        <div class="metric-value">{{ number_format($stats['courses']) }}</div>
        <div class="metric-caption"><strong>Available courses</strong> in the catalog</div>
        <span class="metric-spark" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
    </article>
    <article class="metric-card">
        <div class="metric-top">
            <span class="metric-label">Course activities</span>
            <span class="metric-icon purple"><svg viewBox="0 0 24 24"><rect x="4" y="3.5" width="16" height="17" rx="2"/><path d="M8 8h8M8 12h8M8 16h4"/></svg></span>
        </div>
        <div class="metric-value">{{ number_format($stats['activities']) }}</div>
        <div class="metric-caption"><strong>Created assignments</strong> across all courses</div>
        <span class="metric-spark" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
    </article>
    <article class="metric-card">
        <div class="metric-top">
            <span class="metric-label">Submissions received</span>
            <span class="metric-icon orange"><svg viewBox="0 0 24 24"><path d="M7 3.5h7l4 4V20a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 20V5A1.5 1.5 0 0 1 7.5 3.5Z"/><path d="M14 3.5V8h4M9 13h6M9 16h6"/></svg></span>
        </div>
        <div class="metric-value">{{ number_format($stats['submissions']) }}</div>
        <div class="metric-caption"><strong>{{ number_format($stats['pending_grading']) }} awaiting grading</strong> · not yet scored</div>
        <span class="metric-spark" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
    </article>
</div>

<div class="dashboard-grid">
    <div class="dashboard-column">
        <section class="panel-card">
            <div class="panel-header">
                <div><h2 class="panel-title">Recent course activities</h2><p class="panel-subtitle">Latest assignments added to the academic workspace</p></div>
                <a href="{{ route('activities.index') }}" class="panel-link">View all <span aria-hidden="true">→</span></a>
            </div>
            <div class="overflow-x-auto">
                <table class="dashboard-table">
                    <thead><tr><th>Activity</th><th>Course</th><th>Due date</th><th>Submitted</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($recentActivities as $activity)
                        <tr>
                            <td><div class="table-primary">{{ $activity->title }}</div><div class="table-secondary">{{ $activity->created_at?->format('M j, Y') ?? 'Recently added' }}</div></td>
                            <td><span class="course-code">{{ $activity->course->code }}</span><div class="table-secondary">{{ $activity->course->title }}</div></td>
                            <td><span class="table-primary">{{ $activity->due_date->format('M j, Y') }}</span><div class="table-secondary">{{ $activity->due_date->format('g:i A') }}</div></td>
                            <td><span class="status-pill {{ $activity->submissions_count ? '' : 'neutral' }}">{{ $activity->submissions_count }} received</span></td>
                            <td><a href="{{ route('activities.show', $activity) }}" class="panel-link" aria-label="View {{ $activity->title }}">Open →</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state"><strong>No activities yet</strong>Create a course activity to start collecting student work.</div></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel-card">
            <div class="panel-header">
                <div><h2 class="panel-title">Recently registered students</h2><p class="panel-subtitle">The latest student records added to the system</p></div>
                <a href="{{ route('students.index') }}" class="panel-link">Manage students <span aria-hidden="true">→</span></a>
            </div>
            <div class="overflow-x-auto">
                <table class="dashboard-table">
                    <thead><tr><th>Student</th><th>Student number</th><th>Email address</th><th>Registered</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($recentStudents as $student)
                        <tr>
                            <td><span class="avatar-initials">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($student->first_name, 0, 1).\Illuminate\Support\Str::substr($student->last_name, 0, 1)) }}</span><span class="table-primary">{{ $student->full_name }}</span></td>
                            <td><span class="course-code">{{ $student->student_number }}</span></td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->created_at->format('M j, Y') }}</td>
                            <td><a href="{{ route('students.show', $student) }}" class="panel-link" aria-label="View {{ $student->full_name }}">View →</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state"><strong>No students registered</strong>Add your first student record to get started.</div></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="dashboard-column">
        <section class="panel-card">
            <div class="panel-header"><div><h2 class="panel-title">Quick actions</h2><p class="panel-subtitle">Common management tasks</p></div></div>
            <div class="panel-body">
                <div class="quick-action-grid">
                    <a href="{{ route('students.create') }}" class="quick-action"><span class="quick-action-icon"><svg viewBox="0 0 24 24"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-6A3.5 3.5 0 0 0 3 18.5V20"/><circle cx="9.5" cy="7.5" r="3.5"/><path d="M19 8v6M16 11h6"/></svg></span><strong>Register student</strong></a>
                    <a href="{{ route('courses.create') }}" class="quick-action"><span class="quick-action-icon"><svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z"/><path d="M4 17.5A2.5 2.5 0 0 1 6.5 15H20M8 7h8"/></svg></span><strong>Add course</strong></a>
                    <a href="{{ route('activities.create') }}" class="quick-action"><span class="quick-action-icon"><svg viewBox="0 0 24 24"><rect x="4" y="3.5" width="16" height="17" rx="2"/><path d="M8 8h8M8 12h8M8 16h4"/></svg></span><strong>Create activity</strong></a>
                </div>
            </div>
        </section>

        <section class="panel-card">
            <div class="panel-header"><div><h2 class="panel-title">Upcoming deadlines</h2><p class="panel-subtitle">Activities due next</p></div><a href="{{ route('activities.index') }}" class="panel-link">All activities →</a></div>
            <div class="panel-body">
                <div class="due-list">
                    @forelse ($upcomingActivities as $activity)
                        <a href="{{ route('activities.show', $activity) }}" class="due-item" style="text-decoration:none">
                            <span class="due-date-box"><strong>{{ $activity->due_date->format('d') }}</strong><small>{{ $activity->due_date->format('M') }}</small></span>
                            <span class="due-item-main"><strong>{{ $activity->title }}</strong><p>{{ $activity->course->code }} · {{ $activity->course->title }}</p><p>{{ $activity->due_date->format('l, g:i A') }}</p></span>
                        </a>
                    @empty
                        <div class="empty-state"><strong>No upcoming deadlines</strong>New activities with future due dates will appear here.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="panel-card">
            <div class="panel-header"><div><h2 class="panel-title">System management</h2><p class="panel-subtitle">Keep key records up to date</p></div></div>
            <div class="panel-body">
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 py-3"><div><div class="table-primary">Student records</div><div class="table-secondary">Registration and enrollment</div></div><a href="{{ route('students.index') }}" class="panel-link">Manage →</a></div>
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 py-3"><div><div class="table-primary">Course catalog</div><div class="table-secondary">Codes, titles and credits</div></div><a href="{{ route('courses.index') }}" class="panel-link">Manage →</a></div>
                <div class="flex items-center justify-between gap-3 py-3"><div><div class="table-primary">Submissions and grading</div><div class="table-secondary">{{ number_format($stats['pending_grading']) }} items awaiting scores</div></div><a href="{{ route('activities.index') }}" class="panel-link">Review →</a></div>
            </div>
        </section>
    </div>
</div>
@endsection
