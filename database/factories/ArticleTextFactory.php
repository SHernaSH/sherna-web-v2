<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Articles\ArticleText::class, function (Faker $faker) {
    return [
        'article_id' => factory(App\Models\Articles\Article::class),
        'title' => $faker->word,
        'description' => $faker->text,
        'content' => $faker->text,
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
