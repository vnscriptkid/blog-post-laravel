<?php
// php artisan make:mail CommentPosted --markdown=comment-posted-on-watched
namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// default subject "Comment Posted"
// implements ShouldQueue
class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment; // public vars will available in template

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Comment was posted on your `{$this->comment->commentable->title}` blog post";
        return $this // ->from('admin@laravel.test', 'Admin') -> overwrite config/mail.php
            ->subject($subject)
            ->view('emails.posts.commented');
    }
}
