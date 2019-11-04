<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;

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

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status', "Blog post #{$id} has been updated successfully");
        return redirect()->route('posts.show', ['post' => $id]);
    }

    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        $request->session()->flash('status', "Blog post #{$id} has been deleted successfully");
        return redirect()->route('posts.index');
    }
}
