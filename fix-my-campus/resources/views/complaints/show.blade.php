@extends('layouts.app')

@section('title', $complaint->complaint_no . ' | FixMyCampus')

@section('content')
    <section class="app-page">
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
                        <div>
                            <span>Status</span>
                            <strong class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</strong>
                        </div>
                        <div>
                            <span>Priority</span>
                            <strong class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</strong>
                        </div>
                        <div>
                            <span>Submitted</span>
                            <strong>{{ optional($complaint->submitted_at)->format('M d, Y') ?? $complaint->created_at->format('M d, Y') }}</strong>
                        </div>
                        <div>
                            <span>Assigned staff</span>
                            <strong>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</strong>
                        </div>
                    </div>

                    <div class="content-block">
                        <h2>Description</h2>
                        <p>{{ $complaint->description }}</p>
                    </div>

                    <div class="content-block">
                        <h2>Image attachments</h2>
                        @if ($complaint->images->isNotEmpty())
                            <div class="attachment-grid">
                                @foreach ($complaint->images->sortByDesc('created_at') as $image)
                                    <a class="attachment-card" href="{{ asset('storage/'.$image->image_path) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('storage/'.$image->image_path) }}" alt="{{ $image->image_name ?? 'Complaint image' }}">
                                        <span>{{ $image->image_name ?? 'Complaint image' }}</span>
                                        <small>Uploaded by {{ $image->uploader->name ?? 'Unknown' }} · {{ $image->created_at->format('M d, Y') }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="empty-state">No image attachments yet.</p>
                        @endif
                    </div>

                    <div class="content-block">
                        <h2>Progress notes</h2>
                        <div class="timeline">
                            @forelse ($complaint->progressNotes->sortByDesc('created_at') as $note)
                                <article class="timeline-item">
                                    <span>{{ ucwords(str_replace('_', ' ', $note->progress_status)) }} · {{ $note->created_at->format('M d, Y g:i A') }}</span>
                                    <strong>{{ $note->staff->name }}</strong>
                                    <p>{{ $note->note }}</p>
                                </article>
                            @empty
                                <p class="empty-state">No staff progress notes yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="content-block">
                        <h2>Status history</h2>
                        <div class="timeline">
                            @forelse ($complaint->statusLogs->sortByDesc('created_at') as $log)
                                <article class="timeline-item">
                                    <span>{{ optional($log->created_at)->format('M d, Y g:i A') }}</span>
                                    <strong>{{ ucwords(str_replace('_', ' ', $log->old_status ?: 'new')) }} to {{ ucwords(str_replace('_', ' ', $log->new_status)) }}</strong>
                                    <p>{{ $log->remarks }} @if ($log->user) · {{ $log->user->name }} @endif</p>
                                </article>
                            @empty
                                <p class="empty-state">No status changes recorded.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <aside class="action-stack">
                    @if (auth()->user()->isRole('admin') || (auth()->user()->isRole('student') && $complaint->student_id === auth()->id()) || (auth()->user()->isRole('staff') && $complaint->current_staff_id === auth()->id()))
                        <form class="panel" action="{{ route('complaints.images.store', $complaint) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="panel-head">
                                <div>
                                    <h2>Attach images</h2>
                                    <p>Add photos that document the issue or repair result.</p>
                                </div>
                            </div>
                            <div class="field">
                                <label for="detail-images">Images</label>
                                <input id="detail-images" class="input file-input" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple required>
                                <p class="field-hint">Up to 5 images, 4 MB each.</p>
                            </div>
                            <button class="button primary auth-submit" type="submit">Upload images</button>
                        </form>
                    @endif

                    @if (auth()->user()->isRole('admin'))
                        <form class="panel" action="{{ route('complaints.assign', $complaint) }}" method="post">
                            @csrf
                            <div class="panel-head">
                                <div>
                                    <h2>Assign staff</h2>
                                    <p>Route this complaint to maintenance.</p>
                                </div>
                            </div>
                            <div class="field">
                                <label for="assigned_to">Staff member</label>
                                <select id="assigned_to" class="select" name="assigned_to" required>
                                    <option value="">Choose staff</option>
                                    @foreach ($staff as $member)
                                        <option value="{{ $member->id }}" @selected($complaint->current_staff_id === $member->id)>{{ $member->name }} · {{ $member->department ?? 'Maintenance' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="assignment_note">Assignment note</label>
                                <textarea id="assignment_note" class="textarea" name="assignment_note" placeholder="Inspection instructions or priority context."></textarea>
                            </div>
                            <button class="button primary auth-submit" type="submit">Assign complaint</button>
                        </form>

                        <form class="panel" action="{{ route('complaints.status', $complaint) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="panel-head">
                                <div>
                                    <h2>Update status</h2>
                                    <p>Use this for review, rejection, or final closure.</p>
                                </div>
                            </div>
                            <div class="field">
                                <label for="status">Status</label>
                                <select id="status" class="select" name="status" required>
                                    @foreach (['pending', 'assigned', 'in_progress', 'resolved', 'rejected', 'closed'] as $status)
                                        <option value="{{ $status }}" @selected($complaint->status === $status)>{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="remarks">Remarks</label>
                                <textarea id="remarks" class="textarea" name="remarks" placeholder="Explain the status change."></textarea>
                            </div>
                            <button class="button primary auth-submit" type="submit">Save status</button>
                        </form>

                        <form class="panel danger-panel" action="{{ route('complaints.destroy', $complaint) }}" method="post" onsubmit="return confirm('Delete complaint {{ $complaint->complaint_no }}? This cannot be undone.');">
                            @csrf
                            @method('delete')
                            <div class="panel-head">
                                <div>
                                    <h2>Delete complaint</h2>
                                    <p>Remove this complaint and its related progress, feedback, and images.</p>
                                </div>
                            </div>
                            <button class="button danger auth-submit" type="submit">Delete complaint</button>
                        </form>
                    @endif

                    @if (auth()->user()->isRole('staff'))
                        <form class="panel" action="{{ route('complaints.progress', $complaint) }}" method="post">
                            @csrf
                            <div class="panel-head">
                                <div>
                                    <h2>Add progress</h2>
                                    <p>Keep the student and authority updated.</p>
                                </div>
                            </div>
                            <div class="field">
                                <label for="progress_status">Progress</label>
                                <select id="progress_status" class="select" name="progress_status" required>
                                    @foreach (['checking', 'working', 'waiting', 'completed'] as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="note">Note</label>
                                <textarea id="note" class="textarea" name="note" placeholder="What changed? What remains?" required></textarea>
                            </div>
                            <button class="button primary auth-submit" type="submit">Save progress</button>
                        </form>
                    @endif

                    @if (auth()->user()->isRole('student') && $complaint->isResolved())
                        <form class="panel" action="{{ route('complaints.feedback', $complaint) }}" method="post">
                            @csrf
                            <div class="panel-head">
                                <div>
                                    <h2>Feedback</h2>
                                    <p>Rate the resolution quality.</p>
                                </div>
                            </div>
                            <div class="field">
                                <label for="rating">Rating</label>
                                <select id="rating" class="select" name="rating" required>
                                    @for ($rating = 5; $rating >= 1; $rating--)
                                        <option value="{{ $rating }}" @selected(optional($complaint->feedback)->rating === $rating)>{{ $rating }} out of 5</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="field">
                                <label for="comment">Comment</label>
                                <textarea id="comment" class="textarea" name="comment" placeholder="Share anything the team should know.">{{ optional($complaint->feedback)->comment }}</textarea>
                            </div>
                            <button class="button primary auth-submit" type="submit">Submit feedback</button>
                        </form>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection
