<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Articles\ArticleCategoryDetail::class, function (Faker $faker) {
    return [
        'category_id' => factory(App\Models\Articles\ArticleCategory::class),
        'name' => $faker->name,
        'language_id' => 1,
        'deleted_at' => $faker->dateTime(),
    ];
});
