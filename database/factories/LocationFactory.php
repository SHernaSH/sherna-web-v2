<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Locations\Location::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber() + 10,
        'name' => $faker->name,
        'status_id' => factory(App\Models\Locations\LocationStatus::class)->create()->id,
        'reader_uid' => $faker->word,
        'location_uid' => $faker->word,
        'language_id' => 1,
    ];
});
