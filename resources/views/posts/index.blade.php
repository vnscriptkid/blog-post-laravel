@extends('layouts.app')

@section('content')
@if (count($posts) > 0)
    <div class="row">
        <div class="col col-md-8">
            <h1 class="text-center">See all the posts</h1>
            <hr>
            @foreach ($posts as $post)
                <div>
                    <h2>Post #{{ $post->id }} </h2>
                    {{-- created time --}}
                        {{-- [REF] --}}
                        {{-- @component('components.badge', ['type' => 'danger'])
                            New Post
                        @endcomponent --}}
                        @badge(['type' => 'danger', 'show'=>($post->created_at->diffInMinutes() < 10)])
                            New Post!
                        @endbadge

                        {{-- time and who --}}
                        @updated(['time' => $post->created_at->diffForHumans(), 'user' => $post->user->name])
                        @endupdated
                    {{-- end of created time --}}

                    {{-- comments count --}}
                    @if ($post->comments_count > 0)
                        <span class="text-muted">{{ $post->comments_count }} comments</span>
                    @else
                        <span class="text-muted">No comment yet</span>
                    @endif
                    {{-- end of comments count --}}

                    <h3>{{ $post->title }}</h3>
                    @tags(['tags' => $post->tags])@endtags
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">See details</a>
                    <hr>
                </div>
            @endforeach
        </div>
        <div class="col col-md-4">
            @include('posts._activity');
        </div>
    </div>
@else
    <p class="lead">There no posts found</p>
@endif

@endsection
