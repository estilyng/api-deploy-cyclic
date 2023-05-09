<?php

namespace App\Observers;

use App\Models\Call;
use App\User;

class CallObserver
{
    /**
     * Handle the call "created" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function created(Call $call)
    {
        $call->created_by = auth()->check() ? auth()->user()->id : null;
        $call->save();

        // direciona chamado para o solucionador que tiver menos chamados
        $users = User::with([
            'roles' => function ($query) {
                $query->where('name', 'solucionador');
            },
        ])->get();

        $countCalls = [];
        foreach ($users as $user) {
            if ($user->roles->isNotEmpty() && $user->profile->driver) {
                array_push($countCalls, $user->calls->count());
            }
        }
        
        foreach ($users as $user) {

            if ($user->roles->isNotEmpty() && $user->profile->driver) {

                if (($user->calls->count() <= min($countCalls))) {
                    $user->calls()->attach($call->id);
                    $call->statu = 'andamento';
                    $call->save();
                    break;
                }
            }
        }
    }

    /**
     * Handle the call "updated" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function updated(Call $call)
    {
        $call->updated_by = auth()->check() ? auth()->user()->id : null;
    }

    /**
     * Handle the call "deleted" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function deleted(Call $call)
    {
        //
    }

    /**
     * Handle the call "restored" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function restored(Call $call)
    {
        //
    }

    /**
     * Handle the call "force deleted" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function forceDeleted(Call $call)
    {
        //
    }
}
