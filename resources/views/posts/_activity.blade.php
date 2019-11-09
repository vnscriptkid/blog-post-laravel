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
