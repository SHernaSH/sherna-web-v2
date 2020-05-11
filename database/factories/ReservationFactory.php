<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Reservations\Reservation::class, function (Faker $faker) {
    $startingDate = \Carbon\Carbon::now()->addHours(random_int(5, 30));
    $endingDate   = $startingDate->addHours(6);
    return [
        'location_id' => factory(App\Models\Locations\Location::class)->create()->id,
        'user_id' => factory(App\Models\Users\User::class),
        'visitors_count' => $faker->randomNumber(),
        'start_at' => $startingDate,
        'end_at' => $endingDate,
        'entered_at' => $faker->dateTime(),
        'vr' => $faker->boolean,
        'note' => $faker->word,
    ];
});
