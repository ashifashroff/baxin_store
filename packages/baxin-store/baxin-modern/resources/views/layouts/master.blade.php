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

    <!-- Tailwind CSS CDN (for our custom styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        accent: '#2563EB',
                        'text-secondary': '#6B7280',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif !important; }
        .baxin-header { background: #fff; border-bottom: 1px solid #f0f0f0; position: sticky; top: 0; z-index: 50; }
        .baxin-nav a { color: rgba(255,255,255,0.85); text-decoration: none; font-size: 13px; font-weight: 500; padding: 8px 14px; border-radius: 4px; transition: all 0.15s; }
        .baxin-nav a:hover, .baxin-nav a.active { background: rgba(255,255,255,0.1); color: #f5a623; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>

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
