<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class AdminMiddleware
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
        if(Auth::check()) {
            // Super Admin = 1, Admin = 2, Employee = 3
            switch (Auth::user()->role_id) {
                case 1:
                    return $next($request);
                    break;
                case 2:
                    return $next($request);
                    break;
                case 3:
                    abort(403);
                    break;

                default:
                    abort(403);
                    break;
            }
        } else {
            abort(403);
        }
    }
}
