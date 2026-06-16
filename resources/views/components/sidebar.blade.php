<aside class="w-64 bg-white/80 backdrop-blur-md border-r border-slate-100 flex flex-col justify-between p-4 z-10">

    <div>
        <div class="flex items-center gap-3 px-3 pt-4 mb-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center border border-indigo-100 shrink-0 hover:bg-indigo-100 transition-colors">
        <svg class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.3l6.5 3.6-2.5 1.4-6.5-3.6 2.5-1.4zM4.5 8.1l6.5 3.6v7.3l-6.5-3.6V8.1zm8.5 10.9v-7.3l6.5-3.6v7.3l-6.5 3.6z" />
        </svg>
    </div>

    <span class="font-bold text-slate-800 text-lg tracking-tight whitespace-nowrap">
        {{ __('home.app_name') }}
    </span>
</a>
        </div>

        <nav class="space-y-1">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl
                {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-lg"></i>
                {{ __('home.dashboard') }}
            </a>

            <a href="{{ route('memories.create') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl
                {{ request()->routeIs('memories.create') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <i class="fa-solid fa-circle-plus w-5 text-center text-lg"></i>
                {{ __('home.add_memory') }}
            </a>

            <a href="{{ route('memories.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl
                {{ request()->routeIs('memories.index') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <i class="fa-solid fa-box-archive w-5 text-center text-lg"></i>
                {{ __('home.my_memories') }}
            </a>

            <a href="{{ route('memories.search') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl
                {{ request()->routeIs('memories.search') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <i class="fa-solid fa-magnifying-glass w-5 text-center text-lg"></i>
                {{ __('home.search') }}
            </a>

            <a href="{{ route('settings') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl
                {{ request()->routeIs('settings*') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <i class="fa-solid fa-gear w-5 text-center text-lg"></i>
                {{ __('home.settings') }}
            </a>

        </nav>
    </div>

    <div class="border-t border-slate-100 pt-4 flex items-center justify-between px-2 relative">

        <button id="userMenuBtn" class="flex items-center gap-3 text-right focus:outline-none group flex-1">
            <div
                class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 border border-gray-300 group-hover:border-indigo-300 transition-colors flex items-center justify-center">

                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover"
                        alt="avatar">
                @else
                    <span class="text-sm font-semibold text-gray-600">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                @endif

            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <span class="text-sm font-semibold text-slate-800 leading-tight truncate">
                    {{ auth()->user()->name ?? __('home.guest') }}
                </span>
                <span class="text-xs text-slate-400 font-medium mt-0.5">
                    {{ __('home.free_plan') }}
                </span>
            </div>

            <i class="fa-solid fa-chevron-up text-xs text-slate-400 mr-1 transition-transform duration-200"
                id="userMenuArrow"></i>
        </button>

        <div id="userDropdown"
            class="hidden absolute bottom-full left-4 right-4 mb-2 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">

            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                <i class="fa-solid fa-user text-base w-5 text-center"></i>
                {{ __('home.profile') }}
            </a>

            <a href="{{ route('settings') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                <i class="fa-solid fa-gear text-base w-5 text-center"></i>
                {{ __('home.settings') }}
            </a>

            <hr class="border-slate-100 my-1">

            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50 transition-colors text-right">
                    <i class="fa-solid fa-right-from-bracket text-base w-5 text-center"></i>
                    {{ __('home.logout') }}
                </button>
            </form>
        </div>

    </div>

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('userMenuBtn');
        const dropdown = document.getElementById('userDropdown');
        const arrow = document.getElementById('userMenuArrow');

        if (btn && dropdown) {
            btn.addEventListener('click', function (event) {
                event.stopPropagation();
                dropdown.classList.toggle('hidden');
                if (arrow) arrow.classList.toggle('rotate-180');
            });

            document.addEventListener('click', function (event) {
                if (!dropdown.contains(event.target) && !btn.contains(event.target)) {
                    dropdown.classList.add('hidden');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            });
        }
    });
</script>