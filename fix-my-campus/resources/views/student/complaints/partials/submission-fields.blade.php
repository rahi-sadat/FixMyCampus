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
        <input id="title" class="input" name="title" type="text" value="{{ old('title') }}" required>
    </div>
    <div class="field full">
        <label for="description">Description</label>
        <textarea id="description" class="textarea tall" name="description" required>{{ old('description') }}</textarea>
    </div>
    <div class="field full">
        <label for="images">Attach images</label>
        <input id="images" class="input file-input" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple>
        <p class="field-hint">Up to 5 JPG, PNG, or WebP images; 4 MB each.</p>
    </div>
</div>
