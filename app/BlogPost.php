<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    // find all comments belong to one post
    // SELECT * FROM comments WHERE blog_post_id = X
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    // find the user by whom the post is created
    // SELECT * FROM users WHERE user_id = X LIMIT 1
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });
    }
}
