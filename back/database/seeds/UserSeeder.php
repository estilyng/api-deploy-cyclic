<?php

use App\Models\Profile;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user ADMINISTRADOR
        User::create([
            'name' => 'superadministrador',
            'email' => 'superadm@gmail.com',
            'email_verified_at' => now(),
            'password' =>  bcrypt('super@123'), 
            'remember_token' => Str::random(10),
        ])->each( function ($user){
            $user->assignRole('administrador');
            factory(Profile::class, 1)->create(['user_id' => $user->id]);
            $user->assignRole('administrador');
        });
    }
}
