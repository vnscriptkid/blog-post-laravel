<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['path'];

    // find the post that contains the image
    // SELECT * FROM blog_posts WHERE id = X
    public function imageable()
    {
        // return $this->belongsTo('App\BlogPost');
        return $this->morphTo();
    }

    public function url()
    {
        return Storage::url($this->path);
    }
}
