<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Games\Game::class, function (Faker $faker) {
    return [
        'console_id' => factory(App\Models\Consoles\Console::class),
        'name' => $faker->name,
        'note' => $faker->text,
        'possible_players' => $faker->randomNumber(),
        'serial_id' => $faker->word,
        'inventory_id' => $faker->word,
        'vr' => $faker->boolean,
        'move' => $faker->boolean,
        'kinect' => $faker->boolean,
        'game_pad' => $faker->boolean,
        'guitar' => $faker->boolean,
    ];
});
