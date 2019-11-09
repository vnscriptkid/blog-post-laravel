<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Football', 'News', 'Teenage', 'Love', 'Sex', 'Politics', 'Economy', 'Entertainment', 'Food', 'Drinks'];
        $tags = collect($tags);

        $tags->each(function ($name) {
            $tag = new Tag();
            $tag->name = $name;
            $tag->save();
        });

        $this->command->info('Some default tags has been added successfully');
    }
}
