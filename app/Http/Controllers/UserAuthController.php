<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class UserAuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        // create user
        $user = User::create($request->validated());
        Auth::login($user);
        // return token
        return redirect('/dashboard');
    }

    public function login(UserLoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials',
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
        ], 200);
    }
    
    public function dashboard()
    {
        return view('Authentication.dashboard');
    }

}
