<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Inventory\InventoryCategory::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber() + 5,
        'name' => $faker->name,
        'language_id' => 1,
    ];
});
