<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        // إذا المستخدم اختار لغة بروحه
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        else {

            //لغة المتصفح
            $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE') ?? 'en', 0, 2);

            // اللغات المدعومة
            $supported = ['en', 'ar'];

            //تحقق من الدعم
            if (!in_array($browserLocale, $supported)) {
                $browserLocale = config('app.locale'); // default
            }

            App::setLocale($browserLocale);
        }

        return $next($request);
    }

    
}