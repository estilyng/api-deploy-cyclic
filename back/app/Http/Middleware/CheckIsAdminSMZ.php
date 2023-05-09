<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsAdminSMZ
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $User = auth()->user();
        if ($User->email != 'manutenção@gmail.com') {
            return redirect('/');
        }
        return $next($request);
    }
}
