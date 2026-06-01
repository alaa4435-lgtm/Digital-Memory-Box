@extends('layouts.auth')

    @section('title', __('auth.login'))

    @section('content')
    <div class="glass-card w-full max-w-[760px] flex overflow-hidden shadow-2xl">

        <!-- Left Form Panel -->
        <div class="w-full lg:w-1/2 p-6 md:p-8 flex flex-col justify-center relative bg-white">

            <!-- Small Brand Icon -->
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center mb-8 border border-indigo-100">
                <svg class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.3l6.5 3.6-2.5 1.4-6.5-3.6 2.5-1.4zM4.5 8.1l6.5 3.6v7.3l-6.5-3.6V8.1zm8.5 10.9v-7.3l6.5-3.6v7.3l-6.5 3.6z" />
                </svg>
            </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('auth.welcome_back') }}</h2>
                <p class="text-sm text-gray-500 mb-1">{{ __('auth.login_subtitle') }}</p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-6 border border-red-100">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg mb-6 border border-green-100">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                @csrf

                <div>
                    <label class="input-label">{{ __('auth.email') }}</label>
                    <input type="email" name="email" class="input-field" placeholder="{{ __('auth.email_placeholder') }}"
                        value="{{ old('email') }}" required autofocus>
                </div>

                <div>
                    <label class="input-label">{{ __('auth.password') }}</label>
                    <div class="relative">
                        <input type="password" name="password" class="input-field pr-10" placeholder="{{ __('auth.password_placeholder') }}"
                            required>
                        <!-- Eye icon (decorative) -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm mt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-500 w-4 h-4">
                        <span class="text-gray-700 font-medium">{{ __('auth.remember_me') }}</span>
                    </label>
                    <a href="{{ route('password.request') }}"
                        class="text-indigo-500 hover:text-indigo-600 font-medium transition-colors">{{ __('auth.forgot_password') }}</a>
                </div>

                    <button type="submit" class="btn-primary mt-2">{{ __('auth.login') }}</button>
            </form>

            <div class="relative flex items-center py-6 mt-2">
                <div class="flex-grow border-t border-gray-100"></div>
                <span class="flex-shrink-0 mx-4 text-gray-400 text-xs">{{ __('auth.or_login_with') }}</span>
                <div class="flex-grow border-t border-gray-100"></div>
            </div>

            <a href="/auth/google"
                class="w-full flex items-center justify-center gap-3 border border-[#d2d1d6] bg-white hover:bg-gray-50 text-gray-700 font-medium py-2.5 px-4 rounded-xl transition-colors">

                <!-- Google Icon -->
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        fill="#4285F4" />
                    <path
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        fill="#34A853" />
                    <path
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                        fill="#FBBC05" />
                    <path
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        fill="#EA4335" />
                </svg>

                {{ __('auth.continue_with_google') }}
            </a>

            <p class="text-center text-xs text-gray-500 mt-8">
                {{ __('auth.dont_have_account') }} <a href="{{ route('register') }}"
                    class="text-indigo-500 font-medium hover:underline">{{ __('auth.register_here') }}</a>
            </p>

        </div>

        <!-- Right Decorative Panel -->
        <div class="hidden lg:block lg:w-1/2 bg-[#fdfdfc]">
            @include('partials._decorative-panel')
        </div>
    </div>
@endsection
