@extends('layouts.app')

@section('content')
@if (count($posts) > 0)
    <h1 class="text-center">See all the posts</h1>
    <hr>
    @foreach ($posts as $post)
        <div>
            <h2>Post #{{ $post->id }} </h2>
            <p>by {{ $post->user->name }}</p>
            @if ($post->comments_count > 0)
                <span class="text-muted">{{ $post->comments_count }} comments</span>
            @else
                <span class="text-muted">No comment yet</span>
            @endif
            <h3>{{ $post->title }}</h3>
            <a href="{{ route('posts.show', ['post' => $post->id]) }}">See details</a>
            <hr>
        </div>
    @endforeach
@else
    <p class="lead">There no posts found</p>
@endif

@endsection
