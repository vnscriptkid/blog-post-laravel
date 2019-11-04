<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>Hello</title>
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">Blog Post</a>

            <div class="collapse navbar-collapse ml-auto" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}">Posts</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('posts.create') }}">Create New Post</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                </ul>
            </div>
        </nav>

    {{-- status display --}}
    @if (session()->has('status'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('status') }}
        </div>
    @endif

    {{-- errors display --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        </ul>
    @endif

    <div class="container mt-3">
        @yield('content')
    </div>

    <script src="js/app.js"></script>
</body>
</html>
