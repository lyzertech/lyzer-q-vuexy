<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // If not logged in
        if (! $user) {
            return redirect('/login');
        }

        // If user role is not allowed
        if (! in_array($user->role_id, $roles)) {
            abort(403,
                "Unauthorized Access.
                This section is reserved for users with the proper permissions.
                Which, unfortunately, does not include you… at least not today."
            );
        }

        return $next($request);
    }
}
