@extends('layouts.app')

@section('content')
    <form
        action="{{ route('posts.store') }}"
        style="max-width: 700px; margin: 0 auto;"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        <h1>Create a new post</h1>
        @include('posts._form')
    </form>
@endsection
