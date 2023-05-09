<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('profile', 'roles')->get();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['min:8', 'confirmed'],
            'password_confirmation' => ['min:8'],
            'full_name' => ['required', 'string', 'max:255'],
            'school' => ['required', 'string', 'max:255'],
            'office' => ['required', 'string', 'max:255'],
        ]);


        if ($validatedData) {

            $user = DB::transaction(function () use ($request) {

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' =>  bcrypt($request->password),
                ]);

                $user->profile()->create($request->only([
                    'full_name',
                    'school',
                    'office',
                ]));

                $user->assignRole($request->roles);

                foreach ($user->roles as $role) {
                    if ($role->name == 'solucionador') {
                        $user->profile->update(['driver' => true]);
                    }
                }

                return $user;
            });
        }

        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['string', 'min:8', 'confirmed'],
            'profile.full_name' => ['required', 'string', 'max:255'],
            'profile.school' => ['required', 'string', 'max:255'],
            'profile.office' => ['required', 'string', 'max:255'],
        ]);

        if ($request->password) $request['password'] = bcrypt($request->password);

        if ($validatedData) {
            $user = DB::transaction(function () use ($request, $user) {
                $user->profile()->update($request->profile);
                // $user->syncRoles($request->roles);

                foreach ($user->roles as $role) {
                    $user->removeRole($role);
                }

                $user->assignRole($request->roles);

                $user->update($request->all());

                foreach ($user->roles as $role) {
                    if ($role->name == 'solucionador') {
                        $user->profile->update(['driver' => true]);
                    } else {
                        $user->profile->update(['driver' => null]);
                    }
                }

                return $user;
            });
        }

        return response()->json($user);
    }

    public function updateAtivated(User $user, Request $request)
    {
        $driver = empty($request->driver) ? false : true;
        $user->profile->update(['driver' => $driver]);
        return response($user->profile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // return response($user);
        $user->profile->delete();
        // $user->roles()->delete();
        $user->delete();
        return response()->json(200);
    }
}
