@extends('layouts.app')

@section('title', 'Complaint Reports | FixMyCampus')

@section('content')
    <section class="app-page"><div class="shell">
        <div class="page-head"><div><div class="section-kicker">Reports</div><h1>Complaint overview</h1><p>Existing status, priority and category summaries.</p></div></div>
        <div class="report-summary-grid">
            <article class="metric-card"><span>Total complaints</span><strong>{{ $totalComplaints }}</strong></article>
            <article class="metric-card"><span>Open</span><strong>{{ $statusCounts->get('pending', 0) + $statusCounts->get('assigned', 0) + $statusCounts->get('in_progress', 0) }}</strong></article>
            <article class="metric-card"><span>Resolved</span><strong>{{ $statusCounts->get('resolved', 0) + $statusCounts->get('closed', 0) }}</strong></article>
        </div>
        <div class="dashboard-grid">
            <section class="panel"><div class="panel-head"><div><h2>By priority</h2></div></div><div class="report-bars">@foreach ($priorityCounts as $priority => $count)<div class="report-bar"><span>{{ ucfirst($priority) }}</span><strong>{{ $count }}</strong></div>@endforeach</div></section>
            <section class="panel"><div class="panel-head"><div><h2>By category</h2></div></div><div class="report-bars">@foreach ($categoryCounts as $category)<div class="report-bar"><span>{{ $category->category_name }}</span><strong>{{ $category->complaints_count }}</strong></div>@endforeach</div></section>
        </div>
    </div></section>
@endsection
