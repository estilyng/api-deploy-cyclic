<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Permission;

$factory->define(Permission::class, function (Faker $faker) {
    $permissions = ['ler', 'alterar', 'deletar', 'criar'];
    return [
        'name' => $faker->randomElement($permissions),
        'guard_name' => 'api',
    ];
});
