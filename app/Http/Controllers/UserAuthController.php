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
    public function register(UserRegisterRequest $request)
    {
        // إنشاء الحساب وإضافة اللغة الحالية تلقائياً
        $user = User::create([...$request->validated(), 'locale' => app()->getLocale()]);
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function login(UserLoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user && !$user->locale) {
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
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'message' => 'User profile',
            'data' => $user,
            'locale' => $user->locale,
        ], 200);
    }

    public function dashboard()
    {
        $memories = Memory::where('user_id', auth()->id())->latest()->get();
        $photosVideosCount = $memories->whereIn('media_type', ['image', 'video'])->count();
        $totalEntriesCount = $memories->count();

        return view('Dashboard.index', compact('memories', 'photosVideosCount', 'totalEntriesCount'));
    }
}