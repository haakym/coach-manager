<?php

use App\Models\Certificate;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Certificate::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'expiry_date' => Carbon::parse('+1 year'),
        'file' => 'certificates/random-file.pdf',
    ];
});

$factory->state(Certificate::class, 'background-check', [
        'name' => 'DBS Check',
        'type' => 'background-check',
]);

$factory->state(Certificate::class, 'qualification', function () {
    $sports = ['Football', 'Basketball', 'Hockey', 'Tennis', 'Volleyball'];
    $description = $sports[array_rand($sports)] . ' coaching certificate';

    return [
        'name' => 'Coaching certificate',
        'description' => $description,
        'type' => 'qualification',
    ];
});

$factory->state(Certificate::class, 'expired', [
        'expiry_date' => Carbon::parse('-1 month'),
]);
