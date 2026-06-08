<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Memory;
use App\Models\User;
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

        return redirect()->route('dashboard');
    }

    public function login(UserLoginRequest $request)
{
    $credentials = $request->validated();

    if (Auth::guard('web')->attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::guard('web')->user();

        if (!$user->locale) {
            $user->update([
                'locale' => app()->getLocale(),
            ]);
        }

        return redirect()->intended(route('dashboard'));
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

    return redirect()->route('login');
}

 public function me(Request $request)
{
    $user = Auth::guard('web')->user();

    return response()->json([
        'message' => 'User profile',
        'data' => $user,
        'locale' => $user->locale,
    ]);
}

    public function dashboard()
    {
        $memories = Memory::where('user_id', Auth::id())->latest()->get();
        $mediaCount = $memories->whereIn('media_type', ['image', 'video','audio', 'text'])->count();
        $totalEntriesCount = $memories->count();
        $favoritesCount = $memories->where('is_favorite', true)->count();
        return view('dashboard.index', compact('memories', 'mediaCount', 'totalEntriesCount', 'favoritesCount'));
    }
}