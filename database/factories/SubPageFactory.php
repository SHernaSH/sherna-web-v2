<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Navigation\SubPage::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'nav_page_id' => factory(App\Models\Navigation\Page::class),
        'order' => $faker->randomNumber(),
        'public' => $faker->boolean,
        'url' => $faker->url,
        'name' => $faker->name,
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
