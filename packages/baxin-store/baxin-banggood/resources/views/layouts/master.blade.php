<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Baxin Store — RC Toys & Gadgets')</title>
    <meta name="description" content="@yield('meta_description', 'Shop RC Drones, Robots, Vehicles & Parts at Baxin Store. Best prices, fast shipping.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('themes/baxin-banggood/assets/images/favicon.svg') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bagisto Vue App CSS (required for cart/checkout components) --}}
    @bagistoVite()

    {{-- Tailwind CDN (loaded AFTER Bagisto to avoid conflicts) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        accent: '#f97316',
                        'accent-hover': '#ea580c',
                    },
                    maxWidth: { '8xl': '1400px' },
                }
            }
        }
    </script>

    {{-- Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('themes/baxin-banggood/assets/css/app.css') }}">

    @stack('styles')
</head>
<body class="bg-white text-gray-900 font-sans antialiased">

    {{-- Top Announcement Bar --}}
    @include('baxin-banggood::layouts.announcement-bar')

    {{-- Header --}}
    @include('baxin-banggood::layouts.header')

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('baxin-banggood::layouts.footer')

    {{-- Theme JS --}}
    <script src="{{ asset('themes/baxin-banggood/assets/js/app.js') }}" defer></script>

    @stack('scripts')

    {{-- Toast container --}}
    <div id="toast-container" class="fixed bottom-4 right-4 z-[9999] flex flex-col gap-2"></div>
</body>
</html>
