<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Comments\Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\Models\Users\User::class),
        'parent_id' => $faker->randomNumber(),
        'limit' => $faker->randomNumber(),
        'body' => $faker->text,
        'commentable_id' => $faker->word,
        'commentable_type' => $faker->word,
    ];
});
