<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Inventory\InventoryItem::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber() + 5,
        'category_id' => factory(App\Models\Inventory\InventoryCategory::class)->create()->id,
        'location_id' => factory(App\Models\Locations\Location::class)->create()->id,
        'name' => $faker->name,
        'serial_id' => $faker->word,
        'inventory_id' => $faker->word,
        'note' => $faker->text,
        'language_id' => 1,
    ];
});
