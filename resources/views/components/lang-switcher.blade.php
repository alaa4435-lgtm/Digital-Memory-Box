<div dir="ltr" class="inline-block">
    <div class="relative w-[150px] h-[38px] bg-white/70 backdrop-blur-md rounded-full border border-white/40 shadow-sm flex items-center p-1 overflow-hidden">
        
        <div class="absolute top-1 bottom-1 w-[68px] bg-indigo-600 rounded-full transition-all duration-300 ease-in-out
            {{ app()->getLocale() == 'ar' ? 'translate-x-[72px]' : 'translate-x-0' }}">
        </div>

        <a href="{{ url('/lang/en') }}"
            class="relative z-10 flex-1 text-center text-xs font-semibold tracking-wide transition-colors duration-300 select-none
            {{ app()->getLocale() == 'en' ? 'text-white' : 'text-slate-500 hover:text-slate-800' }}">
            English
        </a>

        <a href="{{ url('/lang/ar') }}"
            class="relative z-10 flex-1 text-center text-xs font-semibold tracking-wide transition-colors duration-300 select-none
            {{ app()->getLocale() == 'ar' ? 'text-white' : 'text-slate-500 hover:text-slate-800' }}">
            العربية
        </a>

    </div>
</div>