<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'blog_post_id'];

    use SoftDeletes;
    // find post of a comment
    // SELECT * FROM blog_posts WHERE blog_post_id = 10
    public function blogPost()
    { // blog_post_id
        return $this->belongsTo('App\BlogPost');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy('created_at', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
        static::creating(function (Comment $comment) {
            Cache::forget("post-{$comment->blog_post_id}");
        });
    }
}
