<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostTagController extends Controller
{
    public function index($tagId)
    {
        $tag = Tag::findOrFail($tagId);

        $posts = Cache::remember("posts-tag-{$tag->id}", now()->addSeconds(20), function () use ($tag) {
            return $tag->blogPosts()
                ->latestWithRelations()
                ->get();
        });

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }
}
