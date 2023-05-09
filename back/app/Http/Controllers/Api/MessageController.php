<?php

namespace App\Http\Controllers\Api;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class MessageController extends Controller
{

    public function getUsersOfChat()
    {
        // get usuarios solucionadores
        $solvers_users = User::with([
            'roles' => function ($query) {
                return $query->where('name', 'solucionador');
            }, 'messages'
        ])
            ->where('id', '!=', auth()->user()->id)
            ->get()
            ->filter(fn ($user) => $user->roles->isNotEmpty());

        // get usuarios all
        $users = User::with([
            'messages',
            'roles' => function ($query) {
                return $query->where('name', '!=', 'solucionador');
            }
        ])
            ->where('id', '!=', auth()->user()->id)
            ->get()
            ->filter(fn ($user) => $user->roles->isNotEmpty());

        // preparando array all_users
        $all_users = [];
        foreach ($users as $user) {
            array_push($all_users, $user);
        }

        // preparando array usersSolvers
        $usersSolvers = [];
        foreach ($solvers_users as $user) {
            array_push($usersSolvers, $user);
        }

        $auth_is_solver = User::find(auth()->user()->id)->roles->contains('name', 'solucionador');
        $auth_is_admin = User::find(auth()->user()->id)->roles->contains('name', 'administrador');

        if ($auth_is_solver || $auth_is_admin) {
            return response()->json(['chatUsers' => $all_users]);
        } else {
            return response()->json(['chatUsers' => $usersSolvers]);
        }
    }

    public function getMessages()
    {
        $messages = Message::all();
        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create($request->all());

        Event::dispatch(new SendMessage($message));

        return response('success', 200);
    }
}
