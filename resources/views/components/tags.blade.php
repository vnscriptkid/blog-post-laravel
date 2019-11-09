<h4>
    @foreach ($tags as $tag)
    <a href="{{ route('posts.tag.index', ['tag' => $tag->id]) }}">
        <span class="badge badge-warning">{{ $tag->name }}</span>
    </a>
    @endforeach
</h4>
