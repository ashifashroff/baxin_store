<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction ?? 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Baxin Store')</title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Bagisto Default CSS + JS (Vue app, components, product grid) -->
    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'], 'shop')

    <!-- Tailwind CSS CDN (loaded AFTER Bagisto, preflight disabled to avoid conflicts) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false
            },
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        accent: '#2563EB',
                        'accent-hover': '#1d4ed8',
                    },
                    maxWidth: {
                        '8xl': '1320px',
                    }
                }
            }
        }
    </script>

    <!-- Baxin Modern Custom Overrides -->
    <link rel="stylesheet" href="https://baxin.store/themes/baxin-modern/assets/css/app.css">

    @stack('styles')
</head>
<body class="font-sans bg-white text-gray-900 antialiased">

<div id="app">
    @include('baxin-modern::layouts.header')

    <main class="min-h-screen">
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        @yield('content')

        {!! view_render_event('bagisto.shop.layout.body.after') !!}
    </main>

    @include('baxin-modern::layouts.footer')
</div>

    @stack('scripts')
</body>
</html>
