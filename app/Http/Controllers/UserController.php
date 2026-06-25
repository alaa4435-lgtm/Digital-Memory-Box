<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMemoryRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    public function changePassword()
    {
        return view('setting.General.change-password');
    }

    /**
     * Update user profile
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        if ($request->hasFile('avatar')) {

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')
                ->store('profile/avatars', 'public');
        }

        if ($request->hasFile('background_image')) {

            if ($user->background_image) {
                Storage::disk('public')->delete($user->background_image);
            }

            $validated['background_image'] = $request->file('background_image')
                ->store('profile/backgrounds', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('profile')
            ->with('success', __('settings.settings_updated_successfully'));
    }
    public function settings()
    {
        $user = Auth::user();
        return view('setting.General.general', compact('user'));
    }
}
