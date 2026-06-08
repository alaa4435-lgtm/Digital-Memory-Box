<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * Send a password reset link to the given user via email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the password reset form for the given token.
     */
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Reset the given user's password.
     */
    public function resetPassword(RestPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', 'Password reset successful')
            : back()->withErrors(['email' => __($status)]);
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required'
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('pin', $request->pin)
            ->first();

        if (!$record) {
            return back()->withErrors(['pin' => 'Invalid PIN']);
        }

        if (now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['pin' => 'PIN expired']);
        }

        return redirect()->route('password.reset', [
            'email' => $request->email
        ]);
    }

}