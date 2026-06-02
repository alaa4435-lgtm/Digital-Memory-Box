<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    $locale = null;

    // 1. user locale (highest priority)
    if (Auth::check() && Auth::user()->locale) {
        $locale = Auth::user()->locale;
    }

    // 2. session locale
    elseif (Session::has('locale')) {
        $locale = Session::get('locale');
    }

    // 3. browser locale
    else {
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE') ?? 'en', 0, 2);

        $supported = ['en', 'ar'];

        $locale = in_array($browserLocale, $supported)
            ? $browserLocale
            : config('app.locale');
    }

    App::setLocale($locale);

    return $next($request);
}
}
