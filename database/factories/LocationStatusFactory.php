<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Locations\LocationStatus::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber() + 10,
        'name' => $faker->name,
        'opened' => $faker->boolean,
        'language_id' => 1,
    ];
});
