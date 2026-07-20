@extends('layouts.app')

@section('title', 'Submit Complaint | FixMyCampus')

@section('content')
    <section class="app-page">
        <div class="shell">
            <div class="page-head compact">
                <div>
                    <div class="section-kicker">New complaint</div>
                    <h1>Report a campus issue</h1>
                    <p>Give maintenance teams the practical details they need to respond quickly.</p>
                </div>
            </div>

            @include('partials.flash')

            <form class="panel form-panel" action="{{ route('complaints.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="field">
                        <label for="category_id">Category</label>
                        <select id="category_id" class="select" name="category_id" required>
                            <option value="">Choose category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label for="priority">Priority</label>
                        <select id="priority" class="select" name="priority" required>
                            @foreach (['low', 'medium', 'high', 'urgent'] as $priority)
                                <option value="{{ $priority }}" @selected(old('priority', 'medium') === $priority)>{{ ucfirst($priority) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field full">
                        <label for="location_id">Known location</label>
                        <select id="location_id" class="select" name="location_id">
                            <option value="">Add a new/specific location below</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label for="location_name">Location name</label>
                        <input id="location_name" class="input" name="location_name" type="text" value="{{ old('location_name') }}" placeholder="CSE Lab">
                    </div>

                    <div class="field">
                        <label for="building_name">Building</label>
                        <input id="building_name" class="input" name="building_name" type="text" value="{{ old('building_name') }}" placeholder="Academic Building">
                    </div>

                    <div class="field">
                        <label for="floor_no">Floor</label>
                        <input id="floor_no" class="input" name="floor_no" type="text" value="{{ old('floor_no') }}" placeholder="2nd floor">
                    </div>

                    <div class="field">
                        <label for="room_no">Room</label>
                        <input id="room_no" class="input" name="room_no" type="text" value="{{ old('room_no') }}" placeholder="Room 204">
                    </div>

                    <div class="field full">
                        <label for="title">Issue title</label>
                        <input id="title" class="input" name="title" type="text" value="{{ old('title') }}" placeholder="Wi-Fi drops during lab classes" required>
                    </div>

                    <div class="field full">
                        <label for="description">Description</label>
                        <textarea id="description" class="textarea tall" name="description" placeholder="Describe what is happening, where it happens, and when the team can inspect it." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="field full">
                        <label for="images">Attach images</label>
                        <input id="images" class="input file-input" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple>
                        <p class="field-hint">Upload up to 5 JPG, PNG, or WebP images. Each image can be up to 4 MB.</p>
                    </div>
                </div>

                <div class="form-footer">
                    <a class="button secondary" href="{{ route('dashboard') }}">Cancel</a>
                    <button class="button primary" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2 11 13"/><path d="m22 2-7 20-4-9-9-4Z"/></svg>
                        Submit complaint
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
