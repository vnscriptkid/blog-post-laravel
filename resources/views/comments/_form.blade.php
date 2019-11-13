@if (isset($post))
    <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="post">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" cols="30" rows="2">{{ old('content') }}</textarea>
        </div>
        <button class="btn btn-block btn-primary" type="submit">Add comment to Post</button>
    </form>
@endif

@if (isset($user))
<form action="{{ route('users.comments.store', ['user' => $user->id]) }}" method="post">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" cols="30" rows="2">{{ old('content') }}</textarea>
        </div>
        <button class="btn btn-block btn-primary" type="submit">Add comment to Profile</button>
    </form>
@endif
