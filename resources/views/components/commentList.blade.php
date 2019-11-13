@if ($list && $list->count())
    <ul>
        @foreach ($list as $comment)
            <li>{{ $comment->content }}
            {{-- <span class="text-muted">created at {{ $comment->created_at->diffForHumans() }}</span> --}}
            @updated([
                'time' => $comment->created_at->diffForHumans(),
                'userName' => $comment->user->name,
                'userId' => $comment->user->id
            ])@endupdated
            </li>
        @endforeach
    </ul>
@else
    <p>There's no comment yet</p>
@endif
