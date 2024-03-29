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

    protected $hidden = ['deleted_at', 'commentable_id', 'commentable_type'];

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

    public function commentable()
    {
        // comment->commentable is either a BlogPost or a User
        return $this->morphTo();
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy('created_at', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
        // static::creating(function (Comment $comment) {
        //     // Cache::forget("post-{$comment->blog_post_id}");
        //     if ($comment->commentable_type === BlogPost::class) {
        //         Cache::forget("post-{$comment->commentable_id}");
        //     }
        // });
    }
}
