@extends('layout')

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
        <hr>
    </div>
@endsection
