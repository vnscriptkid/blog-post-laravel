<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kidFound = User::where('email', 'vnscriptkid@gmail.com')->first();
        if ($kidFound == null) {
            factory(User::class)->states(['vnscriptkid'])->create();
            $this->command->info('`vnscriptkid` has been created as an user');
        }

        $usersCount = (int) $this->command->ask('How many users do you want to create', 20);

        if ($usersCount < 1) {
            $usersCount = 1;
        }

        factory(User::class, $usersCount)->create();
        $this->command->info("{$usersCount} users has been created successfully");
    }
}
