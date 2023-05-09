<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Call;
use Faker\Generator as Faker;

$factory->define(Call::class, function (Faker $faker) {
    $prioritys = ['Alta', 'Média', 'Baixa', 'Urgente'];
    $status = ['a iniciar', 'concluído', 'andamento', 'atrasado', 'cancelado', 'paralisado'];
    $destinys = ['Dpto Tecnologia da Informação', 'Setor Manutenção/Zeladoria'];
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text,
        'term' => rand(1, 10),
        'destiny' => $faker->randomElement($destinys),
        'initials' => 'DTI',
        'priority' => $faker->randomElement($prioritys),
        'statu' => $faker->randomElement($status)
    ];
});
