@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto pt-6 animate-fade-in">
    <div class="flex items-center gap-2 text-sm font-medium mb-6">
        <a href="{{ route('settings') }}" class="text-slate-500 hover:text-indigo-600 transition-colors">
            {{ __('settings.title') }}
        </a>
        <i class="fa-solid fa-chevron-right text-xs text-slate-400 rtl:rotate-180"></i>
        <span class="text-slate-800 font-semibold">{{ __('two_factor.title_disable') }}</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-start gap-4 mb-6">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500 border border-red-100/50">
                <i class="fa-solid fa-shield-halved text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800">{{ __('two_factor.title_disable') }}</h1>
                <p class="text-xs text-slate-400 mt-0.5">{{ __('two_factor.desc_disable_warning') }}</p>
            </div>
        </div>

        <form action="{{ route('two-factor.disable.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">{{ __('two_factor.label_password') }}</label>
                <input type="password" name="password" required class="w-full text-sm border @error('password') border-red-400 focus:ring-red-100 focus:border-red-400 @else border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 @enderror rounded-xl p-3 outline-none transition-all">
                @error('password') <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p> @enderror
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-50 mt-6">
                <a href="{{ route('settings') }}" class="w-1/2 p-3 text-center border border-slate-100 text-slate-500 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">{{ __('two_factor.btn_cancel') }}</a>
                <button type="submit" class="w-1/2 bg-red-500 text-white p-3 rounded-xl text-sm font-semibold hover:bg-red-600 shadow-sm transition-colors">{{ __('two_factor.btn_confirm_disable') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection