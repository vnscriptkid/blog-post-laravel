<?php

namespace App\Policies;

use App\BlogPost;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any blog posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function view(User $user, BlogPost $blogPost)
    {
        //
    }

    /**
     * Determine whether the user can create blog posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function update(User $user, BlogPost $post)
    {
        // dd('Update Post Gate', $user->id, $post->user_id);
        return $user->id == $post->user_id;
    }

    /**
     * Determine whether the user can delete the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function delete(User $user, BlogPost $post)
    {
        // dd('Delete Post Gate', $user->id, $post->user_id);
        return $user->id == $post->user_id;
    }

    /**
     * Determine whether the user can restore the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function restore(User $user, BlogPost $blogPost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function forceDelete(User $user, BlogPost $blogPost)
    {
        //
    }
}
