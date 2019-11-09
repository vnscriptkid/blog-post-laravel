<?php

use App\BlogPost;
use App\Tag;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        $tagsCount = Tag::count();

        if ($tagsCount === 0 || $posts->count() === 0) {
            $this->command->error("No post_tag record is created as no tags or posts existed");
            return;
        }

        $success = 0;

        $posts->each(function ($post) use (&$success) {
            $take = random_int(1, 5);
            $tags = Tag::inRandomOrder()->take($take)->pluck('id');
            $post->tags()->attach($tags);
            $success += $take;
        });

        $this->command->info("{$success} post_tag has been created successfully");
    }
}
