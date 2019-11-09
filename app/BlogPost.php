<?php

namespace App;

// use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    // find all comments belong to one post
    // SELECT * FROM comments WHERE blog_post_id = X
    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    // find the user by whom the post is created
    // SELECT * FROM users WHERE user_id = X LIMIT 1
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // find all tags of the post
    // SELECT * FROM blog_post_tag WHERE blog_post_id = X
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy('created_at', 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });

        static::updating((function (BlogPost $post) {
            Cache::forget("post-{$post->id}");
        }));
    }
}
