<?php

namespace App\Http\Middleware;

use Closure;

class UserHasStoreMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) //Vai passar por aqui sempre que a loja for criada pra ver se ele ja n possui loja. Obs: Tem que registrar no kernel
    {

        if(auth()->user()->store()->count()) {
            
            flash('Você já possui uma loja!')->warning();

            return redirect()->route('admin.stores.index');
        }

        return $next($request);
    }
}
