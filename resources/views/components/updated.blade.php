@if (!isset($show) || $show)
    <p class="text-muted">
        <span>{{ empty(trim($slot)) ? 'added' : 'updated' }}</span> {{ $time }}
        @if(isset($user)) by <strong>{{ $user }}</strong> @endif
    </p>
@endif
