{{-- resources/views/components/settings-sidebar.blade.php --}}
<div class="bg-white/80 backdrop-blur-md border border-slate-100 rounded-2xl p-3 space-y-1 shadow-sm">
    <a href="{{ route('settings') }}"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('settings') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }} transition-all">
        <i class="fa-solid fa-sliders text-base"></i>
        <span>{{ __('settings.general') }}</span>
    </a>
    <a href="{{ route('settings.appearance') }}"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('settings.appearance') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }} transition-all">
        <i class="fa-solid fa-palette text-base"></i>
        <span>{{ __('settings.appearance') }}</span>
    </a>
    <a href="{{ route('settings.notifications') }}"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('settings.notifications') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }} transition-all">
        <i class="fa-solid fa-bell text-base"></i>
        <span>{{ __('settings.notifications') }}</span>
    </a>
    <a href="{{ route('settings.security') }}"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('settings.security') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }} transition-all">
        <i class="fa-solid fa-shield-halved text-base"></i>
        <span>{{ __('settings.security') }}</span>
    </a>
</div>