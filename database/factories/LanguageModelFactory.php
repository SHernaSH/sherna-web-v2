<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Extensions\LanguageModel::class, function (Faker $faker) {
    return [
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
