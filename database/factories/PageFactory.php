<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Navigation\Page::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'url' => $faker->url,
        'name' => $faker->name,
        'order' => $faker->randomNumber(),
        'public' => $faker->boolean,
        'dropdown' => $faker->boolean,
        'special_code' => $faker->word,
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
