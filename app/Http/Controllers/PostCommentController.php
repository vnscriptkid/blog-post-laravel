<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Comment;
use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment as CommentResource;
use App\Jobs\NotifyWatchersPostCommented;
use App\Jobs\ThrottleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function index(BlogPost $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $request->validated();

        // $validatedData['blog_post_id'] = $post->id;
        // $validatedData['user_id'] = Auth::id();
        // Comment::create($validatedData);

        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // Mail::to($post->user)->queue(
        //     new CommentPosted($comment)
        // );

        // Mail::to($post->user)->later(
        //     now()->addSeconds(0),
        //     new CommentPosted($comment)
        // );

        event(new CommentPosted($comment));
        // php artisan queue:work --tries=3 --timeout=15 --queue=high,default,low
        return redirect()->back();
    }
}
