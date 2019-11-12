<?php

namespace App\Listeners;

use App\Events\NewBlogPost;
use App\Jobs\ThrottleMail;
use App\Mail\BlogPostAdded;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminNewBlogPost
{
    public function handle(NewBlogPost $event)
    {
        User::areAdmins()->get()
            ->each(function (User $user) {
                ThrottleMail::dispatch(
                    new BlogPostAdded(),
                    $user
                );
            });
    }
}
