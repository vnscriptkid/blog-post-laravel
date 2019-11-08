<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    private function debugQuery($cb)
    {
        DB::connection()->enableQueryLog();

        $cb();

        $queries = DB::getQueryLog();
        dd($queries);
    }

    public function index()
    {
        $posts = BlogPost::withCount('comments')->get();
        return view('posts.index', ['posts' => $posts]);
    }

    public function show($id)
    {
        $post = BlogPost::with('comments')->findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = Auth::id();

        $post = BlogPost::create($validatedData);

        $request->session()->flash('status', 'Blog post has been created successfully');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, 'You can not edit this post');
        // }

        $this->authorize('update', $post);

        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status', "Blog post #{$id} has been updated successfully");
        return redirect()->route('posts.show', ['post' => $id]);
    }

    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('delete', $post);

        $post->delete();

        $request->session()->flash('status', "Blog post #{$id} has been deleted successfully");
        return redirect()->route('posts.index');
    }
    // advanced queries: whereHas, whereDoesntHave, withCount
    // 1. get all posts that has at least 1 comment
    // 2. get all posts that has more than 3 comments
    // 3. get all posts that has no comment
    // 4. get all posts that comments containing `term`
    // 5. get all posts with comments_count attached to each post
    // 6. get all posts with new_comments attached that counts # of new comments
}
