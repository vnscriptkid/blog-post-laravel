@extends('layouts.app')

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('PUT')
        <h1>Edit the post #{{ $post->id }}</h1>
        @include('posts._form');
    </form>
@endsection
