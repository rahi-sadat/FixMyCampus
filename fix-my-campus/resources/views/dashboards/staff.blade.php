@extends('layouts.app')

@section('title', 'Staff Dashboard | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head">
                <div>
                    <div class="section-kicker">Staff dashboard</div>
                    <h1>Assigned maintenance work</h1>
                    <p>Update progress, record blockers, and mark completed work when it is ready for student review.</p>
                </div>
                <a class="button secondary" href="{{ route('staff.complaints.index') }}">My assignments</a>
            </div>

            @include('partials.flash')

            <div class="metric-grid three">
                <article class="metric-card">
                    <span>Assigned to me</span>
                    <strong>{{ $complaints->count() }}</strong>
                </article>
                <article class="metric-card">
                    <span>Open work</span>
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
                        <h2>Work queue</h2>
                        <p>Prioritized list of assigned complaints.</p>
                    </div>
                </div>

                <div class="complaint-list">
                    @forelse ($complaints as $complaint)
                        <a class="complaint-row" href="{{ route('staff.complaints.show', $complaint) }}">
                            <div>
                                <span class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</span>
                                <strong>{{ $complaint->title }}</strong>
                                <p>{{ $complaint->category->category_name }} · {{ $complaint->location->label() }}</p>
                            </div>
                            <span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span>
                        </a>
                    @empty
                        <p class="empty-state">No assigned work yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </section>
@endsection
