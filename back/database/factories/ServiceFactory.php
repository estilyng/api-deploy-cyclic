<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    $prioritys = ['Alta', 'Baixa', 'Média', 'Urgente'];
    $initials = ['DTI', 'SMZ'];
    $destinys = ['Dpto Tecnologia da Informação', 'Setor Manutenção/Zeladoria'];
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->sentence,
        'destiny' => $faker->randomElement($destinys),
        'term' =>  rand(1, 10),
        'initials' => $faker->randomElement($initials),
        'priority' => $faker->randomElement($prioritys),
    ];
});
