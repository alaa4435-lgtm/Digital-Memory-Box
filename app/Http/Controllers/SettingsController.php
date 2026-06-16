<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Show general user settings panel.
     */
    public function index()
    {
        $user = Auth::user();
        return view('setting.settings', compact('user'));
    }

    /**
     * Show appearance settings panel.
     */
    public function appearance()
    {
        $user = Auth::user();
        return view('setting.appearance.blade', compact('user'));
    }
    public function notifications()
    {
        $user = Auth::user();
        return view('setting.notifications.notifications', compact('user'));
    }
    /**
     * Show security settings panel.
     */
    public function security()
    {
        $user = Auth::user();
        return view('setting.security.security', compact('user'));
    }

    public function update(UpdateSettingsRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('settings.Settings updated successfully')
            ]);
        }

        return back()->with('success', __('settings.Settings updated successfully'));
    }
}
