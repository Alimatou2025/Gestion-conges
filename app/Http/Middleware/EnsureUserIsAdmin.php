<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isGestionnaire())) {
            return redirect()->route('login')->with('error', 'Accès réservé à l\'administration.');
        }

        return $next($request);
    }
}
