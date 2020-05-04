<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Inventory\InventoryCategory::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'name' => $faker->name,
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
