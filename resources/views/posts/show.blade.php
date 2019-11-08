@extends('layouts.app')

@section('content')
    <div>
        <h1>See single post #{{ $post->id }}</h1>
        <h3>{{ $post->title }}</h3>
        {{-- created time --}}
            @badge(['show' => (new Carbon\Carbon())->diffInMinutes($post->created_at) < 10])
                New Post !
            @endbadge
            <p>Created {{ $post->created_at->diffForHumans() }}</p>
        {{-- end of created time --}}
        <p>{{ $post->content }}</p>


        {{-- author actions --}}
        <div>
            @can('update', $post)
                <a class="btn btn-warning" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
            @endcan

            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endcan
        </div>
        {{-- end of author actions --}}

        <hr>
        <h2>Comments</h2>
        @if (count($post->comments))
            <ul>
                @foreach ($post->comments as $comment)
                    <li>{{ $comment->content }}</li>
                    <span class="text-muted">created at {{ $comment->created_at->diffForHumans() }}</span>
                @endforeach
            </ul>
        @else
            <p>There's no comment yet</p>
        @endif
    </div>
@endsection
