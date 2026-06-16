@extends('layouts.auth')

@section('title', __('auth.forgot_password_title'))

@section('content')
    <div class="glass-card w-full max-w-[420px] p-8 md:p-10 flex flex-col items-center">

        <!-- Brand Icon -->
        <a href="{{ auth()->check() ? url('/dashboard') : url('/') }}"
            class="block w-fit transform hover:scale-105 transition duration-200">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 border border-indigo-100">
                <svg class="w-6 h-6 text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.3l6.5 3.6-2.5 1.4-6.5-3.6 2.5-1.4zM4.5 8.1l6.5 3.6v7.3l-6.5-3.6V8.1zm8.5 10.9v-7.3l6.5-3.6v7.3l-6.5 3.6z" />
                </svg>
            </div>
        </a>

        <h2 class="text-xl font-bold text-gray-900 mb-2">
            {{ __('auth.forgot_password') }}
        </h2>

        <p class="text-xs text-gray-500 mb-8 text-center px-2">
            {{ __('auth.forgot_password_hint') }}
        </p>

        @if ($errors->any())
            <div class="w-full bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-6 border border-red-100">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="w-full bg-green-50 text-green-600 text-sm p-3 rounded-lg mb-6 border border-green-100">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="w-full flex flex-col gap-5">
            @csrf

            <div>
                <label class="input-label">
                    {{ __('auth.email') }}
                </label>

                <input type="email" name="email" class="input-field" placeholder="{{ __('auth.enter_email') }}" required
                    autofocus>
            </div>

            <button type="submit" class="btn-primary mt-2">
                {{ __('auth.send_reset_link') }}
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-gray-500">
            @auth            
                <a href="{{ url('/change-password') }}"
                    class="text-indigo-500 font-medium hover:underline inline-flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    {{ __('passwords.back_to_changepassword') }}
                </a>
            @else
                {{ __('auth.remember_password') }}
                <a href="{{ route('login') }}" class="text-indigo-500 font-medium hover:underline">
                    {{ __('auth.login_here') }}
                </a>
            @endauth
        </div>
    </div>
@endsection