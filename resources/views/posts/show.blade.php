@extends('layouts.app')

@section('content')
    <div>
        <h1>See single post #{{ $post->id }}</h1>
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->content }}</p>
        @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
            <p>It is a new post</p>
            <p>Diff in minutes: {{ (new Carbon\Carbon())->diffInMinutes($post->created_at) }}</p>
        @else
            <p>Created {{ $post->created_at->diffForHumans() }}</p>
        @endif

        @can('update', $post)
            <a class="btn btn-warning" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
        @endcan

        @can('delete', $post)
            <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endcan
        <hr>
        <h2>Comments</h2>
        @if (count($post->comments))
            <ul>
                @foreach ($post->comments as $comment)
                    <li>{{ $comment->content }}</li>
                @endforeach
            </ul>
        @else
            <p>There's no comment yet</p>
        @endif
    </div>
@endsection
