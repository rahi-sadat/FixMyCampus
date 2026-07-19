@extends('layouts.app')

@section('title', $complaint->complaint_no.' | FixMyCampus')

@section('content')
    <section class="app-page tracking-detail">
        <div class="shell">
            <div class="page-head compact">
                <div>
                    <div class="section-kicker">{{ $complaint->complaint_no }}</div>
                    <h1>{{ $complaint->title }}</h1>
                    <p>{{ $complaint->category->category_name }} · {{ $complaint->location->label() }}</p>
                </div>
                <a class="button secondary" href="{{ route('complaints.index') }}">Back to complaints</a>
            </div>

            @include('partials.flash')

            <div class="detail-grid">
                <section class="panel panel-large">
                    <div class="detail-summary">
                        <div><span>Status</span><strong class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</strong></div>
                        <div><span>Priority</span><strong class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</strong></div>
                        <div><span>Submitted</span><strong>{{ optional($complaint->submitted_at)->format('M d, Y') }}</strong></div>
                        <div><span>Assigned staff</span><strong>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</strong></div>
                    </div>

                    <div class="content-block"><h2>Description</h2><p>{{ $complaint->description }}</p></div>

                    <div class="content-block">
                        <h2>Image attachments</h2>
                        <div class="attachment-grid">
                            @forelse ($complaint->images->sortByDesc('created_at') as $image)
                                <a class="attachment-card" href="{{ asset('storage/'.$image->image_path) }}" target="_blank" rel="noopener">
                                    <img src="{{ asset('storage/'.$image->image_path) }}" alt="{{ $image->image_name ?? 'Complaint image' }}">
                                    <span>{{ $image->image_name ?? 'Complaint image' }}</span>
                                </a>
                            @empty
                                <p class="empty-state">No image attachments yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="content-block">
                        <h2>Progress notes</h2>
                        <div class="timeline">
                            @forelse ($complaint->progressNotes->sortByDesc('created_at') as $note)
                                <article class="timeline-item"><span>{{ $note->created_at->format('M d, Y g:i A') }}</span><strong>{{ ucfirst($note->progress_status) }}</strong><p>{{ $note->note }}</p></article>
                            @empty
                                <p class="empty-state">No staff progress notes yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="content-block">
                        <h2>Status history</h2>
                        <div class="timeline">
                            @forelse ($complaint->statusLogs->sortByDesc('created_at') as $log)
                                <article class="timeline-item"><span>{{ optional($log->created_at)->format('M d, Y g:i A') }}</span><strong>{{ ucwords(str_replace('_', ' ', $log->new_status)) }}</strong><p>{{ $log->remarks }}</p></article>
                            @empty
                                <p class="empty-state">No status changes recorded.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <aside class="action-stack">
                    <form class="panel" action="{{ route('complaints.images.store', $complaint) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h2>Add evidence</h2>
                        <div class="field"><input class="input file-input" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple required></div>
                        <button class="button primary" type="submit">Upload images</button>
                    </form>
                    @include('student.complaints.partials.feedback-form')
                </aside>
            </div>
        </div>
    </section>
@endsection
