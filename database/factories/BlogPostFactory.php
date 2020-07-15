<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'content' => $faker->text
    ];
});

$factory->state(BlogPost::class, 'new-title', function (Faker $faker) {
    return [
        'title' => 'New Title',
        'content' => 'Content of the blog post'
    ];
});
