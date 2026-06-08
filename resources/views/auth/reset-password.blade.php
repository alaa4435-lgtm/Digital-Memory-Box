@extends('layouts.auth')

@section('title', __('auth.reset_password_title'))

@section('content')
<div class="glass-card w-full max-w-[420px] p-8 md:p-10 flex flex-col items-center">
    
    <!-- Brand Icon -->
    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 border border-indigo-100">
        <svg class="w-6 h-6 text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.3l6.5 3.6-2.5 1.4-6.5-3.6 2.5-1.4zM4.5 8.1l6.5 3.6v7.3l-6.5-3.6V8.1zm8.5 10.9v-7.3l6.5-3.6v7.3l-6.5 3.6z"/>
        </svg>
    </div>

    <h2 class="text-xl font-bold text-gray-900 mb-2">
        {{ __('auth.reset_password') }}
    </h2>

    <p class="text-xs text-gray-500 mb-8 text-center">
        {{ __('auth.reset_password_hint') }}
    </p>

    @if ($errors->any())
        <div class="w-full bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-6 border border-red-100">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="w-full flex flex-col gap-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div>
            <label class="input-label">
                {{ __('auth.email') }}
            </label>

            <input type="email" name="email" class="input-field"
                placeholder="{{ __('auth.enter_email') }}"
                value="{{ request()->email }}"
                required autofocus>
        </div>
        
        <div>
            <label class="input-label">
                {{ __('auth.new_password') }}
            </label>

            <div class="relative">
                <input type="password" name="password"
                    class="input-field pr-10"
                    placeholder="{{ __('auth.create_password') }}"
                    required>

                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <label class="input-label">
                {{ __('auth.confirm_password') }}
            </label>

            <div class="relative">
                <input type="password" name="password_confirmation"
                    class="input-field pr-10"
                    placeholder="{{ __('auth.confirm_password_placeholder') }}"
                    required>

                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary mt-2">
            {{ __('auth.reset_password_btn') }}
        </button>
    </form>
</div>
@endsection