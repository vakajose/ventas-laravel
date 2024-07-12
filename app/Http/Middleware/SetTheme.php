<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('theme')) {
            $theme = Session::get('theme');
            view()->share('theme', $theme);
        } else {
            view()->share('theme', 'system'); // Default to system theme
        }

        return $next($request);
    }
}
