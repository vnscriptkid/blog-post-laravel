<?php

namespace App\Listeners;

use App\Events\CommentPosted as CommentPostedEvent;
use App\Jobs\NotifyWatchersPostCommented;
use App\Jobs\ThrottleMail;
use App\Mail\CommentPosted as CommentPostedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutComment
{
    public function handle(CommentPostedEvent $event)
    {
        // send mail to post author
        ThrottleMail::dispatch(
            new CommentPostedMail($event->comment),
            $event->comment->commentable->user
        )->onQueue('high');

        // send mails to all other watchers of post
        NotifyWatchersPostCommented::dispatch($event->comment)->onQueue('low');
    }
}
