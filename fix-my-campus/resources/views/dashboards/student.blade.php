@extends('layouts.app')

@section('title', 'Student Dashboard | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head">
                <div>
                    <div class="section-kicker">Student dashboard</div>
                    <h1>My campus complaints</h1>
                    <p>Submit issues, track assignment status, and leave feedback after resolution.</p>
                </div>
                <a class="button primary" href="{{ route('complaints.create') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                    New complaint
                </a>
            </div>

            @include('partials.flash')

            <div class="metric-grid three">
                <article class="metric-card">
                    <span>Total submitted</span>
                    <strong>{{ $complaints->count() }}</strong>
                </article>
                <article class="metric-card">
                    <span>Open</span>
                    <strong>{{ $openCount }}</strong>
                </article>
                <article class="metric-card">
                    <span>Resolved</span>
                    <strong>{{ $resolvedCount }}</strong>
                </article>
            </div>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Recent reports</h2>
                        <p>Every report remains visible from submission to final feedback.</p>
                    </div>
                </div>

                <div class="complaint-list">
                    @forelse ($complaints as $complaint)
                        <a class="complaint-row" href="{{ route('complaints.show', $complaint) }}">
                            <div>
                                <span>{{ $complaint->complaint_no }}</span>
                                <strong>{{ $complaint->title }}</strong>
                                <p>{{ $complaint->category->category_name }} · {{ $complaint->location->label() }}</p>
                            </div>
                            <span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span>
                        </a>
                    @empty
                        <p class="empty-state">No complaints submitted yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </section>
@endsection
