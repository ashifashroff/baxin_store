<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Baxin Store')</title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        accent: '#2563EB',
                        'text-secondary': '#6B7280',
                        border: '#E5E7EB',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>
<body class="font-sans bg-white text-gray-900 antialiased">

    @include('baxin-modern::layouts.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('baxin-modern::layouts.footer')

    @stack('scripts')
</body>
</html>
