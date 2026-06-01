<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('auth.app_name'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        indigo: {
                            500: '#6366f1',
                            600: '#4f46e5',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            /* Pastel gradient background matching screenshots */
            background: linear-gradient(135deg, #f2f7fb 0%, #fef3e9 25%, #fefcf3 50%, #eff7fe 75%, #f6effb 100%);
            background-attachment: fixed;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        .input-field {
            width: 100%;
            border: 1px solid #d2d1d6;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 14px;
            background: transparent;
            transition: 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 1px #6366f1;
        }

        .input-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .btn-primary {
            width: 100%;
            background-color: #6366f1;
            color: white;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 12px;
            transition: 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center font-sans antialiased text-gray-900 relative p-4 lg:p-8">

    <div class="absolute top-6 right-6 z-50" dir="ltr">
    <div class="relative w-[150px] h-[38px] bg-white/60 backdrop-blur-md rounded-full border border-white/30 shadow-sm flex items-center p-1 overflow-hidden">

        <div class="absolute top-1 bottom-1 w-[72px] bg-indigo-600 rounded-full transition-all duration-300 ease-in-out
            {{ app()->getLocale() == 'ar' ? 'translate-x-[72px]' : 'translate-x-0' }}">
        </div>

        <a href="{{ url('/lang/en') }}"
            class="relative z-10 flex-1 text-center text-xs font-medium transition-colors duration-300
            {{ app()->getLocale() == 'en' ? 'text-white' : 'text-gray-600' }}">
            English
        </a>

        <a href="{{ url('/lang/ar') }}"
            class="relative z-10 flex-1 text-center text-xs font-medium transition-colors duration-300
            {{ app()->getLocale() == 'ar' ? 'text-white' : 'text-gray-600' }}">
            العربية
        </a>

    </div>
</div>

    @yield('content')
</body>
</html>
