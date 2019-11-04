@extends('layout')

@section('content')
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <h1>Create a new post</h1>
        @include('posts._form')
    </form>
@endsection
