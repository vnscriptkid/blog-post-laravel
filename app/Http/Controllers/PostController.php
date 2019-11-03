<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests\StorePost;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::all()]);
    }

    public function show($id)
    {
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();

        $post = BlogPost::create($validatedData);

        $request->session()->flash('status', 'Blog post has been created successfully');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }
}
