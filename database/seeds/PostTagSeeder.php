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
        $tags = Tag::all();
        $posts = BlogPost::all();

        if ($tags->count() === 0 || $posts->count() === 0) {
            $this->command->error("No post_tag record is created as no tags or posts existed");
            return;
        }

        $postTagCount = (int) $this->command->ask('How many post_tag do you want to create', 200);

        if ($postTagCount < 1) {
            $postTagCount = 1;
        }

        $success = 0;

        for ($x = 0; $x < $postTagCount; $x++) {
            $tag = $tags->random()->id;
            $post = $posts->random();
            $result = $post->tags()->syncWithoutDetaching($tag);
            if (!empty($result['attached'])) {
                $success++;
            }
        }

        $this->command->info("{$success} post_tag has been created successfully");
    }
}
