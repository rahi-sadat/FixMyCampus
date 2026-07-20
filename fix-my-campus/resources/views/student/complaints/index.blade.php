@extends('layouts.app')

@section('title', 'My Complaints | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head compact tracking-toolbar">
                <div>
                    <div class="section-kicker">My complaints</div>
                    <h1>Track submitted issues</h1>
                    <p>Follow each complaint from submission through resolution.</p>
                </div>
                <a class="button primary" href="{{ route('complaints.create') }}">New complaint</a>
            </div>

            @include('partials.flash')

            <section class="panel">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead><tr><th>No.</th><th>Issue</th><th>Location</th><th>Priority</th><th>Status</th><th>Staff</th></tr></thead>
                        <tbody>
                            @forelse ($complaints as $complaint)
                                <tr>
                                    <td><a href="{{ route('complaints.show', $complaint) }}">{{ $complaint->complaint_no }}</a></td>
                                    <td><strong>{{ $complaint->title }}</strong><span>{{ $complaint->category->category_name }}</span></td>
                                    <td>{{ $complaint->location->label() }}</td>
                                    <td><span class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</span></td>
                                    <td><span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span></td>
                                    <td>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="empty-cell">No complaints submitted yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrap">{{ $complaints->links() }}</div>
            </section>
        </div>
    </section>
@endsection
