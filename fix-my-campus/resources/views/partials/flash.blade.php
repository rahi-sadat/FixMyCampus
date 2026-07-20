@if (session('status'))
    <p class="auth-notice">{{ session('status') }}</p>
@endif

@if ($errors->any())
    <div class="auth-error">
        <strong>Please check the highlighted details.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
