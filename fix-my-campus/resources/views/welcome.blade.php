<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FixMyCampus is a campus complaint and maintenance management system for students, admins, and maintenance staff.">

    <title>FixMyCampus | Campus Complaint & Maintenance</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --ink: #17202a;
            --muted: #667085;
            --line: #dfe5ec;
            --soft: #f4f7fb;
            --white: #ffffff;
            --teal: #0f766e;
            --teal-dark: #0b4f4a;
            --mint: #d7f4ec;
            --amber: #f59e0b;
            --coral: #e85d4f;
            --blue: #2563eb;
            --shadow: 0 24px 70px rgba(23, 32, 42, .14);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--ink);
            background:
                linear-gradient(180deg, rgba(215, 244, 236, .42) 0%, rgba(244, 247, 251, 0) 34%),
                var(--white);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        .shell {
            width: min(1160px, calc(100% - 40px));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            border-bottom: 1px solid rgba(223, 229, 236, .78);
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(18px);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 0;
        }

        .brand-mark {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            border-radius: 8px;
            color: var(--white);
            background: linear-gradient(135deg, var(--teal), var(--blue));
            box-shadow: 0 12px 24px rgba(15, 118, 110, .24);
        }

        .brand-mark svg,
        .nav-cta svg,
        .nav-login svg,
        .button svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            color: #465364;
            font-size: .95rem;
            font-weight: 650;
        }

        .nav-links a {
            transition: color .2s ease;
        }

        .nav-links a:hover {
            color: var(--teal);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-cta,
        .nav-login,
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            border-radius: 8px;
            font-weight: 800;
            gap: 9px;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, background .2s ease;
        }

        .nav-cta {
            padding: 0 16px;
            color: var(--white);
            background: var(--teal);
            box-shadow: 0 14px 28px rgba(15, 118, 110, .22);
        }

        .nav-login {
            padding: 0 15px;
            color: var(--ink);
            border: 1px solid var(--line);
            background: var(--white);
        }

        .nav-login:hover {
            color: var(--white);
            border-color: var(--teal);
            background: var(--teal);
            box-shadow: 0 14px 28px rgba(15, 118, 110, .18);
        }

        .nav-cta:hover,
        .nav-login:hover,
        .button:hover {
            transform: translateY(-1px);
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 72px 0 56px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 720px);
            align-items: center;
            gap: 46px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: fit-content;
            border: 1px solid rgba(15, 118, 110, .2);
            border-radius: 999px;
            padding: 8px 12px;
            color: var(--teal-dark);
            background: rgba(215, 244, 236, .72);
            font-size: .83rem;
            font-weight: 800;
        }

        .pulse {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--coral);
            box-shadow: 0 0 0 6px rgba(232, 93, 79, .13);
        }

        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        h1 {
            max-width: 720px;
            margin-top: 22px;
            font-size: clamp(3rem, 7vw, 5.8rem);
            line-height: .94;
            letter-spacing: 0;
        }

        .hero-copy {
            max-width: 620px;
            margin-top: 24px;
            color: #506173;
            font-size: 1.1rem;
            line-height: 1.75;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .button {
            border: 1px solid transparent;
            padding: 0 19px;
        }

        .button.primary {
            color: var(--white);
            border-color: var(--ink);
            background: var(--ink);
            box-shadow: 0 18px 36px rgba(23, 32, 42, .2);
        }

        .button.primary:hover {
            color: var(--white);
            border-color: var(--teal);
            background: var(--teal);
            box-shadow: 0 18px 40px rgba(15, 118, 110, .28);
        }

        .button.secondary {
            color: var(--ink);
            border-color: var(--line);
            background: var(--white);
        }

        .button.secondary:hover {
            border-color: rgba(15, 118, 110, .35);
            box-shadow: 0 14px 30px rgba(23, 32, 42, .08);
        }

        .trust-row {
            display: grid;
            grid-template-columns: minmax(180px, 260px);
            gap: 18px;
            max-width: 620px;
            margin-top: 38px;
        }

        .trust-item {
            padding: 0 0 0 16px;
            border-left: 3px solid var(--line);
        }

        .trust-item strong {
            display: block;
            font-size: 1.35rem;
            line-height: 1.1;
        }

        .trust-item span {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: .86rem;
            line-height: 1.35;
        }

        .report-form,
        .feature-card {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--white);
        }

        .section {
            padding: 76px 0;
        }

        .section.soft {
            background: var(--soft);
        }

        .section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 32px;
            margin-bottom: 30px;
        }

        .section-kicker {
            color: var(--teal);
            font-size: .78rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .section-head h2 {
            max-width: 680px;
            margin-top: 9px;
            font-size: clamp(2rem, 4vw, 3.1rem);
            line-height: 1.04;
            letter-spacing: 0;
        }

        .section-head p {
            max-width: 390px;
            color: var(--muted);
            line-height: 1.65;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .feature-card {
            padding: 22px;
        }

        .feature-card h3 {
            margin-top: 18px;
            font-size: 1.15rem;
            line-height: 1.25;
        }

        .feature-card p {
            margin-top: 10px;
            color: var(--muted);
            line-height: 1.62;
        }

        .icon-box {
            display: grid;
            width: 46px;
            height: 46px;
            place-items: center;
            border-radius: 8px;
            color: var(--teal-dark);
            background: var(--mint);
        }

        .icon-box.amber {
            color: #8a5400;
            background: #fef0c7;
        }

        .icon-box.coral {
            color: #a3372e;
            background: #ffe4e0;
        }

        .icon-box.blue {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .icon-box svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .report-band {
            display: grid;
            grid-template-columns: .88fr 1.12fr;
            gap: 34px;
            align-items: center;
        }

        .report-copy h2 {
            font-size: clamp(2rem, 4vw, 3.3rem);
            line-height: 1.03;
            letter-spacing: 0;
        }

        .report-copy p {
            max-width: 520px;
            margin-top: 18px;
            color: var(--muted);
            line-height: 1.7;
        }

        .report-list {
            display: grid;
            gap: 12px;
            margin-top: 28px;
        }

        .report-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #334155;
            line-height: 1.5;
        }

        .check {
            display: grid;
            width: 22px;
            height: 22px;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 999px;
            color: var(--white);
            background: var(--teal);
            font-size: .82rem;
            font-weight: 900;
        }

        .check svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .report-form {
            padding: 22px;
            box-shadow: 0 18px 50px rgba(23, 32, 42, .08);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field {
            display: grid;
            gap: 7px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            color: #445367;
            font-size: .78rem;
            font-weight: 850;
        }

        .input,
        .textarea,
        .select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 12px 13px;
            color: #263241;
            background: #fbfdff;
            outline: none;
        }

        .textarea {
            min-height: 116px;
            resize: vertical;
        }

        .input:focus,
        .textarea:focus,
        .select:focus {
            border-color: rgba(15, 118, 110, .55);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, .1);
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-top: 16px;
        }

        .form-footer span {
            color: var(--muted);
            font-size: .82rem;
            line-height: 1.35;
        }

        .site-footer {
            padding: 44px 0;
            border-top: 1px solid #111827;
            background: #05070a;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 28px;
            color: #cbd5e1;
            font-size: .9rem;
        }

        .footer-brand p {
            max-width: 440px;
            margin-top: 12px;
            color: #94a3b8;
            line-height: 1.6;
        }

        .site-footer .brand {
            color: var(--white);
        }

        .footer-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
        }

        .footer-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            border: 1px solid #263241;
            border-radius: 8px;
            padding: 0 14px;
            color: #e2e8f0;
            background: #111827;
            font-weight: 800;
            transition: transform .2s ease, border-color .2s ease, background .2s ease, color .2s ease;
        }

        .footer-link:hover {
            transform: translateY(-1px);
            color: var(--white);
            border-color: var(--teal);
            background: var(--teal);
        }

        .footer-link.primary {
            color: var(--white);
            border-color: var(--teal);
            background: var(--teal);
        }

        .footer-link.primary:hover {
            border-color: #14b8a6;
            background: #14b8a6;
        }

        @media (max-width: 980px) {
            .hero-grid,
            .report-band {
                grid-template-columns: 1fr;
            }

            .feature-grid {
                grid-template-columns: 1fr 1fr;
            }

            .section-head {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 760px) {
            .shell {
                width: min(100% - 28px, 1160px);
            }

            .nav {
                min-height: 68px;
            }

            .nav-links {
                display: none;
            }

            .hero {
                padding: 48px 0 40px;
            }

            h1 {
                font-size: clamp(2.55rem, 15vw, 4.4rem);
            }

            .hero-copy {
                font-size: 1rem;
            }

            .trust-row,
            .feature-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 58px 0;
            }

            .form-footer,
            .footer-content {
                align-items: flex-start;
                grid-template-columns: 1fr;
            }

            .footer-nav {
                justify-content: flex-start;
            }
        }

        @media (max-width: 460px) {
            .brand span {
                display: none;
            }

            .nav-cta {
                padding: 0 12px;
                font-size: .9rem;
            }

            .nav-login {
                padding: 0 11px;
                font-size: .9rem;
            }

            .hero-actions .button {
                width: 100%;
            }

        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="shell nav">
            <a class="brand" href="#" aria-label="FixMyCampus home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M4 11.5 12 5l8 6.5"/><path d="M6.5 10.5V19h11v-8.5"/><path d="M9 19v-5h6v5"/></svg>
                </span>
                <span>FixMyCampus</span>
            </a>

            <nav class="nav-links" aria-label="Primary navigation">
                <a href="#">Home</a>
                <a href="#features">Features</a>
                <a href="#report">Report</a>
            </nav>

            <div class="nav-actions">
                <a class="nav-login" href="#">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/></svg>
                    Login
                </a>
                <a class="nav-cta" href="#report">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                    New complaint
                </a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="shell hero-grid">
                <div>
                    <div class="eyebrow"><span class="pulse" aria-hidden="true"></span> Campus maintenance, tracked end to end</div>
                    <h1>FixMyCampus</h1>
                    <p class="hero-copy">
                        A focused complaint and maintenance system where students report campus issues, Authority assign work, and maintenance staff close the loop with visible progress.
                    </p>

                    <div class="hero-actions">
                        <a class="button primary" href="#report">
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
                        <li><span class="check" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12 4 4 10-10"/></svg></span><span>Support photos for classroom, lab, hostel, Wi-Fi, electricity, water, and cleaning issues.</span></li>
                        <li><span class="check" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12 4 4 10-10"/></svg></span><span>Keep status history visible for students, admins, and staff.</span></li>
                    </ul>
                </div>

                <form class="report-form" action="#" method="post">
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
                        <button class="button primary" type="button">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2 11 13"/><path d="m22 2-7 20-4-9-9-4Z"/></svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="shell footer-content">
            <div class="footer-brand">
                <a class="brand" href="#" aria-label="FixMyCampus home">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M4 11.5 12 5l8 6.5"/><path d="M6.5 10.5V19h11v-8.5"/><path d="M9 19v-5h6v5"/></svg>
                    </span>
                    <span>FixMyCampus</span>
                </a>
                <p>Campus Complaint & Maintenance Management System for organized, trackable, and transparent issue resolution.</p>
            </div>

            <nav class="footer-nav" aria-label="Footer navigation">
                <a class="footer-link" href="#">Home</a>
                <a class="footer-link" href="#features">Features</a>
                <a class="footer-link" href="#report">Report</a>
                <a class="footer-link" href="#">Login</a>
                <a class="footer-link primary" href="#report">New complaint</a>
            </nav>
        </div>
    </footer>
</body>
</html>
