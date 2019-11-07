<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to refresh migrations', false)) {
            $this->command->call('migrate:refresh');
            $this->command->info('DB has been refreshed');
        } else if ($this->command->confirm('Do you want to empty tables', true)) {
            // clean existing data, order matters here
            DB::table('comments')->delete();
            DB::table('blog_posts')->delete();
            DB::table('users')->delete();
        }

        // start seeding
        $this->call([
            UsersSeeder::class,
            PostsSeeder::class,
            CommentsSeeder::class
        ]);
    }
}
