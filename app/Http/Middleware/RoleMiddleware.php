<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    // ACCOUNT APPROVAL CHECK
    if (auth()->user()->status !== 'approved') {

        auth()->logout();

        return redirect('/login')
            ->with('error', 'Account pending approval.');
    }

    // ROLE CHECK
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}
}
