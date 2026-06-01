@extends('layouts.auth')

@section('title', __('auth.register_title'))

@section('content')
    <div class="glass-card w-full max-w-[760px] flex overflow-hidden shadow-2xl">

        <!-- Left Form Panel -->
        <div class="w-full lg:w-1/2 p-4 md:p-6 flex flex-col justify-center relative bg-white">

            <!-- Small Brand Icon -->
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center mb-8 border border-indigo-100">
                <svg class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.3l6.5 3.6-2.5 1.4-6.5-3.6 2.5-1.4zM4.5 8.1l6.5 3.6v7.3l-6.5-3.6V8.1zm8.5 10.9v-7.3l6.5-3.6v7.3l-6.5 3.6z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('auth.create_account') }}</h2>
            <p class="text-sm text-gray-500 mb-8">{{ __('auth.register_subtitle') }}</p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-6 border border-red-100">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
                @csrf

                <div>
                    <label class="input-label">{{ __('auth.full_name') }} *</label>
                    <input type="text" name="name" class="input-field" placeholder="{{ __('auth.full_name_placeholder') }}"
                        value="{{ old('name') }}" required autofocus>
                </div>

                <div>
                    <label class="input-label">{{ __('auth.email') }} *</label>
                    <input type="email" name="email" class="input-field" placeholder="{{ __('auth.email_placeholder') }}"
                        value="{{ old('email') }}" required>
                </div>

                <div>
                    <label class="input-label">{{ __('auth.password') }} *</label>
                    <div class="relative">
                        <input type="password" name="password" class="input-field pr-10"
                            placeholder="{{ __('auth.password_placeholder') }}" required>
                    </div>
                </div>

                <div>
                    <label class="input-label">{{ __('auth.confirm_password') }} *</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" class="input-field pr-10"
                            placeholder="{{ __('auth.confirm_password_placeholder') }}" required>
                    </div>
                </div>

                <div class="flex items-center text-sm mt-2 mb-2">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" name="terms"
                            class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-500 w-4 h-4 mt-0.5" required>
                        <span class="text-gray-500 text-[11px] font-medium leading-tight">
                            {{ __('auth.agree_terms') }}
                            <a href="#" class="text-indigo-500 hover:underline">{{ __('auth.terms') }}</a>
                            {{ __('auth.and') }}
                            <a href="#" class="text-indigo-500 hover:underline">{{ __('auth.privacy') }}</a>
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    {{ __('auth.create_account_btn') }}
                </button>
            </form>

            <p class="text-center text-xs text-gray-500 mt-6">
                {{ __('auth.already_have_account') }}
                <a href="{{ route('login') }}" class="text-indigo-500 font-medium hover:underline">
                    {{ __('auth.login_here') }}
                </a>
            </p>

        </div>

        <!-- Right Decorative Panel -->
        <div class="hidden lg:block lg:w-1/2 bg-[#fdfdfc]">
            @include('partials._decorative-panel')
        </div>
    </div>
@endsection