<?php

use App\BlogPost;
use App\User;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postsCount = (int) $this->command->ask('How many posts do you want to create', 50);

        if ($postsCount < 1) {
            $postsCount = 1;
        }

        $users = User::all();

        if ($users->count() > 0) {
            factory(BlogPost::class, $postsCount)->make()->each(function ($post) use ($users) {
                $post->user_id = $users->random()->id;
                $post->save();
            });
            $this->command->info("{$postsCount} posts has been created successfully");
        } else {
            $this->command->error('No post has been been created as no user existed');
        }
    }
}
