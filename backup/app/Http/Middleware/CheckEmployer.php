<?php

namespace App\Http\Middleware;

use Closure;

class CheckEmployer
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
        if (auth()->check() && auth()->user()->is_company != 1) {
            return redirect()->intended(route('index'));
        }
        return $next($request);
    }
}
