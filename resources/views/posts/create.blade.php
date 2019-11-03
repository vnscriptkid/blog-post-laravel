@extends('layout')

@section('content')
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <h1>Create a new post</h1>
        <div>
            <label for="postTitle">Title</label>
            <input type="text" name="title" id="postTitle" value="{{ old('title') }}">
        </div>
        <div>
            <label for="postContent">Content</label>
            <textarea name="content" id="postContent" cols="30" rows="5">{{ old('content') }}</textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
@endsection
