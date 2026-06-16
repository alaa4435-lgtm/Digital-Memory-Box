<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->with(['prompt' => 'select_account consent'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'password' => bcrypt(Str::random(24)),
                    'locale' => session('locale', app()->getLocale()),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, true);

            if ($user->two_factor_enabled) {
                $code = rand(100000, 999999);

                $user->update([
                    'two_factor_code' => $code,
                    'two_factor_expires_at' => now()->addMinutes(10),
                ]);

                $user->notify(new \App\Notifications\SendTwoFactorCode($code));

                return redirect()->route('two-factor.verify');
            }

            return redirect()->intended(route('dashboard'));

        } catch (\Exception $e) {
            return redirect('/login')
                ->with('error', __('auth.google_login_failed'));
        }
    }
}