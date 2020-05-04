<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Inventory\InventoryItem::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'category_id' => factory(App\Models\Inventory\InventoryCategory::class),
        'location_id' => factory(App\Models\Locations\Location::class),
        'name' => $faker->name,
        'serial_id' => $faker->word,
        'inventory_id' => $faker->word,
        'note' => $faker->text,
        'language_id' => factory(App\Models\Language\Language::class),
    ];
});
