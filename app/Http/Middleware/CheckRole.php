<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $roles)) {
            if ($user->role == 'administrador'){
                return redirect('/dashboard');
            }elseif (($user->role == 'cliente')){
                return redirect('/reservations');
            }
            return redirect('/'); // Redirigir a la página principal si el usuario no tiene acceso
        }

        return $next($request);
    }
}
