<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Permissions\Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'controller' => $faker->word,
        'method' => $faker->word,
    ];
});
