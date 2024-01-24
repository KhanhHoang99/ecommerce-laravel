<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if(auth()->check()) {
            // Check if user là user
            if(auth()->user()->level == 0) {

                return $next($request);
            } else {

                return redirect()->route('userPage')->with('error', 'You do not have permission to access this page.');
            }
        }

        return redirect()->route('login');
    }
}
