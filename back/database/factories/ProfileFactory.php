<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'photo' => '',
        'full_name' => $faker->firstName .' '. $faker->lastName,
        'school' => $faker->company,
        'office' => $faker->jobTitle,
    ];
});
