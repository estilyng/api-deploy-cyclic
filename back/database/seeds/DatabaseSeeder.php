<?php

use App\Models\Call;
use App\Models\Profile;
use App\Models\Response;
use App\Models\Service;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        factory(User::class, 10)->create()->each(function ($user) {
            factory(Profile::class, 1)->create(['user_id' => $user->id]);

            factory(Role::class, 1)->create()->each(function ($role) use ($user) {
                $user->assignRole($role->name);
            });

            factory(Service::class, 3)->create(['user_id' => $user->id]);

            factory(Call::class, 2)->create(['created_by' => $user->id])->each(function ($call) use ($user) {

                factory(Response::class)->create(['created_by' => $user->id, 'call_id' => $call->id]);
            });

            DB::table('users_calls')->insert([
                'user_id' => User::all()->random()->id,
                'call_id' => Call::all()->random()->id,
            ]);
        });

        // $this->call(RoleSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
