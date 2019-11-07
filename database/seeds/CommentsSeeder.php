<?php

use App\BlogPost;
use App\Comment;
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
        $commentsCount = (int) $this->command->ask('How many comments do you want to create', 100);

        if ($commentsCount < 1) {
            $commentsCount = 1;
        }

        $posts = BlogPost::all();
        $postsCount = $posts->count();

        if ($postsCount > 0) {
            factory(Comment::class, $commentsCount)->make()->each(function ($comment) use ($posts) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->save();
            });
            $this->command->info("{$commentsCount} comments has been created successfully");
        } else {
            $this->command->error("No comment has been created as no post existed");
        }
    }
}
