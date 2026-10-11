<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'School Management Console') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body antialiased">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
        <a href="{{ route('dashboard') }}" class="brand-lockup">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 40 40" fill="none"><path d="M20 4 35 12.3v15.4L20 36 5 27.7V12.3L20 4Z" fill="currentColor" opacity=".18"/><path d="M11 27V14h18v13M15 18h10M15 22h10M15 26h5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 5.5v6.8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
            </span>
            <span class="brand-copy"><strong>Campus<span>Core</span></strong><small>School Management</small></span>
        </a>

        <div class="sidebar-workspace">
            <span class="workspace-dot"></span>
            <span><strong>Academic Workspace</strong><small>Local administration</small></span>
            <span class="workspace-chevron" aria-hidden="true">⌄</span>
        </div>

        <nav class="sidebar-nav">
            <p class="nav-label">WORKSPACE</p>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="4.5" rx="1.5"/><rect x="13.5" y="11" width="7" height="9.5" rx="1.5"/><rect x="3.5" y="13" width="7" height="7.5" rx="1.5"/></svg>
                <span>Overview</span>
            </a>

            <p class="nav-label nav-label-spaced">ACADEMIC MANAGEMENT</p>
            <a href="{{ route('students.index') }}" class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 20v-1.6a3.4 3.4 0 0 0-3.4-3.4H6.4A3.4 3.4 0 0 0 3 18.4V20"/><circle cx="9.5" cy="7.5" r="3.5"/><path d="M17 11a3.5 3.5 0 0 0 0-6.8M17.5 15H18a3 3 0 0 1 3 3v2"/></svg>
                <span>Students</span><span class="nav-trailing">Records</span>
            </a>
            <a href="{{ route('courses.index') }}" class="nav-item {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z"/><path d="M4 17.5A2.5 2.5 0 0 1 6.5 15H20M8 7h8M8 10h6"/></svg>
                <span>Courses</span>
            </a>

            <p class="nav-label nav-label-spaced">TEACHING & ASSESSMENT</p>
            <a href="{{ route('activities.index') }}" class="nav-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="3.5" width="16" height="17" rx="2"/><path d="M8 8h8M8 12h8M8 16h4"/><path d="m7 3.5 1.5-2M17 3.5 15.5 1.5"/></svg>
                <span>Activities</span><span class="nav-trailing">Tasks</span>
            </a>
            <a href="{{ route('activities.index') }}" class="nav-item {{ request()->routeIs('activities.*') && request()->route('activity') ? 'nav-subtle-active' : '' }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3.5h7l4 4V20a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 20V5A1.5 1.5 0 0 1 7.5 3.5Z"/><path d="M14 3.5V8h4M9 13h6M9 16h6"/></svg>
                <span>Submissions & Grades</span>
            </a>
        </nav>

        <div class="sidebar-spacer"></div>
        <div class="sidebar-help-card">
            <span class="help-icon" aria-hidden="true">?</span>
            <div><strong>Keep records organized</strong><p>Manage students, courses and assessment from one place.</p></div>
        </div>
        <div class="sidebar-footer">
            <span class="sidebar-footer-mark">CC</span>
            <span class="sidebar-footer-copy"><strong>CampusCore Console</strong><small>Lab exam workspace</small></span>
            <span class="status-indicator" title="Local workspace"></span>
        </div>
    </aside>

    <div class="admin-main-shell">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="mobile-menu-button" id="mobileMenuButton" aria-label="Open navigation" aria-expanded="false">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="topbar-breadcrumb"><span>CampusCore</span><span class="breadcrumb-divider">/</span><strong>@yield('title', 'Dashboard')</strong></div>
            </div>
            <div class="topbar-right">
                <div class="current-date">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="2"/><path d="M7.5 3v4M16.5 3v4M4 9h16"/></svg>
                    <span>{{ now()->format('D, M j, Y') }}</span>
                </div>
                <span class="topbar-divider"></span>
                <div class="admin-profile"><span class="admin-avatar">AD</span><span class="admin-profile-copy"><strong>Administrator</strong><small>Local workspace</small></span><span class="profile-chevron">⌄</span></div>
            </div>
        </header>

        <main class="page-content">
            @if (session('success'))
                <div class="flash-message flash-success" role="status"><span class="flash-symbol">✓</span><span>{{ session('success') }}</span><button type="button" onclick="this.parentElement.remove()" aria-label="Dismiss message">×</button></div>
            @endif
            @if ($errors->any())
                <div class="flash-message flash-error" role="alert"><span class="flash-symbol">!</span><div><strong>Please check the highlighted information.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div><button type="button" onclick="this.parentElement.remove()" aria-label="Dismiss message">×</button></div>
            @endif
            @yield('content')
            <footer class="page-footer"><span>© {{ now()->year }} CampusCore · School Management System</span><span>Academic records management <span class="footer-status-dot"></span></span></footer>
        </main>
    </div>

    <script>
        (() => {
            const body = document.body;
            const openButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebarOverlay');
            const closeMenu = () => { body.classList.remove('sidebar-open'); openButton?.setAttribute('aria-expanded', 'false'); };
            openButton?.addEventListener('click', () => { body.classList.toggle('sidebar-open'); openButton.setAttribute('aria-expanded', String(body.classList.contains('sidebar-open'))); });
            overlay?.addEventListener('click', closeMenu);
            document.querySelectorAll('.sidebar-nav a').forEach(link => link.addEventListener('click', closeMenu));
        })();
    </script>
</body>
</html>
