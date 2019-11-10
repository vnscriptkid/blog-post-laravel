@extends('layouts.app')

@section('content')
    <form
        action="{{ route('posts.update', ['post' => $post->id]) }}"
        style="max-width: 700px; margin: 0 auto;"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')
        <h1>Edit the post #{{ $post->id }}</h1>
        @include('posts._form');
    </form>
@endsection
