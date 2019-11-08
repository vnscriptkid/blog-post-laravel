<?php

namespace Tests;

use App\BlogPost;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user()
    {
        return factory(User::class)->create();
    }

    protected function admin()
    {
        return factory(User::class)->states(['vnscriptkid'])->create();
    }

    protected function createPost(User $user = null)
    {
        if (!$user instanceof User) {
            $user = $this->user();
        }
        $post = factory(BlogPost::class, 1)->make()->first();
        $post->user()->associate($user)->save();
        // return BlogPost::find($post->id)->first();
        return $post;
    }
}
