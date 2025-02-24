<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param  string  $role 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,$role): Response
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect('/home')->with('error', 'you dont have access to this page');
        }
        return $next($request);
        
    }
}
