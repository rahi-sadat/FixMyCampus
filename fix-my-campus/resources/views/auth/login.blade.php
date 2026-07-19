@extends('layouts.app')

@section('title', 'Login | FixMyCampus')

@section('content')
    <section class="auth-section">
        <div class="shell auth-shell">
            <div class="auth-copy">
                <div class="section-kicker">Account access</div>
                <h1>Login to FixMyCampus</h1>
                <p>Access your dashboard to submit complaints, assign maintenance work, or update progress.</p>
            </div>

            <form class="auth-card" action="{{ route('login.attempt') }}" method="post">
                @csrf

                @if (request()->boolean('login_required'))
                    <p class="auth-notice">You have to login first.</p>
                @endif

                <div class="auth-card-head">
                    <h2>Welcome back</h2>
                    <p>Enter your email and password to continue.</p>
                </div>

                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror

                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" class="input" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" class="input" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>
                </div>

                <button class="button primary auth-submit" type="submit">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/></svg>
                    Login
                </button>

                <div class="auth-switch">
                    <span>Don't have a account?</span>
                    <a class="auth-register-link" href="{{ route('register') }}">Register Now</a>
                </div>
            </form>
        </div>
    </section>
@endsection
