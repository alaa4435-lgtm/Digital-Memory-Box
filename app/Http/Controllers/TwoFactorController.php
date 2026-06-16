<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendTwoFactorCode;

class TwoFactorController extends Controller
{
    public function setupForm(Request $request)
    {
        $user = $request->user();
        $code = rand(100000, 999999);

        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10)
        ]);

        $user->notify(new SendTwoFactorCode($code));

        return view('two-factor.setup');
    }

    public function setup(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        $user = $request->user();

        if ($user->two_factor_code === $request->code && now()->lessThan($user->two_factor_expires_at)) {
            $user->update([
                'two_factor_enabled' => true,
                'two_factor_code' => null,
                'two_factor_expires_at' => null
            ]);

            session(['two_factor_authenticated' => true]);

            return redirect()->route('settings')->with('success', __('two_factor.success_enabled'));
        }

        return back()->withErrors(['code' => __('two_factor.invalid_code')]);
    }

    public function disableForm() {
        return view('two-factor.disable');
    }

    public function disable(Request $request)
    {
        $request->validate(['password' => 'required|current_password']);

        $request->user()->update([
            'two_factor_enabled' => false,
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        return redirect()->route('settings')->with('success', __('two_factor.success_disabled'));
    }

    public function verifyForm() {
        return view('two-factor.verify');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        $user = $request->user(); 

        if ($user->two_factor_code === $request->code && now()->lessThan($user->two_factor_expires_at)) {
            $user->update([
                'two_factor_code' => null,
                'two_factor_expires_at' => null
            ]);

            session(['two_factor_authenticated' => true]);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => __('two_factor.invalid_code')]);
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if (!$user->two_factor_enabled) {
            return redirect()->route('login');
        }

        $code = rand(100000, 999999);

        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10)
        ]);

        $user->notify(new SendTwoFactorCode($code));

        return back()->with('success', __('two_factor.code_resent'));
    }
}