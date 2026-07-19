@if ($complaint->isResolved())
    <form class="panel feedback-panel" action="{{ route('complaints.feedback', $complaint) }}" method="post">
        @csrf
        <div class="panel-head">
            <div>
                <h2>Resolution feedback</h2>
                <p>Rate the completed work on your complaint.</p>
            </div>
        </div>
        <div class="field feedback-rating">
            <label for="rating">Rating</label>
            <select id="rating" class="select" name="rating" required>
                @for ($rating = 5; $rating >= 1; $rating--)
                    <option value="{{ $rating }}" @selected(optional($complaint->feedback)->rating === $rating)>{{ $rating }} out of 5</option>
                @endfor
            </select>
        </div>
        <div class="field">
            <label for="comment">Comment</label>
            <textarea id="comment" class="textarea" name="comment">{{ old('comment', optional($complaint->feedback)->comment) }}</textarea>
        </div>
        <button class="button primary" type="submit">Submit feedback</button>
    </form>
@endif
