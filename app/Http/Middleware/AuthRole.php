<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if($role == 'manager' && Auth::user()->role != 'manager') {
            abort(403);
        }

        if($role == 'admin' && Auth::user()->role != 'admin') {
            abort(403);
        }

        if($role == 'student' && Auth::user()->role != 'student') {
            abort(403);
        }

        return $next($request);
    }
}
