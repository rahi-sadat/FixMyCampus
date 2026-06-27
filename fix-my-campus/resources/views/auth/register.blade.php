@extends('layouts.app')

@section('title', 'Register | FixMyCampus')

@section('content')
    <section class="auth-section">
        <div class="shell auth-shell">
            <div class="auth-copy">
                <div class="section-kicker">Account access</div>
                <h1>Create your FixMyCampus account</h1>
                <p>Register to submit complaints and track campus maintenance progress from your dashboard.</p>
            </div>

            <form class="auth-card" action="{{ route('register.store') }}" method="post">
                @csrf

                <div class="auth-card-head">
                    <h2>Register Now</h2>
                    <p>Enter your details to create your student account.</p>
                </div>

                @if (session('registration_status'))
                    <p class="auth-notice">{{ session('registration_status') }}</p>
                @endif

                @if ($errors->any())
                    <p class="auth-error">Please check the form and try again.</p>
                @endif

                <div class="form-grid">
                    <div class="field full">
                        <label for="name">Full Name</label>
                        <input id="name" class="input" name="name" type="text" value="{{ old('name') }}" placeholder="Enter your full name" autocomplete="name" required>
                    </div>

                    <div class="field">
                        <label for="roll">Roll</label>
                        <input id="roll" class="input" name="roll" type="text" value="{{ old('roll') }}" placeholder="Enter your roll" required>
                    </div>

                    <div class="field">
                        <label for="batch">Batch</label>
                        <input id="batch" class="input" name="batch" type="text" value="{{ old('batch') }}" placeholder="Enter your batch" required>
                    </div>

                    <div class="field full">
                        <label for="email">Email</label>
                        <input id="email" class="input" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                    </div>

                    <div class="field full">
                        <label for="password">Password</label>
                        <input id="password" class="input" name="password" type="password" placeholder="Create a password" autocomplete="new-password" required>
                    </div>

                    <div class="field full">
                        <label for="password_confirmation">Retype Password</label>
                        <input id="password_confirmation" class="input" name="password_confirmation" type="password" placeholder="Retype your password" autocomplete="new-password" required>
                    </div>
                </div>

                <button class="button primary auth-submit" type="submit">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/></svg>
                    Register
                </button>

                <div class="auth-switch">
                    <span>Already have an account?</span>
                    <a class="auth-register-link" href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </section>
@endsection
