<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);

        $access_token = $user->createToken('tokenCreateUser');

        return response(['user' => $user, 'access_token' => $access_token], '200');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $request->merge([
            $login_type => $request->login,
        ]);


        if (Auth::attempt($request->only($login_type, 'password'))) {

            $user = User::find(auth()->user()->id);

            if (isset($user->tokens)) {

                foreach ($user->tokens as $token) {
                    $token->delete();
                }
            }

            $access_token =  $user->createToken('accessToken')->accessToken;
            $user = User::with('profile', 'roles')->find(auth()->user()->id);

            return response(['user' => $user, 'access_token' => $access_token]);
        } else {
            return response()->json(['message' => 'Login ou Senha incorreto!', 'status' => 400]);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout realizado com sucesso!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout'
            ]);
        }
    }

    public function auth()
    {
        if (auth()->check()) {
            $user = User::with('profile', 'roles')->find(auth()->user()->id);
            return response()->json($user, 200);
        }
        return response()->json(['error' => 'sem autorizacao']);
    }
}
