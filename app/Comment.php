<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // find post of a comment
    // SELECT * FROM blog_posts WHERE blog_post_id = 10
    public function blogPost()
    { // blog_post_id
        return $this->belongsTo('App\BlogPost');
    }
}
