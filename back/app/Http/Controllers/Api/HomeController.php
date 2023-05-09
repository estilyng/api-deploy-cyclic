<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\User;

class HomeController extends Controller
{
    public function statusAllCalls()
    {
        $calls = Call::all('statu');

        $progress = count($calls->filter(function (Call $call) {
            return $call->statu == 'andamento';
        }));
        $starting = count($calls->filter(function (Call $call) {
            return $call->statu == 'a iniciar';
        }));
        $concluded = count($calls->filter(function (Call $call) {
            return $call->statu == 'concluído';
        }));
        $late = count($calls->filter(function (Call $call) {
            return $call->statu == 'atrasado';
        }));
        $canceled = count($calls->filter(function (Call $call) {
            return $call->statu == 'cancelado';
        }));
        $paralyzed = count($calls->filter(function (Call $call) {
            return $call->statu == 'paralisado';
        }));

        return response()->json([
            ['text' => 'andamento', 'value' => $progress, 'color' => '#FFF9C4'],
            ['text' => 'iniciar', 'value' => $starting, 'color' => '#43A047'],
            ['text' => 'concluido', 'value' => $concluded, 'color' => '#C6FF00'],
            ['text' => 'atrasado', 'value' => $late, 'color' => '#EF9A9A'],
            ['text' => 'cancelado', 'value' => $canceled, 'color' => '#BBDEFB'],
            ['text' => 'paralisado', 'value' => $paralyzed, 'color' => '#FFEB3B'],
        ]);
    }


    public function callsUserSolver()
    {
        $users = User::with(['roles' => function ($query) {
            $query->where('name', 'solucionador');
        }, 'calls'])->get();


        $results = [];
        foreach ($users as $user) {

            if ($user->roles->isNotEmpty()) {
                $progress = count($user->calls->filter(function (Call $call) {
                    return $call->statu == 'andamento';
                }));
                $starting = count($user->calls->filter(function (Call $call) {
                    return $call->statu == 'a iniciar';
                }));
                $concluded = count($user->calls->filter(function (Call $call) {
                    return $call->statu == 'concluído';
                }));
                $late = count($user->calls->filter(function (Call $call) {
                    return $call->statu == 'atrasado';
                }));
                $canceled = count($user->calls->filter(function (Call $call) {
                    return $call->statu == 'cancelado';
                }));
                $paralyzed = count($user->calls->filter(function (Call $call) {
                    return $call->statu == 'paralisado';
                }));


                array_push($results, [
                    'user' => $user->name,
                    'role' => $user->roles->where('name', 'solucionador')->pluck('name'),
                    'progress' =>  $progress,
                    'starting' =>  $starting,
                    'concluded' =>  $concluded,
                    'late' =>  $late,
                    'canceled' =>  $canceled,
                    'paralyzed' =>  $paralyzed,
                ]);
            } else continue;
        }

        return response()->json($results);
    }


    public function callsUserAuth()
    {
        $user = User::find(auth()->user()->id);

        return response()->json([
            'concluded' => ['value' => $user->calls()->where('statu', 'concluído')->count(), 'color' => '#C6FF00'],
            'paralyzed' => ['value' => $user->calls()->where('statu', 'paralisado')->count(), 'color' => '#FFEB3B'],
            'canceled' => ['value' => $user->calls()->where('statu', 'cancelado')->count(), 'color' => '#BBDEFB'],
            'late' => ['value' => $user->calls()->where('statu', 'atrasado')->count(), 'color' => '#EF9A9A'],
            'starting' => ['value' => $user->calls()->where('statu', 'a iniciar')->count(), 'color' => '#43A047'],
            'progress' => ['value' => $user->calls()->where('statu', 'andamento')->count(), 'color' => '#FFF9C4'],
        ]);
    }

    public function detailsCallsPerSolver($id)
    {
        $user = User::find($id);
        return response($user->calls);
    }
}
