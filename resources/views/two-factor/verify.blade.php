@extends('layouts.auth')
@section('content')
<div class="max-w-md mx-auto pt-12">
    <div class="bg-white rounded-2xl border border-slate-100 p-8 shadow-md text-center">
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-key text-2xl"></i>
        </div>
        <h2 class="text-xl font-bold text-slate-800 mb-2">{{ __('two_factor.title_verify') }}</h2>
        <p class="text-xs text-slate-400 mb-6">{{ __('two_factor.desc_verify') }}</p>

        @if(session('success'))
            <div class="bg-green-50 text-green-600 text-xs p-3 rounded-xl mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('two-factor.verify.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <input type="text" name="code" autofocus placeholder="000000" class="w-full border border-slate-200 rounded-xl p-3 text-center tracking-widest font-bold text-xl outline-none focus:border-indigo-500">
                @error('code') <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">{{ __('two_factor.btn_verify_login') }}</button>
        </form>
        <form id="resend-form" action="{{ route('two-factor.resend') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="block w-full text-center text-xs text-indigo-600 hover:text-indigo-700 transition-colors">{{ __('two_factor.btn_resend') }}</button>
        </form>
    </div>
</div>
@endsection