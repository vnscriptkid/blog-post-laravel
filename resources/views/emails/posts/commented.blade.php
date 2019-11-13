<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    #senderPhoto {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
</style>

<p>Hi {{ $comment->commentable->user->name }}</p>

<p><strong>{{ $comment->user->name }}</strong> has commented in your blog post</p>

<a href="{{ route('posts.show', ['post' => $comment->commentable->id]) }}">{{ $comment->commentable->title }}</a>

<hr>

<img src="{{ $comment->user->image ? $comment->user->image->url() : Storage::url('/userImages/user.jpg') }}" alt="{{ $comment->user->name }}" id="senderPhoto">
<span> said: </span>
<p>{{ $comment->content }}</p>
