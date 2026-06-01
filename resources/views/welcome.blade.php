@extends('layouts.auth')

@section('title', __('auth.app_name'))

@section('content')
    <div class="glass-card w-full max-w-[420px] p-8 md:p-10 flex flex-col items-center text-center">

        <!-- Brand Icon -->
        <div
            class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-indigo-100">
            <svg class="w-7 h-7 text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.3l6.5 3.6-2.5 1.4-6.5-3.6 2.5-1.4zM4.5 8.1l6.5 3.6v7.3l-6.5-3.6V8.1zm8.5 10.9v-7.3l6.5-3.6v7.3l-6.5 3.6z" />
            </svg>
        </div>

        <!-- Headings -->
        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ __('auth.app_name') }}</h1>

        <p class="text-sm text-gray-500 mb-8 px-4 leading-relaxed">
            {{ __('auth.app_description') }}
        </p>

        <!-- Buttons -->
        <div class="w-full space-y-3 mb-8">
            <a href="{{ route('register') }}" class="btn-primary flex items-center justify-center gap-2">
                {{ __('auth.create_box') }}
            </a>

            <a href="{{ route('login') }}"
                class="w-full flex items-center justify-center text-gray-700 bg-white border border-[#d2d1d6] hover:bg-gray-50 font-medium py-2.5 px-4 rounded-xl transition-colors">
                {{ __('auth.login') }}
            </a>
        </div>

        <!-- Badges -->
        <div class="flex items-center justify-center gap-6 text-xs text-gray-500 font-medium">

            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                {{ __('auth.private') }}
            </span>

            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                </svg>
                {{ __('auth.secure') }}
            </span>

            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                {{ __('auth.calm') }}
            </span>

        </div>
    </div>

    <!-- Footer Links outside the card -->
    <div
        class="absolute bottom-6 w-full flex justify-center items-center gap-4 text-[11px] text-gray-500 font-medium tracking-wide">

        <a href="#" class="hover:text-gray-900 transition-colors">
            {{ __('auth.privacy') }}
        </a>

        <span class="text-gray-300">&bull;</span>

        <a href="#" class="hover:text-gray-900 transition-colors">
            {{ __('auth.terms') }}
        </a>

        <span class="text-gray-300">&bull;</span>

        <a href="#" class="hover:text-gray-900 transition-colors">
            {{ __('auth.help_center') }}
        </a>
    </div>
@endsection
