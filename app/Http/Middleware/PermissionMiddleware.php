<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        if ($user->hasRole('admin')) {
            return $next($request);
        }

        if (!$user->can($permission)) {
            abort(403, 'You do not have permission to access this.');
        }

        return $next($request);
    }
}
