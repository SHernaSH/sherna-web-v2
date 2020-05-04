<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Navigation\PageText::class, function (Faker $faker) {
    return [
        'nav_page_id' => factory(App\Models\Navigation\Page::class),
        'title' => $faker->word,
        'content' => $faker->text,
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
