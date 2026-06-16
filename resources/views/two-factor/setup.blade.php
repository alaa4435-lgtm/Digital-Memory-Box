@extends('layouts.auth')
@section('content')
<div class="max-w-md mx-auto pt-6 animate-fade-in">
    {{-- Breadcrumbs --}}
    <div class="flex items-center gap-2 text-sm font-medium mb-6">
        <a href="{{ route('settings') }}" class="text-slate-500 hover:text-indigo-600 transition-colors">
            {{ __('settings.title') }}
        </a>
        <i class="fa-solid fa-chevron-right text-xs text-slate-400 rtl:rotate-180"></i>
        <span class="text-slate-800 font-semibold">{{ __('two_factor.title_setup') }}</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fa-solid fa-envelope text-lg"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-800">{{ __('two_factor.title_setup') }}</h2>
        </div>
        
        <p class="text-xs text-slate-400 mb-6 leading-relaxed">
            {{ __('two_factor.desc_setup') }} <strong>{{ auth()->user()->email }}</strong>. {{ __('two_factor.desc_setup_check') }}
        </p>

        <form action="{{ route('two-factor.setup.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">{{ __('two_factor.label_code') }}</label>
                <input type="text" name="code" placeholder="000000" class="w-full border border-slate-200 rounded-xl p-3 text-center tracking-widest font-bold text-lg outline-none focus:border-indigo-500 @error('code') border-red-500 @enderror">
                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex gap-3 pt-2">
                <a href="{{ route('settings') }}" class="w-1/2 p-3 text-center border border-slate-100 text-slate-500 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">{{ __('two_factor.btn_cancel') }}</a>
                <button type="submit" class="w-1/2 bg-indigo-600 text-white p-3 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm transition-colors">{{ __('two_factor.btn_confirm') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection