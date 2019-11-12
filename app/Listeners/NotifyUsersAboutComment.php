<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyWatchersPostCommented;
use App\Jobs\ThrottleMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutComment
{
    public function handle(CommentPosted $event)
    {
        // send mail to post author
        ThrottleMail::dispatch(
            new CommentPosted($event->comment),
            $event->comment->commentable->user
        )->onQueue('high');

        // send mails to all other watchers of post
        NotifyWatchersPostCommented::dispatch($event->comment)->onQueue('low');
    }
}
