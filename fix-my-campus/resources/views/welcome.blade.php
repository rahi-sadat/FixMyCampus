@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="shell hero-grid">
            <div>
                <div class="eyebrow"><span class="pulse" aria-hidden="true"></span> Campus maintenance, tracked end to end</div>
                <h1>FixMyCampus</h1>
                <p class="hero-copy">
                    A focused complaint and maintenance system where students report campus issues, Authority assign work, and maintenance staff close the loop with visible progress.
                </p>

                <div class="hero-actions">
                    <a class="button primary" href="{{ route('login', ['login_required' => 1]) }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                        Submit a complaint
                    </a>
                </div>

                <div class="trust-row" aria-label="Project highlights">
                    <div class="trust-item">
                        <strong>24/7</strong>
                        <span>Students can report campus issues anytime.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="section soft">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Key features</div>
                    <h2>Built for reliable campus operations.</h2>
                </div>
            </div>

            <div class="feature-grid">
                <article class="feature-card">
                    <span class="icon-box blue">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/></svg>
                    </span>
                    <h3>Secure access</h3>
                    <p>Student, Authority, and Staff securely login with protected dashboards.</p>
                </article>

                <article class="feature-card">
                    <span class="icon-box">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>
                    </span>
                    <h3>Complaint tracking</h3>
                    <p>Category, location, priority, image, status, creation date, and update date in one record.</p>
                </article>

                <article class="feature-card">
                    <span class="icon-box amber">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 3h5v5"/><path d="M21 3 14 10"/><path d="M8 21H3v-5"/><path d="M3 21l7-7"/><path d="M21 16v5h-5"/><path d="m14 14 7 7"/><path d="M3 8V3h5"/><path d="m3 3 7 7"/></svg>
                    </span>
                    <h3>Staff assignment</h3>
                    <p>Authority assigns each complaint to the right maintenance staff member and monitor progress.</p>
                </article>

                <article class="feature-card">
                    <span class="icon-box coral">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    </span>
                    <h3>Progress notes</h3>
                    <p>Staff can add updates that explain what changed, when it changed, and what remains.</p>
                </article>

                <article class="feature-card">
                    <span class="icon-box blue">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 17 5 3-1.5-5.5L20 11h-5.5L12 6l-2.5 5H4l4.5 3.5L7 20Z"/></svg>
                    </span>
                    <h3>Feedback</h3>
                    <p>Students can rate and comment after resolution.</p>
                </article>

                <article class="feature-card">
                    <span class="icon-box">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 15v2"/><path d="M12 9v8"/><path d="M17 5v12"/></svg>
                    </span>
                    <h3>Reports</h3>
                    <p>Track total, pending, in-progress, resolved, and category-wise complaint summaries.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="report" class="section">
        <div class="shell report-band">
            <div class="report-copy">
                <div class="section-kicker">File a report</div>
                <h2>Report campus issues with the details maintenance teams need.</h2>
                <ul class="report-list">
                    <li><span class="check" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12 4 4 10-10"/></svg></span><span>Capture category, location, priority, and description.</span></li>
                    <li><span class="check" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12 4 4 10-10"/></svg></span><span>Support photos for classroom, lab, residential hall, Wi-Fi, electricity, water, and cleaning issues.</span></li>
                    <li><span class="check" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12 4 4 10-10"/></svg></span><span>Keep status history visible for students, authority, and staff.</span></li>
                </ul>
            </div>

            <form class="report-form" action="{{ route('login') }}" method="get" data-login-required-form data-login-required-url="{{ route('login', ['login_required' => 1]) }}">
                <input type="hidden" name="login_required" value="1">

                <div class="form-grid">
                    <div class="field">
                        <label for="category">Category</label>
                        <select id="category" class="select" name="category">
                            <option>Wi-Fi</option>
                            <option>Electricity</option>
                            <option>Water</option>
                            <option>Cleaning</option>
                            <option>Classroom</option>
                            <option>Lab</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="priority">Priority</label>
                        <select id="priority" class="select" name="priority">
                            <option>Medium</option>
                            <option>High</option>
                            <option>Low</option>
                        </select>
                    </div>

                    <div class="field full">
                        <label for="location">Location</label>
                        <input id="location" class="input" name="location" type="text" value="CSE lab, second floor">
                    </div>

                    <div class="field full">
                        <label for="description">Description</label>
                        <textarea id="description" class="textarea" name="description">Internet connection drops during scheduled lab classes and affects student work.</textarea>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="button primary" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2 11 13"/><path d="m22 2-7 20-4-9-9-4Z"/></svg>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.querySelector('[data-login-required-form]')?.addEventListener('submit', function (event) {
            event.preventDefault();
            window.location.href = this.dataset.loginRequiredUrl;
        });
    </script>
@endpush
