<?php

namespace App\Http\Middleware;

use Closure;

class CheckCandidate
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
        if (auth()->check() && auth()->user()->is_company != 0) {
            return redirect()->intended(route('index'));
        }
        return $next($request);
    }
}
