<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Notifications\CallNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        foreach ($user->calls as $call) {
            if ($call->created_at->addDays($call->term) < now()) {
                if ($call->statu === 'andamento') {
                    $call->update(['statu' => 'atrasado']);
                }
            }
        }

        $callsOfUser = $user->calls()->with('users')->orderBy('id', 'desc')->get();
        $callsAll = Call::with('users')->orderBy('id', 'desc')->get();

        $rolesOfUser = collect($user->roles)->contains('name', 'administrador') ||  collect($user->roles)->contains('name', 'direcionador');

        return response()->json($rolesOfUser ? $callsAll : $callsOfUser);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $call = DB::transaction(function () use ($request) {

            $call = Call::create($request->all());
            $call->users()->attach(auth()->user()->id);

            // acionando notificacao
            $users = User::with([
                'roles' => function ($query) {
                    $query->where('name', 'direcionador')->orWhere('name', 'administrador');
                },
            ])->get();

            foreach ($users as $user) {
                if ($user->roles->isNotEmpty()) {
                    $user->notify(new CallNotification($call));
                } else continue;
            }

            return $call;
        });

        return response($call, 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call)
    {
        return response()->json($call, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Call $call)
    {
        $validated = $request->validate([
            'destiny' => ['required', 'string', 'max:100'],
            'initials' => ['required', 'string', 'max:30'],
            'name' => ['required', 'string', 'max:100'],
            'priority' => ['required', 'string', 'max:30'],
            'statu' =>  ['required', 'string', 'max:30'],
            'term' =>  ['required', 'integer'],
            'description' => ['required', 'string'],
        ]);
        // return response()->json($validated, 200);

        if ($validated) {
            DB::transaction(function () use ($request, $call) {
                $request->priority = strtolower($request->priority);
                $call->update($request->all());
                return $call;
            });

            return response()->json($call, 200);
        }
    }

    public function directSolver(Request $request, $id)
    {
        $call = Call::find($id);

        $queryDifferent = DB::table('users_calls')->where('call_id', $call->id)->where('user_id', '!=', $call->created_by)->get();

        // add solver
        if ($request->user_id) {
            $user = User::find($request->user_id);

            if (count($queryDifferent) == 0) {
                $exists = $call->users()->where('user_id', $call->created_by)->get();
                if (count($exists) > 0) {
                    // add novo chamado ao user requisitado pelo app
                    $call->users()->attach($user->id);
                    $user->notify(new CallNotification($call));
                } else {
                    // se ñ houver nenhum chamado, add chamado ao call_created_by e user solver
                    $call->users()->attach(User::find($call->created_by)->id);
                    $call->users()->attach($user->id);
                    $user->notify(new CallNotification($call));
                }
            } elseif (count($queryDifferent) !== 0) {
                // atualza caso ja haja um solver
                DB::table('users_calls')->where('call_id', $call->id)
                    ->where('user_id', '!=', $call->created_by)->update([
                        'user_id' => $user->id,
                        'call_id' => $call->id,
                    ]);
                $user->notify(new CallNotification($call));
            }
        } else {
            // delete solver
            $user = $call->users()->where('user_id', '!=', $call->created_by)->first();

            DB::table('users_calls')->where('call_id', $call->id)
                ->where('user_id', '!=', $call->created_by)->where('user_id', $user->id)->delete();
        }
    }

    public function showSolver($call_id)
    {
        $call = Call::find($call_id);
        $solver = $call->users()->where('user_id', '!=', $call->created_by)->first();
        return response()->json($solver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call)
    {
        if ($call->statu == "concluído") {

            if (isset($call->images)) {
                FacadesStorage::deleteDirectory('calls/' . $call->id);
            }

            if (isset($call->responses)) $call->responses()->delete();

            if (isset($call->images)) $call->images()->delete();

            $call->delete();

            return response(200);
        } else {
            return response()->json(['errors' => ['Chamado "' . $call->id . ' - ' . $call->name . '" não foi concluído!']], 423);
        }
    }
}
