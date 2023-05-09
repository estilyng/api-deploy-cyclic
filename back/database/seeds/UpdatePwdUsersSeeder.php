<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdatePwdUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->update(['password' => Hash::make('12345678')]);

        foreach (User::all() as $user) {
            $user->password = bcrypt(12345678);
            $user->save();
        }
    }
}
