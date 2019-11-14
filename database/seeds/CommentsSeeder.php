<?php

use App\BlogPost;
use App\Comment;
use App\User;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        $users = User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->error("No comment has been created as no post or user existed");
            return;
        }
        // create comments on post
        $commentsOnPost = 0;
        $posts->each(function ($post) use ($users, &$commentsOnPost) {
            $numOfComments = random_int(1, 5);
            $commentsOnPost += $numOfComments;
            factory(Comment::class, $numOfComments)->make()->each(function ($comment) use ($post, $users) {
                $comment->commentable_type = BlogPost::class;
                $comment->commentable_id = $post->id;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
        });
        $this->command->info("{$commentsOnPost} comments on posts has been created");

        // create comments on user profile
        $commentsOnProfile = 0;
        $users->each(function ($user) use ($users, &$commentsOnProfile) {
            $numOfComments = random_int(1, 5);
            $commentsOnProfile += $numOfComments;
            factory(Comment::class, $numOfComments)->make()->each(function ($comment) use ($user, $users) {
                $comment->commentable_type = User::class;
                $comment->commentable_id = $user->id;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
        });

        $this->command->info("{$commentsOnProfile} comments on profiles has been created");
    }
}
