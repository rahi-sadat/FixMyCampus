@extends('layouts.app')

@section('title', $complaint->complaint_no.' | Staff Workflow')

@section('content')
    <section class="app-page"><div class="shell">
        <div class="page-head compact"><div><div class="section-kicker">{{ $complaint->complaint_no }}</div><h1>{{ $complaint->title }}</h1><p>{{ $complaint->location->label() }}</p></div><a class="button secondary" href="{{ route('staff.complaints.index') }}">Back</a></div>
        @include('partials.flash')
        <div class="detail-grid">
            <section class="panel panel-large">
                <div class="detail-summary"><div><span>Status</span><strong class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</strong></div><div><span>Priority</span><strong class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</strong></div><div><span>Student</span><strong>{{ $complaint->student->name }}</strong></div></div>
                <div class="content-block"><h2>Description</h2><p>{{ $complaint->description }}</p></div>
                <div class="content-block"><h2>Progress history</h2><div class="timeline">@forelse ($complaint->progressNotes->sortByDesc('created_at') as $note)<article class="timeline-item"><span>{{ $note->created_at->format('M d, Y g:i A') }}</span><strong>{{ ucfirst($note->progress_status) }}</strong><p>{{ $note->note }}</p></article>@empty<p class="empty-state">No progress notes.</p>@endforelse</div></div>
            </section>
            <aside class="action-stack">
                @unless (in_array($complaint->status, ['resolved', 'closed', 'rejected'], true))
                    <form class="panel" action="{{ route('staff.complaints.progress', $complaint) }}" method="post">@csrf
                        <h2>Update progress</h2>
                        <div class="field"><label for="progress_status">Progress</label><select id="progress_status" class="select" name="progress_status" required>@foreach (['checking','working','waiting','completed'] as $status)<option value="{{ $status }}">{{ ucfirst($status) }}</option>@endforeach</select></div>
                        <div class="field"><label for="note">Note</label><textarea id="note" class="textarea staff-workflow-note" name="note" required></textarea></div>
                        <button class="button primary" type="submit">Save progress</button>
                    </form>
                @endunless
                <form class="panel" action="{{ route('complaints.images.store', $complaint) }}" method="post" enctype="multipart/form-data">@csrf<h2>Add repair evidence</h2><div class="field"><input class="input file-input" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple required></div><button class="button primary" type="submit">Upload</button></form>
            </aside>
        </div>
    </div></section>
@endsection
