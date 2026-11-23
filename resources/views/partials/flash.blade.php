@if (session('status'))
    <div class="alert alert-success" role="status">
        <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6"/></svg>
        <div>{{ session('status') }}</div>
    </div>
@endif
