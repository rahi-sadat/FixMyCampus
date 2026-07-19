@extends('layouts.app')

@section('title', 'Submit Complaint | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head compact">
                <div>
                    <div class="section-kicker">New complaint</div>
                    <h1>Report a campus issue</h1>
                    <p>Give the maintenance team the details needed to respond.</p>
                </div>
            </div>

            @include('partials.flash')

            <form class="panel form-panel submission-form" action="{{ route('complaints.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('student.complaints.partials.submission-fields')
                <div class="form-footer">
                    <a class="button secondary" href="{{ route('student.dashboard') }}">Cancel</a>
                    <button class="button primary" type="submit">Submit complaint</button>
                </div>
            </form>
        </div>
    </section>
@endsection
