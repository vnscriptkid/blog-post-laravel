<?php

namespace App\Http\ViewComposers;

use App\BlogPost;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('most-commented', now()->addSeconds(60), function () {
            return BlogPost::mostCommented()->take(3)->get();
        });

        $topUsers = Cache::remember('top-users', now()->addSeconds(60), function () {
            return User::hasMostPosts()->take(3)->get();
        });

        $mostActiveLastMonth = Cache::remember('most-active-last-month', now()->addSeconds(60), function () {
            return User::hasMostPostsLastMonth()->take(3)->get();
        });

        $view->with([
            'mostCommented' => $mostCommented,
            'topUsers' => $topUsers,
            'mostActiveLastMonth' => $mostActiveLastMonth
        ]);
    }
}
