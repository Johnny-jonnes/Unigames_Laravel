<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManageMiddleware
{
    /**
     * Handle an incoming request.
     * Admin and Staff can manage content. Viewers cannot.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Accès refusé. Vos droits ne vous permettent pas d\'effectuer cette action.');
    }
}
