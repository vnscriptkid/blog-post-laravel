<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost' => 'App\Policies\BlogPostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view.secret', function ($user) {
            return $user->is_admin;
        });

        // Gate::define('update-post', function ($user, $post) { // $user is always passed by laravel, $post is ur part
        //     return $user->id == $post->user_id;
        // });

        // Gate::define('delete-post', function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        // 1 way
        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        // another way
        // Gate::resource('posts', 'App\Policies\BlogPostPolicy');

        Gate::before(function ($user, $ability) {
            if ($user->is_admin && in_array($ability, ['update-post', 'delete-post'])) {
                return true;
            }
        });
    }
}
