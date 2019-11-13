<?php
// php artisan make:event NewBlogPost
namespace App\Events;

use App\BlogPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBlogPost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct(BlogPost $post)
    {
        $this->post = $post;
    }
}
