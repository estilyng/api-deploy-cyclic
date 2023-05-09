<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

$factory->define(Role::class, function (Faker $faker) {
    $roles = ['administrador', 'direcionador', 'solucionador', 'operador'];
    return [
        'name' => $faker->randomElement($roles),
        'guard_name' => 'api',
    ];
});
