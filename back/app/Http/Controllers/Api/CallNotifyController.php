<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class CallNotifyController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);

        return response($user->unreadNotifications);
    }

    public function markOnReadAll()
    {
        $user = User::find(auth()->user()->id);

        $user->unreadNotifications->markAsRead();
        return response($user->unreadNotifications, 200);
    }

    public function markOnRead($id)
    {

        $user = User::find(auth()->user()->id);

        foreach ($user->unreadNotifications as $notification) {
            if ($notification->id == $id) {
                $notification->markAsRead();
            } else continue;
        }

        return response($user->unreadNotifications, 200);
    }
}
