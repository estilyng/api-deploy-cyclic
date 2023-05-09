<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::find(auth()->user()->id);

        return response()->json([
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

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
                
                // $request->except('photo');
                
                $user->profile()->update($request->profile);

                $user->update($request->all());

                return $user;
            });
        }

        return response()->json($request->all(), 200);
    }

    public function storagePhoto(Request $request)
    {
        if (auth()->check()) {
            $user = User::find(auth()->user()->id);

            if (isset($user->profile->photo)) {
                Storage::delete('public/' . $user->profile->photo);
            }

            if ($request->hasFile('file')) {

                $path = $request->file('file')->store('public/profiles/' . auth()->user()->id);

                $path = str_replace('public/', '', $path);
                $user->profile()->update(['photo' => $path]);

                return response()->json(['success' => 'upload efetuado com sucesso!']);
            }
        } else {
            return response()->json(['error' => 'usuário não está logado']);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
