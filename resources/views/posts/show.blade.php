@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col col-md-8">
            <h1>See single post #{{ $post->id }}</h1>
            <h3>{{ $post->title }}</h3>
                @tags(['tags' => $post->tags ])
                @endtags
                {{-- created time --}}
                @badge(['show' => (new Carbon\Carbon())->diffInMinutes($post->created_at) < 10])
                    New Post !
                @endbadge
                @updated(['time' => $post->created_at->diffForHumans(), 'user' => $post->user->name])
                @endupdated
                @updated([
                    'show' => $post->created_at->lt($post->updated_at),
                    'time' => $post->updated_at->diffForHumans(),
                    ])
                    updated
                @endupdated

            {{-- end of created time --}}
            <p>{{ $post->content }}</p>


            {{-- author actions --}}
            <div>
                @auth
                    @can('update', $post)
                        <a class="btn btn-warning" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                    @endcan

                    @can('delete', $post)
                        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endcan
                @endauth
            </div>
            {{-- end of author actions --}}

            {{-- how many people is reading this post --}}
            <span class="badge badge-info">{{ $currentlyReading }} people is reading</span>

            <hr>
            <h2>Comments</h2>

            {{-- comment form --}}
            <div class="my-2">
                @auth
                    @include('comments._form')
                @else
                    <p><a href="{{ route('login') }}">
                        <strong>Login Now!</strong></a> to leave comments</p>
                @endauth
            </div>
            <hr>

            {{-- comment list --}}
            @if (count($post->comments))
                <ul>
                    @foreach ($post->comments as $comment)
                        <li>{{ $comment->content }}
                        {{-- <span class="text-muted">created at {{ $comment->created_at->diffForHumans() }}</span> --}}
                        @updated([
                            'time' => $comment->created_at->diffForHumans(),
                            'user' => $comment->user->name
                        ])@endupdated
                        </li>
                    @endforeach
                </ul>
            @else
                <p>There's no comment yet</p>
            @endif
        </div>

        {{-- activity column --}}
        <div class="col col-md-4">
            @include('posts._activity');
        </div>
    </div>

@endsection
