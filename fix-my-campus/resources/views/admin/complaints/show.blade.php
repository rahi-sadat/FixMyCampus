@extends('layouts.app')

@section('title', $complaint->complaint_no.' | Authority Review')

@section('content')
    <section class="app-page"><div class="shell">
        <div class="page-head compact">
            <div><div class="section-kicker">{{ $complaint->complaint_no }}</div><h1>{{ $complaint->title }}</h1><p>Submitted by {{ $complaint->student->name }}</p></div>
            <div class="row-actions">
                <a class="button primary" href="{{ route('admin.assignments.edit', $complaint) }}">Assign staff</a>
                <a class="button secondary" href="{{ route('admin.complaints.index') }}">Back</a>
            </div>
        </div>
        @include('partials.flash')
        <div class="detail-grid">
            <section class="panel panel-large">
                <div class="detail-summary">
                    <div><span>Status</span><strong class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</strong></div>
                    <div><span>Priority</span><strong class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</strong></div>
                    <div><span>Location</span><strong>{{ $complaint->location->label() }}</strong></div>
                    <div><span>Staff</span><strong>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</strong></div>
                </div>
                <div class="content-block"><h2>Description</h2><p>{{ $complaint->description }}</p></div>
                <div class="content-block"><h2>Status history</h2><div class="timeline">@forelse ($complaint->statusLogs->sortByDesc('created_at') as $log)<article class="timeline-item"><span>{{ optional($log->created_at)->format('M d, Y g:i A') }}</span><strong>{{ ucwords(str_replace('_', ' ', $log->new_status)) }}</strong><p>{{ $log->remarks }}</p></article>@empty<p class="empty-state">No status history.</p>@endforelse</div></div>
                @if ($complaint->feedback)
                    <div class="content-block"><h2>Student feedback</h2><p><strong>{{ $complaint->feedback->rating }}/5</strong> — {{ $complaint->feedback->comment ?: 'No comment provided.' }}</p></div>
                @endif
            </section>
            <aside class="action-stack">
                <section class="panel"><h2>Assignment history</h2><div class="timeline">@forelse ($complaint->assignments->sortByDesc('assigned_at') as $assignment)<article class="timeline-item"><strong>{{ $assignment->staff->name }}</strong><p>{{ $assignment->assignment_note ?: 'No assignment note.' }}</p></article>@empty<p class="empty-state">Not assigned yet.</p>@endforelse</div></section>
                <form class="panel danger-panel" action="{{ route('admin.complaints.destroy', $complaint) }}" method="post">@csrf @method('delete')<h2>Delete complaint</h2><button class="button danger" type="submit">Delete</button></form>
            </aside>
        </div>
    </div></section>
@endsection
