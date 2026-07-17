@extends('layouts.app')

@section('title', 'Complaint Assignments | FixMyCampus')

@section('content')
    <section class="app-page"><div class="shell">
        <div class="page-head"><div><div class="section-kicker">Assignment</div><h1>Assign active complaints</h1></div></div>
        <section class="panel"><div class="table-wrap"><table class="data-table">
            <thead><tr><th>No.</th><th>Issue</th><th>Status</th><th>Current staff</th><th></th></tr></thead>
            <tbody>@forelse ($complaints as $complaint)<tr><td>{{ $complaint->complaint_no }}</td><td>{{ $complaint->title }}</td><td><span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span></td><td>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</td><td><a class="button secondary compact" href="{{ route('admin.assignments.edit', $complaint) }}">Assign</a></td></tr>@empty<tr><td colspan="5" class="empty-cell">No active complaints.</td></tr>@endforelse</tbody>
        </table></div><div class="pagination-wrap">{{ $complaints->links() }}</div></section>
    </div></section>
@endsection
