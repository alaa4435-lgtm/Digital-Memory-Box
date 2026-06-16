<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->two_factor_enabled) {
            
            if (!session()->has('two_factor_authenticated')) {
                if (!$request->is('two-factor/verify*') && !$request->is('two-factor/resend')) {
                    return redirect()->route('two-factor.verify');
                }
            }
        }

        return $next($request);
    }
}
