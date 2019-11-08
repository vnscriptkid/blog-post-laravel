<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'title' => $faker->text(rand(10, 30)),
        'content' => $faker->text(),
        'created_at' => $faker->dateTimeBetween('-2 years')
    ];
});
