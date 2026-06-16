@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto pt-4 animate-fade-in">

    {{-- مسار التنقل (Breadcrumbs) والعودة --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2 text-sm font-medium">
            <a href="{{ route('settings') }}" class="text-slate-500 hover:text-indigo-600 transition-colors">
                {{ __('settings.title') }}
            </a>
            <i class="fa-solid fa-chevron-right text-xs text-slate-400 rtl:rotate-180"></i>
            <span class="text-slate-800 font-semibold">
                {{ __('passwords.change_password') }}
            </span>
        </div>
    </div>

    {{-- كرت تغيير كلمة المرور --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm w-full">

        <div class="flex items-start gap-4 mb-6">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100/50">
                <i class="fa-solid fa-lock text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800">
                    {{ __('passwords.change_password') }}
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">
                    {{ __('settings.account_security_desc') }}
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('password.change.update') }}" method="POST" class="w-full space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    {{ __('passwords.current_password') }}
                </label>
                <input
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                    class="w-full text-sm border @error('current_password') border-red-400 focus:ring-red-100 focus:border-red-400 @else border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 @enderror rounded-xl p-3 outline-none transition-all">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    {{ __('passwords.new_password') }}
                </label>
                <input
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    class="w-full text-sm border @error('password') border-red-400 focus:ring-red-100 focus:border-red-400 @else border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 @enderror rounded-xl p-3 outline-none transition-all">
                @error('password')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    {{ __('passwords.confirm_password') }}
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="w-full text-sm border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 rounded-xl p-3 outline-none transition-all">
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-50 mt-6">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-semibold shadow-sm transition-colors">
                    {{ __('passwords.update_password') }}
                </button>

                <a href="{{ route('password.request') }}"
                    class="text-xs text-indigo-500 hover:text-indigo-600 font-semibold transition-colors">
                    {{ __('auth.forgot_password') }}
                </a>
            </div>

        </form>

    </div>
</div>
@endsection