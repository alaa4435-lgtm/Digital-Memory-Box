@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pt-4 animate-fade-in">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                {{ __('settings.security_title') }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('settings.security_subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <x-settings-sidebar />
            <div class="md:col-span-3 space-y-6">
                <div id="security" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-lock text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                {{ __('settings.account_security') }}
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ __('settings.account_security_desc') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        {{-- Password Row --}}
                        <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-slate-800">
                                    {{ __('settings.password') }}
                                </span>
                                <span class="text-xs text-slate-400 mt-0.5">
                                    {{ __('settings.password_last_changed') }}
                                </span>
                            </div>
                            <button type="button" onclick="window.location.href='{{ route('password.change') }}'"
                                class="px-4 py-2 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
                                {{ __('settings.update_password') }}
                            </button>
                        </div>

                        {{-- 2FA Row --}}
                        <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-slate-800">
                                    {{ __('settings.two_factor_authentication') }}
                                </span>
                                <span class="text-xs mt-0.5 {{ auth()->user()->two_factor_enabled ? 'text-emerald-500 font-medium' : 'text-slate-400' }}">
                                    @if(auth()->user()->two_factor_enabled)
                                        <i class="fa-solid fa-circle-check text-xs mr-1"></i>
                                        {{ __('two_factor.status_enabled') }}
                                    @else
                                        {{ __('settings.two_factor_desc') }}
                                    @endif
                                </span>
                            </div>

                            @if(auth()->user()->two_factor_enabled)
                                <a href="{{ route('two-factor.disable') }}"
                                    class="px-3 py-2 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                                    {{ __('two_factor.btn_cancel') }}
                                </a>
                            @else
                                <a href="{{ route('two-factor.setup') }}"
                                    class="px-4 py-2 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
                                    {{ __('settings.enable_2fa') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Footer Action Buttons Strip --}}
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <a href="{{ route('help-center') }}"
                        class="flex items-center justify-center gap-2 p-3.5 bg-white border border-slate-100 text-slate-600 rounded-2xl text-sm font-semibold shadow-sm hover:bg-slate-50 transition-colors">
                        <i class="fa-regular fa-circle-question text-base"></i>
                        <span>{{ __('settings.help_support') }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 p-3.5 bg-red-50/50 border border-red-100 text-red-500 rounded-2xl text-sm font-semibold shadow-sm hover:bg-red-50 transition-colors">
                            <i class="fa-solid fa-right-from-bracket text-base"></i>
                            <span>{{ __('settings.logout') }}</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection