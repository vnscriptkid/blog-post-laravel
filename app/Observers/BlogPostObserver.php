<?php
// php artisan make:observer BlogPostObserver --model=BlogPost
namespace App\Observers;

use App\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    public function updating(BlogPost $post)
    {
        Cache::forget("post-{$post->id}");
    }

    public function deleting(BlogPost $post)
    {
        dd('post deleting');
        $post->comments()->delete();
    }

    public function restoring(BlogPost $post)
    {
        $post->comments()->restore();
    }
}
