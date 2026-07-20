@extends('layouts.app')

@section('title', 'Authority Dashboard | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head">
                <div>
                    <div class="section-kicker">Authority dashboard</div>
                    <h1>Campus maintenance overview</h1>
                    <p>Review incoming issues, assign staff, and monitor resolution performance.</p>
                </div>
                <div class="row-actions">
                    <a class="button secondary" href="{{ route('admin.complaints.index') }}">View all complaints</a>
                    <a class="button secondary" href="{{ route('admin.reports.index') }}">Reports</a>
                </div>
            </div>

            @include('partials.flash')

            <div class="metric-grid">
                <article class="metric-card">
                    <span>Total complaints</span>
                    <strong>{{ $totalComplaints }}</strong>
                </article>
                <article class="metric-card">
                    <span>Pending</span>
                    <strong>{{ $statusCounts->get('pending', 0) }}</strong>
                </article>
                <article class="metric-card">
                    <span>In progress</span>
                    <strong>{{ $statusCounts->get('in_progress', 0) + $statusCounts->get('assigned', 0) }}</strong>
                </article>
                <article class="metric-card">
                    <span>Resolved</span>
                    <strong>{{ $statusCounts->get('resolved', 0) + $statusCounts->get('closed', 0) }}</strong>
                </article>
                <article class="metric-card">
                    <span>Registered students</span>
                    <strong>{{ $totalStudents }}</strong>
                </article>
                <article class="metric-card">
                    <span>Registered staff</span>
                    <strong>{{ $totalStaff }}</strong>
                </article>
            </div>

            <div class="dashboard-grid">
                <section class="panel panel-large">
                    <div class="panel-head">
                        <div>
                            <h2>Latest complaints</h2>
                            <p>Newest submissions across campus.</p>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Issue</th>
                                    <th>Student</th>
                                    <th>Status</th>
                                    <th>Staff</th>
                                    <th>Images</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaints as $complaint)
                                    @php
                                        $latestImage = $complaint->images->sortByDesc('created_at')->first();
                                    @endphp
                                    <tr>
                                        <td><a href="{{ route('admin.complaints.show', $complaint) }}">{{ $complaint->complaint_no }}</a></td>
                                        <td>
                                            <strong>{{ $complaint->title }}</strong>
                                            <span>{{ $complaint->category->category_name }} · {{ $complaint->location->label() }}</span>
                                        </td>
                                        <td>{{ $complaint->student->name }}</td>
                                        <td><span class="status-badge {{ $complaint->status }}">{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</span></td>
                                        <td>{{ $complaint->currentStaff->name ?? 'Unassigned' }}</td>
                                        <td>
                                            @if ($latestImage)
                                                <a href="{{ asset('storage/'.$latestImage->image_path) }}" target="_blank" rel="noopener" title="Open complaint image">
                                                    <img src="{{ asset('storage/'.$latestImage->image_path) }}" alt="{{ $latestImage->image_name ?? 'Complaint image' }}" style="width: 72px; height: 72px; object-fit: cover; border-radius: 12px; display: block;">
                                                </a>
                                            @else
                                                <span class="muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="post" onsubmit="return confirm('Delete complaint {{ $complaint->complaint_no }}? This cannot be undone.');">
                                                @csrf
                                                @method('delete')
                                                <button class="button danger compact" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty-cell">No complaints yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <aside class="panel">
                    <div class="panel-head">
                        <div>
                            <h2>Registered staff</h2>
                            <p>Current staff accounts and open workload.</p>
                        </div>
                    </div>

                    <div class="staff-list">
                        @forelse ($staff as $member)
                            <div class="staff-row">
                                <div>
                                    <strong>{{ $member->name }}</strong>
                                    <span>{{ $member->staff_id ?? 'No staff ID' }} · {{ $member->department ?? 'Maintenance team' }}</span>
                                </div>
                                <div class="row-actions">
                                    <b title="Open assignments">{{ $member->open_assignments_count }}</b>
                                    <form action="{{ route('admin.users.destroy', $member) }}" method="post" onsubmit="return confirm('Delete staff account for {{ $member->name }}? Open assignments will return to pending.');">
                                        @csrf
                                        @method('delete')
                                        <button class="button danger compact" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="muted">No staff accounts yet.</p>
                        @endforelse
                    </div>
                </aside>
            </div>

            <section class="panel user-panel">
                <div class="panel-head">
                    <div>
                        <h2>Registered students</h2>
                        <p>Current student accounts and submitted complaint volume.</p>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Department / Batch</th>
                                <th>Complaints</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>
                                        <strong>{{ $student->name }}</strong>
                                        <span>{{ $student->email }}</span>
                                    </td>
                                    <td>{{ $student->student_id ?? 'Not set' }}</td>
                                    <td>{{ $student->department ?? 'Not set' }}</td>
                                    <td>{{ $student->submitted_complaints_count }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $student) }}" method="post" onsubmit="return confirm('Delete student account for {{ $student->name }}? Their complaints and related records will also be deleted.');">
                                            @csrf
                                            @method('delete')
                                            <button class="button danger compact" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-cell">No student accounts yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Category report</h2>
                        <p>Complaint volume by operational area.</p>
                    </div>
                </div>

                <div class="report-bars">
                    @foreach ($categoryCounts as $category)
                        <div class="report-bar">
                            <span>{{ $category->category_name }}</span>
                            <div><i style="width: {{ max(8, min(100, $totalComplaints ? ($category->complaints_count / $totalComplaints) * 100 : 0)) }}%"></i></div>
                            <b>{{ $category->complaints_count }}</b>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection
