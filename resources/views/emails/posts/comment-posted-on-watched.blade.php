@component('mail::message')
# One new comment has been posted on that post you are watching!

Hi {{ $user->name }},

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
    View the blog post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
    View {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
    {{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
