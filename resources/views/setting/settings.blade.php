@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pt-4 animate-fade-in">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                {{ __('settings.title') }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('settings.subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">

            <x-settings-sidebar />

            <div class="md:col-span-3 space-y-6">
                <div id="general" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-globe text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                {{ __('settings.language_preferences') }}
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ __('settings.language_preferences_desc') }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label onclick="window.location='{{ url('/lang/en') }}'"
                            class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all duration-200
                                {{ app()->getLocale() == 'en' ? 'border-indigo-100 bg-indigo-50/30 ring-1 ring-indigo-100' : 'border-slate-100 hover:bg-slate-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🇺🇸</span>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ __('settings.english') }}
                                    </span>
                                    <span class="text-xs text-slate-400 mt-0.5">
                                        {{ __('settings.default') }}
                                    </span>
                                </div>
                            </div>
                            <input type="radio" name="language" value="en" {{ app()->getLocale() == 'en' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 pointer-events-none">
                        </label>

                        {{-- كرت اللغة العربية --}}
                        <label onclick="window.location='{{ url('/lang/ar') }}'"
                            class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all duration-200
                                {{ app()->getLocale() == 'ar' ? 'border-indigo-100 bg-indigo-50/30 ring-1 ring-indigo-100' : 'border-slate-100 hover:bg-slate-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🇱🇾</span>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ __('settings.arabic') }}
                                    </span>
                                    <span class="text-xs text-slate-400 mt-0.5">
                                        {{ __('settings.rtl_support') }}
                                    </span>
                                </div>
                            </div>
                            <input type="radio" name="language" value="ar" {{ app()->getLocale() == 'ar' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 pointer-events-none">
                        </label>
                    </div>
                </div>

                {{-- Appearance Section --}}
                <div id="appearance" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-palette text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                {{ __('settings.interface_customization') }}
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ __('settings.interface_customization_desc') }}
                            </p>
                        </div>
                    </div>

                    {{-- Info Alert --}}
                    <div class="flex items-center gap-3 bg-indigo-50/50 border border-indigo-100/70 text-indigo-900 p-3.5 rounded-xl text-xs mb-6">
                        <i class="fa-solid fa-circle-info text-indigo-500 text-sm"></i>
                        <p>{{ __('settings.theme_restriction_notice') }}</p>
                    </div>

                    {{-- Interface Action Form Wrapper --}}
                    <form id="ui-settings-form" action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="interface_settings_submitted" value="1">

                        {{-- Typography Size Range Slider Setup --}}
                        <div class="mb-6">
                            <span class="text-sm font-bold text-slate-800 block mb-4">
                                {{ __('settings.typography_size') }}
                            </span>
                            <div class="px-2">
                                <input type="range" name="typography_size" min="1" max="3" 
                                    value="{{ auth()->user()->typography_size ?? 2 }}"
                                    id="typography-slider"
                                    class="w-full h-1 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <div class="flex justify-between items-center text-slate-400 font-medium mt-2">
                                    <span class="text-sm font-medium">A</span>
                                    <span class="text-[11px]" id="typography-label"></span>
                                    <span class="text-lg font-medium">A</span>
                                </div>
                            </div>
                        </div>

                        {{-- Reduce Motion Control Element Toggle --}}
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div>
                                <span class="text-sm font-bold text-slate-800 block">
                                    {{ __('settings.reduce_motion') }}
                                </span>
                                <span class="text-xs text-slate-400 mt-0.5">
                                    {{ __('settings.reduce_motion_desc') }}
                                </span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="reduce_motion" value="1" id="motion-checkbox"
                                    {{ (auth()->user()->reduce_motion ?? false) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                {{-- Security Section --}}
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

                        <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-slate-800">
                                    {{ __('settings.two_factor_authentication') }}
                                </span>
                                <span
                                    class="text-xs mt-0.5 {{ auth()->user()->two_factor_enabled ? 'text-emerald-500 font-medium' : 'text-slate-400' }}">
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('typography-slider');
    const label = document.getElementById('typography-label');
    const motionCheckbox = document.getElementById('motion-checkbox');
    const form = document.getElementById('ui-settings-form');

    // Mapped localized variables dynamically using Blade syntax inside the script tags
    const sizeLabels = {
        1: "{{ __('settings.size_small') }}",
        2: "{{ __('settings.size_medium') }}",
        3: "{{ __('settings.size_large') }}"
    };

    label.textContent = sizeLabels[slider.value];

    function applyClientUIChanges() {
        const sizeVal = slider.value;
        label.textContent = sizeLabels[sizeVal];

        if (sizeVal == 1) document.documentElement.style.fontSize = '14px';
        else if (sizeVal == 3) document.documentElement.style.fontSize = '18px';
        else document.documentElement.style.fontSize = '16px';

        if (motionCheckbox.checked) {
            document.documentElement.classList.add('reduce-motion-active');
        } else {
            document.documentElement.classList.remove('reduce-motion-active');
        }
    }

    function sendSettingsPayload() {
        applyClientUIChanges();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Preferences updated dynamically:', data.message);
        })
        .catch(error => console.error('Error saving settings payload:', error));
    }

    slider.addEventListener('input', applyClientUIChanges);
    slider.addEventListener('change', sendSettingsPayload);
    motionCheckbox.addEventListener('change', sendSettingsPayload);
});
</script>
@endsection