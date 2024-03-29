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
                @updated(['time' => $post->created_at->diffForHumans(), 'userName' => $post->user->name, 'userId' => $post->user->id])
                @endupdated
                @updated([
                    'show' => $post->created_at->lt($post->updated_at),
                    'time' => $post->updated_at->diffForHumans(),
                    ])
                    updated
                @endupdated

            {{-- post image --}}
            @if (isset($post->image))
                <div class="my-3">
                    <img src="{{ $post->image->url() }}" alt="{{ $post->title }}" style="max-width:100%"/>
                </div>
            @endif

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
            <div>
                @comments(['list' => $post->comments])
                @endcomments
            </div>
        </div>

        {{-- activity column --}}
        <div class="col col-md-4">
            @include('posts._activity');
        </div>
    </div>

@endsection
