<?php

namespace App\Jobs;

use App\Comment;
use App\Mail\CommentPostedOnPostWatched;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersPostCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $watchedUsers = User::thatCommentedOnPost($this->comment->commentable);
        $commentAuthor = $this->comment->user;
        $now = now();

        $watchedUsers
            ->filter(function ($user) use ($commentAuthor) {
                return $user->id !== $commentAuthor->id;
            })
            ->each(function ($user) use ($now) {
                // send email to user
                ThrottleMail::dispatch(
                    new CommentPostedOnPostWatched(
                        $this->comment,
                        $user
                    ),
                    $user
                );
            });
    }
}
