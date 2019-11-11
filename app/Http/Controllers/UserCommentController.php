<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCommentController extends Controller
{
    public function store(User $user, StoreComment $request)
    {
        $request->validated();

        $user->profileComments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->back()->withStatus("Comment on profile has been created.");
    }
}
