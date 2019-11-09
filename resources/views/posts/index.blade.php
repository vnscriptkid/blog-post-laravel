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
            {{-- Most active all the time --}}
            <h4 class="text-center">Top Users</h4>
            <table class="table">
                <thead>
                    <th scope="col">Ranked</th>
                    <th scope="col">Name</th>
                    <th scope="col">Posts</th>
                </thead>
                <tbody>
                    @foreach ($topUsers as $key => $user)
                        <tr>
                            <th scope="row">#{{ $key + 1 }}</th>
                            <th>{{ $user->name }}</th>
                            <th>{{ $user->blog_posts_count }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Most commented posts --}}
            <h4 class="text-center">See hottest blog posts</h4>
            @foreach ($mostCommented as $post)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('posts.show', ['post' => $post->id ]) }}">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <p class="card-text">{{ $post->comments_count }} comments</p>
                    </div>
                </div>
                <hr>
            @endforeach
            {{-- Most active last month --}}
            <h4 class="text-center">Most active users last month</h4>
            <table class="table">
                <thead>
                    <th scope="col">Ranked</th>
                    <th scope="col">Name</th>
                    <th scope="col">Posts</th>
                </thead>
                <tbody>
                    @foreach ($mostActiveLastMonth as $key => $user)
                        <tr>
                            <th scope="row">#{{ $key + 1 }}</th>
                            <th>{{ $user->name }}</th>
                            <th>{{ $user->blog_posts_count }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <p class="lead">There no posts found</p>
@endif

@endsection
