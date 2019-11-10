<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['path', 'blog_post_id'];

    // find the post that contains the image
    // SELECT * FROM blog_posts WHERE id = X
    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }

    public function url()
    {
        return Storage::url($this->path);
    }
}