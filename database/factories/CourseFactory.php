<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Course::class, function (Faker $faker) {
    $dateFrom = Carbon::parse('+1 month');
    $dateTo = $dateFrom->copy()->addDays(5);

    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
        'address' => $faker->address,
        'date_from' => $dateFrom->format('Y-m-d'),
        'date_to' => $dateTo->format('Y-m-d'),
    ];
});
