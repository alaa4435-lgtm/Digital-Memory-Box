<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Memory;
use App\Models\User;
use App\Notifications\SendTwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            ...$request->validated(),
            'locale' => app()->getLocale(),
        ]);

        Auth::guard('web')->login($user);

        if ($user->two_factor_enabled) {
            $code = rand(100000, 999999);

            $user->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);

            $user->notify(new SendTwoFactorCode($code));

            return redirect()->route('two-factor.verify');
        }

        return redirect()->route('dashboard');
    }

public function login(UserLoginRequest $request)
{
    $credentials = $request->validated();

    if (Auth::guard('web')->attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::guard('web')->user();

        // تحديث لغة المستخدم إن لم تكن موجودة
        if (!$user->locale) {
            $user->update([
                'locale' => app()->getLocale(),
            ]);
        }

        if ($user->two_factor_enabled) {
            
            $code = rand(100000, 999999);

            $user->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);
            $user->notify(new SendTwoFactorCode($code));

            return redirect()->route('two-factor.verify');
        }

        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => __('auth.failed'),
    ]);
}
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->forget('two_factor_authenticated');

        return redirect()->route('login');
    }

    public function me(Request $request)
    {
        $user = Auth::guard('web')->user();

        return response()->json([
            'message' => __('auth.user_profile'),
            'data' => $user,
            'locale' => $user->locale,
        ]);
    }

    public function dashboard()
{
    $user = Auth::user();

    $memories = $user->memories()->with('media')->latest()->get();

    $photosVideosCount = $memories->pluck('media')->collapse()->count();

    $totalEntriesCount = $memories->count();

    $favoritesCount = $memories->where('is_favorite', true)->count();

    return view('dashboard.index', compact(
        'memories', 
        'photosVideosCount', 
        'totalEntriesCount', 
        'favoritesCount'
    ));
}
    
}
