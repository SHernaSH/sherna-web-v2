<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Consoles\Console::class, function (Faker $faker) {
    return [
        'location_id' => factory(App\Models\Locations\Location::class),
        'console_type_id' => factory(App\Models\Consoles\ConsoleType::class),
        'name' => $faker->name,
    ];
});
