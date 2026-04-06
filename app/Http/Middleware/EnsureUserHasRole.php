<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        $hasRole = $user->roles()
            ->whereIn('name', $roles)
            ->exists();

        if (!$hasRole) {
            abort(403);
        }

        return $next($request);
    }
}
