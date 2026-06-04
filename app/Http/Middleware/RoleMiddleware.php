<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is logged in
        if (!Session::has('role')) {
            return redirect('/');
        }

        $userRole = Session::get('role');

        // Check if role is allowed
        if (!in_array($userRole, $roles)) {
            return redirect('/');
        }

        return $next($request);
    }
}