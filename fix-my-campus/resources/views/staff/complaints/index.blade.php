@extends('layouts.app')

@section('title', 'My Assignments | FixMyCampus')

@section('content')
    <section class="app-page"><div class="shell">
        <div class="page-head"><div><div class="section-kicker">Staff workflow</div><h1>My assigned complaints</h1></div></div>
        <section class="panel"><div class="table-wrap"><table class="data-table">
            <thead><tr><th>No.</th><th>Issue</th><th>Student</th><th>Priority</th><th>Status</th></tr></thead>
            <tbody>@forelse ($complaints as $complaint)<tr><td><a href="{{ route('staff.complaints.show', $complaint) }}">{{ $complaint->complaint_no }}</a></td><td>{{ $complaint->title }}</td><td>{{ $complaint->student->name }}</td><td><span class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</span></td><td><span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span></td></tr>@empty<tr><td colspan="5" class="empty-cell">No assigned work.</td></tr>@endforelse</tbody>
        </table></div><div class="pagination-wrap">{{ $complaints->links() }}</div></section>
    </div></section>
@endsection
