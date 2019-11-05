<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content'];

    // find all comments belong to one post
    // SELECT * FROM comments WHERE blog_post_id = 10
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
