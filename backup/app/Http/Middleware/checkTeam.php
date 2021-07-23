<?php

namespace App\Http\Middleware;

use Closure;

class checkTeam
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
        if (auth()->check() && auth()->user()->type == 1) {
            return redirect()->route('team.dashboard', auth()->user()->id);
        }
        return $next($request);
    }
}
