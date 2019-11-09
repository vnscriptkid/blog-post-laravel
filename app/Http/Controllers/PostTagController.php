<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $posts = $tag->blogPosts;

        return view('posts.index', [
            'posts' => $posts,
            'mostCommented' => [],
            'topUsers' => [],
            'mostActiveLastMonth' => []
        ]);
    }
}
