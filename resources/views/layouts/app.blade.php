<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('home.title') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gradient-to-tr from-[#f3f4f9] via-[#eff2f9] to-[#ebf0fa] h-screen overflow-hidden antialiased flex text-slate-800">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/80 backdrop-blur-md border-r border-slate-100 flex flex-col justify-between p-4 z-10">

        <div>
            <div class="flex items-center gap-3 px-3 py-4 mb-6">
                <div
                    class="w-9 h-9 bg-[#6366f1] rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md shadow-indigo-200">
                    <i class="fa-solid fa-brain text-sm"></i>
                </div>
                <span class="font-bold text-slate-800 text-lg tracking-tight">
                    {{ __('home.app_name') }}
                </span>
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

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800">
                    <i class="fa-solid fa-magnifying-glass w-5 text-center text-lg"></i>
                    {{ __('home.search') }}
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800">
                    <i class="fa-solid fa-gear w-5 text-center text-lg"></i>
                    {{ __('home.settings') }}
                </a>

            </nav>
        </div>

        <!-- USER FOOTER -->
        <div class="border-t border-slate-100 pt-4 flex items-center justify-between px-2">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center border border-gray-300">
                    <span class="text-sm font-semibold text-gray-600">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                </div>

                <div class="flex flex-col">
                    <span class="text-sm font-semibold text-slate-800 leading-tight">
                        {{ auth()->user()->name ?? __('home.guest') }}
                    </span>

                    <span class="text-xs text-slate-400 font-medium mt-0.5">
                        {{ __('home.free_plan') }}
                    </span>
                </div>

            </div>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors"
                    title="{{ __('home.logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- HEADER WITH LANGUAGE SWITCHER -->
        <header class="h-20 flex items-center justify-end px-12 pt-4">
            @include('components.lang-switcher')
        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto px-12 pb-12">
            @yield('content')
        </main>

    </div>

</body>

</html>