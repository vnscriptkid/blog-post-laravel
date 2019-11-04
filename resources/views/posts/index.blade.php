@extends('layout')

@section('content')
@if (count($posts) > 0)
    <h1>See all the posts</h1>
    @foreach ($posts as $post)
        <div>
            <h2>Post #{{ $post->id }}</h2>
            <h3>{{ $post->title }}</h3>
            <a href="{{ route('posts.show', ['post' => $post->id]) }}">See details</a>
            <hr>
        </div>
    @endforeach
@else
    <p class="lead">There no posts found</p>
@endif

@endsection
