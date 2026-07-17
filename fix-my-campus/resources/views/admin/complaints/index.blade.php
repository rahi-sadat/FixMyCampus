@extends('layouts.app')

@section('title', 'Complaint Review | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head"><div><div class="section-kicker">Authority review</div><h1>Incoming complaints</h1><p>Search and filter the complete complaint register.</p></div></div>
            @include('partials.flash')

            <form class="panel complaint-filters" method="get" action="{{ route('admin.complaints.index') }}">
                <div class="field"><label for="search">Search</label><input id="search" class="input" name="search" value="{{ request('search') }}"></div>
                <div class="field"><label for="status">Status</label><select id="status" class="select" name="status"><option value="">All</option>@foreach (['pending','assigned','in_progress','resolved','rejected','closed'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucwords(str_replace('_', ' ', $status)) }}</option>@endforeach</select></div>
                <div class="field"><label for="priority">Priority</label><select id="priority" class="select" name="priority"><option value="">All</option>@foreach (['low','medium','high','urgent'] as $priority)<option value="{{ $priority }}" @selected(request('priority') === $priority)>{{ ucfirst($priority) }}</option>@endforeach</select></div>
                <div class="field"><label for="category_id">Category</label><select id="category_id" class="select" name="category_id"><option value="">All</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->category_name }}</option>@endforeach</select></div>
                <button class="button primary" type="submit">Filter</button>
            </form>

            <section class="panel">
                <div class="table-wrap"><table class="data-table">
                    <thead><tr><th>No.</th><th>Issue</th><th>Student</th><th>Priority</th><th>Status</th><th>Staff</th></tr></thead>
                    <tbody>@forelse ($complaints as $complaint)<tr>
                        <td><a href="{{ route('admin.complaints.show', $complaint) }}">{{ $complaint->complaint_no }}</a></td>
                        <td><strong>{{ $complaint->title }}</strong><span>{{ $complaint->category->category_name }}</span></td>
                        <td>{{ $complaint->student->name }}</td>
                        <td><span class="status-badge {{ $complaint->priority }}">{{ ucfirst($complaint->priority) }}</span></td>
                        <td><span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span></td>
                        <td>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</td>
                    </tr>@empty<tr><td colspan="6" class="empty-cell">No matching complaints.</td></tr>@endforelse</tbody>
                </table></div>
                <div class="pagination-wrap">{{ $complaints->links() }}</div>
            </section>
        </div>
    </section>
@endsection
