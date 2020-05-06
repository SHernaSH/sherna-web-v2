<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Navigation\Page::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber() + 10,
        'url' => $faker->word,
        'name' => $faker->name,
        'order' => $faker->randomNumber(),
        'public' => $faker->boolean,
        'dropdown' => $faker->boolean,
        'special_code' => $faker->word,
        'language_id' => 1,
    ];
});
