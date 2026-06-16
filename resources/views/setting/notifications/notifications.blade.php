@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pt-4 animate-fade-in">

        <div id="toast-success" class="fixed bottom-5 end-5 hidden transform translate-y-10 opacity-0 transition-all duration-300 ease-out z-50">
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-lg">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span id="toast-message" class="text-sm font-semibold"></span>
            </div>
        </div>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                {{ __('settings.notifications_title') }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('settings.notifications_subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">

            {{-- Unified Dynamic Sidebar Navigation --}}
            <x-settings-sidebar />

            {{-- Main Content Column --}}
            <div class="md:col-span-3 space-y-6">

                {{-- Notifications Section Card --}}
                <div id="notifications" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-bell text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                {{ __('settings.notifications') }}
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ __('settings.notifications_desc') }}
                            </p>
                        </div>
                    </div>

                    <form id="notifications-settings-form" action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="notification_settings_submitted" value="1">

                        <div class="space-y-4">
                            {{-- Email Notifications Toggle --}}
                            <div class="flex items-center justify-between pb-4 border-b border-slate-50">
                                <div>
                                    <span class="text-sm font-bold text-slate-800 block">
                                        {{ __('settings.email_notifications') }}
                                    </span>
                                    <span class="text-xs text-slate-400 mt-0.5">
                                        {{ __('settings.email_notifications_desc') }}
                                    </span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications" value="1" id="email-checkbox"
                                        {{ (auth()->user()->email_notifications ?? true) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>

                            {{-- Push Notifications Toggle --}}
                            <div class="flex items-center justify-between pt-2">
                                <div>
                                    <span class="text-sm font-bold text-slate-800 block">
                                        {{ __('settings.push_notifications') }}
                                    </span>
                                    <span class="text-xs text-slate-400 mt-0.5">
                                        {{ __('settings.push_notifications_desc') }}
                                    </span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="push_notifications" value="1" id="push-checkbox"
                                        {{ (auth()->user()->push_notifications ?? false) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </form>
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
    const emailCheckbox = document.getElementById('email-checkbox');
    const pushCheckbox = document.getElementById('push-checkbox');
    const form = document.getElementById('notifications-settings-form');
    
    const toast = document.getElementById('toast-success');
    const toastMessage = document.getElementById('toast-message');

    function showToast(message) {
        if (!toast || !toastMessage) return;
        toastMessage.innerText = message;
        toast.classList.remove('hidden');
        
        setTimeout(() => {
            toast.classList.remove('translate-y-10', 'opacity-0');
        }, 10);

        setTimeout(() => {
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300);
        }, 3000);
    }

    function sendSettingsPayload() {
        const formData = new FormData(form);

        // نرسل true أو false نصية ليقوم لارافيل بلقطها عبر دالة $this->boolean() بنجاح
        formData.set('email_notifications', emailCheckbox.checked ? '1' : '0');
        formData.set('push_notifications', pushCheckbox.checked ? '1' : '0');

        // جلب التوكن الحقيقي من الفورم لضمان تخطي حماية CSRF
        const token = form.querySelector('input[name="_token"]')?.value;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                // في حال حدوث خطأ 500 أو غيره، اطبعه في الكونسول لمعاينته
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // عرض الرسالة المترجمة القادمة من السيرفر مباشرة
                showToast(data.message);
            }
        })
        .catch(error => console.error('Error saving settings:', error));
    }

    if (emailCheckbox && pushCheckbox) {
        emailCheckbox.addEventListener('change', sendSettingsPayload);
        pushCheckbox.addEventListener('change', sendSettingsPayload);
    }
});
</script>
@endsection