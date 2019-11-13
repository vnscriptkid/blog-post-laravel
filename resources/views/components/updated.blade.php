@if (!isset($show) || $show)
    <p class="text-muted">
        <span>{{ empty(trim($slot)) ? 'added' : 'updated' }}</span> {{ $time }}
        @if(isset($userName) && isset($userId)) by <strong>
            <a href="{{ route('users.show', ['user' => $userId]) }}">
                {{ $userName }}
            </a>
        </strong> @endif
    </p>
@endif
