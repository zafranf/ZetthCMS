<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $host = parse_url(url('/'))['host'];
            if (strpos($host, 'admin') !== false) {
                return redirect('/dashboard');
            }

            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}
