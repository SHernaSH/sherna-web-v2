<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Reservations\Reservation::class, function (Faker $faker) {
    return [
        'location_id' => factory(App\Models\Locations\Location::class),
        'user_id' => factory(App\Models\Users\User::class),
        'visitors_count' => $faker->randomNumber(),
        'start_at' => $faker->dateTime(),
        'end_at' => $faker->dateTime(),
        'entered_at' => $faker->dateTime(),
        'vr' => $faker->boolean,
        'note' => $faker->word,
    ];
});
