<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Articles\Article::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'user_id' => factory(App\Models\Users\User::class),
        'public' => $faker->boolean,
        'comments_enabled' => $faker->boolean,
    ];
});
