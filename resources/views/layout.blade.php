<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello</title>
</head>
<body>
    <header style="height: 300px; background-color: blueviolet">
        <ul>
            <li><a href="{{ route('main') }}">App</a></li>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('posts.index') }}">Posts</a></li>
            <li><a href="{{ route('posts.create') }}">Create New Post</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
        </ul>
    </header>

    {{-- status display --}}
    @if (session()->has('status'))
        <strong style="color: green;">{{ session()->get('status') }}</strong>
    @endif

    {{-- errors display --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @yield('content')

    <footer  style="height: 300px; background-color: aqua"></footer>
</body>
</html>
