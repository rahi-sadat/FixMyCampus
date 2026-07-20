@extends('layouts.app')

@section('title', 'Complaints | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head compact">
                <div>
                    <div class="section-kicker">Complaints</div>
                    <h1>Complaint register</h1>
                    <p>Track reported issues with category, location, priority, staff, and current status.</p>
                </div>
                @if (auth()->user()->isRole('student'))
                    <a class="button primary" href="{{ route('complaints.create') }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                        New complaint
                    </a>
                @endif
            </div>

            @include('partials.flash')

            <section class="panel">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Issue</th>
                                <th>Location</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Staff</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $complaint)
                                <tr>
                                    <td><a href="{{ route('complaints.show', $complaint) }}">{{ $complaint->complaint_no }}</a></td>
                                    <td>
                                        <strong>{{ $complaint->title }}</strong>
                                        <span>{{ $complaint->category->category_name }} · {{ optional($complaint->submitted_at)->format('M d, Y') }}</span>
                                    </td>
                                    <td>{{ $complaint->location->label() }}</td>
                                    <td><span class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</span></td>
                                    <td><span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span></td>
                                    <td>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-cell">No complaints found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrap">
                    {{ $complaints->links() }}
                </div>
            </section>
        </div>
    </section>
@endsection
