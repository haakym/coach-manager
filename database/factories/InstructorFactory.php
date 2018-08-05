<?php

use App\Models\Instructor;
use Faker\Generator as Faker;

$factory->define(Instructor::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->state(Instructor::class, 'volunteer', [
    'type' => 'volunteer',
    'hourly_rate' => 0,
]);
    
$factory->state(Instructor::class, 'coach', [
    'type' => 'coach',
    'hourly_rate' => 1000,
]);