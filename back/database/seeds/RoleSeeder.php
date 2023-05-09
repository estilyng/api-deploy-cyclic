<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'administrador', 'guard_name' => 'api']);
        Role::create(['name' => 'direcionador', 'guard_name' => 'api']);
        Role::create(['name' => 'operador', 'guard_name' => 'api']);
        Role::create(['name' => 'solucionador', 'guard_name' => 'api']);
    }
}
