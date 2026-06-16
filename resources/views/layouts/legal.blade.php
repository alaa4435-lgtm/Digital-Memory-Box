<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('auth.app_name'))</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #f2f7fb 0%, #fef3e9 25%, #fefcf3 50%, #eff7fe 75%, #f6effb 100%);
            background-attachment: fixed;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="min-h-screen font-sans text-gray-900 p-3 lg:p-7">

    <div class="absolute top-6 right-6 z-50" dir="ltr">
        @include('components.lang-switcher')
    </div>

    <div class="max-w-2xl mx-auto mt-14">

        <div class="glass-card p-5 lg:p-7">

            <a href="{{ auth()->check() ? url('/dashboard') : url('/') }}"
                class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 transition font-medium">
                <span>{{ __('auth.back_home') }}</span>
            </a>

            <div class="flex justify-center gap-5 mb-5 text-sm border-b pb-4">

                <a href="{{ url('/help-center') }}"
                    class="{{ request()->is('help-center') ? 'text-indigo-600 font-semibold' : 'text-gray-500' }}">
                    {{ __('auth.help_center') }}
                </a>

                <a href="{{ url('terms-of-service') }}"
                    class="{{ request()->is('terms-of-service') ? 'text-indigo-600 font-semibold' : 'text-gray-500' }}">
                    {{ __('auth.terms') }}
                </a>

                <a href="{{ url('privacy-policy') }}"
                    class="{{ request()->is('privacy-policy') ? 'text-indigo-600 font-semibold' : 'text-gray-500' }}">
                    {{ __('auth.privacy') }}
                </a>

            </div>

            <div class="flex justify-center mb-5">
                <a href="{{ auth()->check() ? url('/dashboard') : url('/') }}" class="block transform hover:scale-105 transition duration-200">
                    <div class="w-11 h-11 bg-white rounded-2xl shadow-md flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" class="w-6 h-6" alt="logo">
                    </div>
                </a>
            </div>

            @yield('content')

        </div>

    </div>

</body>
</html>