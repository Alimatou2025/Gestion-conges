<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Accès réservé aux agents.');
        }

        return $next($request);
    }
}
