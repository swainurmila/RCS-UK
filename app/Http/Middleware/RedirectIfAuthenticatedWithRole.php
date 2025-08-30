<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedWithRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Check if the current route is one of the guest-only routes
            if ($request->is('login.view') || $request->is('registration') || $request->is('forgot.password')) {
                // Redirect the logged-in user to their dashboard based on their role
                if (Auth::user()->role_id == 1) {
                    return redirect()->route('society.dashboard');
                } else {
                    return redirect()->route('official.dashboard');
                }
            }
        }
        return $next($request);
    }
}
