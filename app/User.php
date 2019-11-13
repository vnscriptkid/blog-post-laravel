<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany('App\BlogPost');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function profileComments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function scopeHasMostPosts(Builder $builder)
    {
        return $builder->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeHasMostPostsLastMonth(Builder $builder)
    {
        return $builder->withCount(['blogPosts' => function (Builder $query) {
            return $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])
            // ->having('blog_posts_count', '>=', 2)
            // ->has('blogPosts', '>=', 2)
            ->orderBy('blog_posts_count', 'desc');
    }

    public function scopeThatCommentedOnPost(Builder $builder, BlogPost $post)
    {
        return $post->comments
            ->map(function ($comment) {
                return $comment->user;
            })
            ->unique();
    }

    public function scopeAreAdmins(Builder $builder)
    {
        return $builder->where('is_admin', true);
    }
}
