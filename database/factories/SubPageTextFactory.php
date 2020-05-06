<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Navigation\SubPageText::class, function (Faker $faker) {
    return [
        'nav_subpage_id' => factory(App\Models\Navigation\SubPage::class),
        'title' => $faker->word,
        'content' => $faker->text,
        'language_id' => 1,
    ];
});
