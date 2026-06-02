<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function switch($lang)
{
    $supported = ['en', 'ar'];

    if (!in_array($lang, $supported)) {
        abort(404);
    }

    Session::put('locale', $lang);

    if (Auth::check()) {
        Auth::user()->update(['locale' => $lang]);
    }

    return back();
}
}
