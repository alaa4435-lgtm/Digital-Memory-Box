<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }
    public function callback()
    {
        try {
            // 1. استقبال بيانات المستخدم من جوجل
            $googleUser = Socialite::driver('google')->stateless()->user();

            // 2. إنشاء المستخدم أو تحديث بياناته إذا كان مسجلاً مسبقاً
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    // يمكنك تخزين الـ google_id أيضاً إذا كان متوفراً في قاعدة بياناتك
                    // 'google_id' => $googleUser->id, 
                    'password' => bcrypt(str()->random(16)),
                ]
            );

            // 3. تسجيل دخول المستخدم في تطبيقك
            Auth::login($user);

            // 4. توجيهه إلى لوحة التحكم (Dashboard)
            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            // في حال حدوث خطأ أثناء الاتصال بجوجل، وجهه لصفحة تسجيل الدخول مع رسالة خطأ
            return redirect('/login')->with('error', 'Something went wrong with Google login.');
        }
    }
}
