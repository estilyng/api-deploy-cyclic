<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Response;
use Faker\Generator as Faker;

$factory->define(Response::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence(),
        'rating' => rand(1, 5),
        'posted' => true
    ];
});
