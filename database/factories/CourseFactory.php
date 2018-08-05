<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Course::class, function (Faker $faker) {
    $dateFrom = Carbon::parse('+1 month');
    $dateTo = $dateFrom->addDay(3);

    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
        'address' => $faker->address,
        'date_from' => $dateFrom,
        'date_to' => $dateTo,
    ];
});
