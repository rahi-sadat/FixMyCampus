<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'FixMyCampus is a campus complaint and maintenance management system for students, authority, and maintenance staff.')">

    <title>@yield('title', 'FixMyCampus | Campus Complaint & Maintenance')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    @endif

    @stack('styles')
</head>
<body>
    <header class="site-header">
        <div class="shell nav">
            <a class="brand" href="{{ url('/') }}" aria-label="FixMyCampus home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M4 11.5 12 5l8 6.5"/><path d="M6.5 10.5V19h11v-8.5"/><path d="M9 19v-5h6v5"/></svg>
                </span>
                <span>FixMyCampus</span>
            </a>

            <nav class="nav-links" aria-label="Primary navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/#features') }}">Features</a>
                <a href="{{ url('/#report') }}">Report</a>
            </nav>

            <div class="nav-actions">
                <a class="nav-login" href="{{ route('login') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/></svg>
                    Login
                </a>
                <a class="nav-cta" href="{{ route('login', ['login_required' => 1]) }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                    New Complaint
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="shell footer-content">
            <div class="footer-brand">
                <a class="brand" href="{{ url('/') }}" aria-label="FixMyCampus home">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M4 11.5 12 5l8 6.5"/><path d="M6.5 10.5V19h11v-8.5"/><path d="M9 19v-5h6v5"/></svg>
                    </span>
                    <span>FixMyCampus</span>
                </a>
                <p>Campus Complaint & Maintenance Management System for organized, trackable, and transparent issue resolution.</p>
            </div>

            <nav class="footer-nav" aria-label="Footer navigation">
                <a class="footer-link" href="{{ url('/') }}">Home</a>
                <a class="footer-link" href="{{ url('/#features') }}">Features</a>
                <a class="footer-link" href="{{ url('/#report') }}">Report</a>
                <a class="footer-link" href="{{ route('login') }}">Login</a>
                <a class="footer-link primary" href="{{ url('/#report') }}">New complaint</a>
            </nav>
        </div>

        <div class="shell footer-bottom">
            <p>&copy; {{ date('Y') }} FixMyCampus. All rights reserved.</p>
            <p>Campus Complaint & Maintenance Management System</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
