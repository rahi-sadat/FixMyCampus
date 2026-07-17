@extends('layouts.app')

@section('title', 'Assign '.$complaint->complaint_no.' | FixMyCampus')

@section('content')
    <section class="app-page"><div class="shell">
        <div class="page-head compact"><div><div class="section-kicker">Assignment</div><h1>{{ $complaint->title }}</h1></div><a class="button secondary" href="{{ route('admin.assignments.index') }}">Back</a></div>
        @include('partials.flash')
        <form class="panel form-panel" action="{{ route('admin.assignments.store', $complaint) }}" method="post">
            @csrf
            <div class="assignment-summary"><span>{{ $complaint->complaint_no }}</span><strong>{{ $complaint->location->label() }}</strong><span>Current staff: {{ $complaint->currentStaff->name ?? 'Unassigned' }}</span></div>
            <div class="field"><label for="assigned_to">Staff member</label><select id="assigned_to" class="select" name="assigned_to" required><option value="">Choose staff</option>@foreach ($staff as $member)<option value="{{ $member->id }}" @selected($complaint->current_staff_id === $member->id)>{{ $member->name }} · {{ $member->department ?? 'Maintenance' }}</option>@endforeach</select></div>
            <div class="field"><label for="assignment_note">Assignment note</label><textarea id="assignment_note" class="textarea" name="assignment_note">{{ old('assignment_note') }}</textarea></div>
            <button class="button primary" type="submit">Assign complaint</button>
        </form>
    </div></section>
@endsection
