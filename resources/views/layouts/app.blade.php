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
            font-size: 100%;
            transition: font-size 0.3s ease;
        }
        .reduce-motion-active *,
        .reduce-motion-active button,
        .reduce-motion-active a,
        .reduce-motion-active input,
        .reduce-motion-active [role="button"] {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    </style>

    <script>
        (function () {
            const userTypographySize = {{ auth()->user()->typography_size ?? 2 }};
            const userReduceMotionSetting = {{ auth()->user()->reduce_motion ?? 0 }};
            
            if (userTypographySize == 1) document.documentElement.style.fontSize = '14px';
            else if (userTypographySize == 3) document.documentElement.style.fontSize = '18px';
            else document.documentElement.style.fontSize = '16px';

            if (userReduceMotionSetting == 1) {
                document.documentElement.classList.add('reduce-motion-active');
            }
        })();
    </script>
</head>

<body
    class="bg-gradient-to-tr from-[#f3f4f9] via-[#eff2f9] to-[#ebf0fa] h-screen overflow-hidden antialiased flex text-slate-800">

    @include('components.sidebar')

    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <header class="h-20 flex items-center justify-end px-12 pt-4">
            @include('components.lang-switcher')
        </header>

        <main class="flex-1 overflow-y-auto px-12 pb-12">
            @yield('content')
        </main>

    </div>
    <script src="{{ asset('js/speech-search.js') }}"></script>
</body>

</html>