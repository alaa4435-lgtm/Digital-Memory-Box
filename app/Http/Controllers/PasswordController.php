<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function verifyPin(VerifyPinRequest $request)
    {
        $validated = $request->validated();
        $record = DB::table('password_resets')
            ->where('email', $validated['email'])
            ->where('pin', $validated['pin'])
            ->first();

        if (!$record) {
            return back()->withErrors(['pin' => 'Invalid PIN']);
        }

        if (now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['pin' => 'PIN expired']);
        }

        return redirect()->route('password.reset', [
            'email' => $validated['email']
        ]);
    }

    public function showChangePassword()
    {
        return view('user.change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', __('passwords.password_updated_successfully'));
    }
}
