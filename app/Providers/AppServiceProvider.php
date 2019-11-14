<?php

namespace App\Providers;

use App\BlogPost;
use App\Comment;
use App\Http\ViewComposers\ActivityComposer;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Services\AnotherImplOfCounter;
use App\Services\ViewerCounter;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('components.badge', 'badge');
        Blade::component('components.updated', 'updated');
        Blade::component('components.tags', 'tags');
        Blade::component('components.commentList', 'comments');

        // run composer before view is rendered
        view()->composer(['posts._activity'], ActivityComposer::class);

        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        // $this->app->bind(ViewerCounter::class, function ($app) {
        //     return new ViewerCounter(1);
        // });
        $this->app->singleton(ViewerCounter::class, function ($app) {
            return new ViewerCounter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                1
            );
        });

        $this->app->bind(
            'App\Contracts\ViewerCounterContract',
            ViewerCounter::class
            // AnotherImplOfCounter::class // replace implementation detail without affecting other code
        );

        // $this->app->when(ViewerCounter::class)
        //     ->needs('$timeout')
        //     ->give(env('VIEWER_COUNTER_TIMEOUT'));

        Resource::withoutWrapping(); // data: [ ]
    }
}
