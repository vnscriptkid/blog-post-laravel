@extends('layout')

@section('content')
    <h1>Single Blog Post #{{ $postId }}</h1>
    <h3>{{ $msg }}</h3>
    <section>
        <h3>{{ $post['title'] }}</h3>
        <p>{!! $post['body'] !!}</p>
    </section>
@endsection
