<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Reservation::class, function (Faker $faker) {
    $class = random_int(0, 1);
    $price = random_int(0, 2000) + 2000;
    return [
        'flight_id' => \App\Models\Flight::all()->random()->id,
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'class' => $class,
        'price' => $price,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
