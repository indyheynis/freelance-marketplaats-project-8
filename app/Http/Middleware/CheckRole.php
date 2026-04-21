<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
  public function handle(Request $request, Closure $next,  ...$roles): Response //...$roles maakt het mogelijk om meerdere rollen te accepteren
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
